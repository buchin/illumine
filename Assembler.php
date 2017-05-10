<?php namespace Illumine\Framework;

//Illuminate
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Cookie\CookieJar;
use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Events\Dispatcher;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Facades\Facade;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;

//IllumineFramework
use Illumine\Framework\Factories\AdminFactory;
use Illumine\Framework\Factories\ShortcodeFactory;
use Illumine\Framework\Factories\WidgetFactory;
use Illumine\Framework\Traits\AccessibleTrait;

class Assembler
{

    protected static $instances = array();
    public $plugin;
    protected $this, $pluginDirectory;
    use AccessibleTrait;

    /**
     * Plugin Constructor
     * @param $dir
     */
    public function __construct($dir)
    {
        $this->pluginDirectory = $dir;
        $this->plugin = new Container;
        $this->plugin->flush(); //Ensure Container is Empty
        $this->plugin->routeDispatched = false;

        $this->setFacadeApp();
        $this->bindConfig();
        $this->bindExceptions();
        $this->bindDatabase();
        $this->bindFileSystem();
        $this->setInstance();
        $this->hookSchema();
        $this->bindEvents();
        $this->bindRequest();
        $this->bindResponse();
        $this->bindViews();

    }

    /**
     * Set Faux Facade App w/ Plugin Container
     * (Allows Facade Class Usage)
     */
    public function setFacadeApp()
    {
        Facade::setFacadeApplication($this->plugin);
    }

    /**
     * Get Config Repository
     */
    private function bindConfig()
    {


        //Bind Configuration Repo
        $this->plugin->bind('config', function () {
            return new Repository(require trailingslashit(plugin_dir_path($this->pluginDirectory)) . 'config.php');
        }, true);

        //Set Config Paths
        $this->plugin['config']->set('base', trailingslashit(plugin_dir_path($this->pluginDirectory)));
        $this->plugin['config']->set('public', trailingslashit(plugin_dir_url($this->pluginDirectory)));
    }

    /**
     * Get Database Class to Container
     */
    private function bindDatabase()
    {

        //Bind Eloquent
        if ($this->plugin['config']->get('database.enabled')) {
            global $wpdb; //Get wpdb Object
            $database = new Database();
            $database->addConnection([
                'driver' => 'mysql',
                'host' => DB_HOST,
                'database' => DB_NAME,
                'username' => DB_USER,
                'password' => DB_PASSWORD,
                'charset' => $wpdb->charset,
                'collation' => $wpdb->collate,
                'prefix' => $wpdb->prefix,
            ]);

            //Make Database Global
            $database->setAsGlobal();

            //Setup the Eloquent ORM
            $database->bootEloquent();

            //Setup Database Event Dispatcher
            $database->setEventDispatcher(new Dispatcher($this->plugin));

            $this->plugin->bind('db', function () use ($database) {
                return $database->getDatabaseManager();
            }, true);
        }
    }

    /**
     * Bind FileSystem Class to Container
     */
    private function bindFileSystem()
    {
        //Illuminate
        with(new FilesystemServiceProvider($this->plugin))->register();
    }

    /**
     * Hook Schema Into Activate, DeActivate & UnInstall
     * (Allows Schema Class Usage)
     */
    public function hookSchema()
    {

        register_activation_hook($this->plugin['config']->get('base') . '/plugin.php', array($this->plugin['config']->get('namespace') . '\Wordpress\Activate', 'init'));
        register_deactivation_hook($this->plugin['config']->get('base') . '/plugin.php', array($this->plugin['config']->get('namespace') . '\Wordpress\DeActivate', 'init'));
        register_uninstall_hook($this->plugin['config']->get('base') . '/plugin.php', array($this->plugin['config']->get('namespace') . '\Wordpress\UnInstall', 'init'));

    }

    /**
     * Bind Events Class to Container
     */
    private function bindEvents()
    {
        with(new EventServiceProvider($this->plugin))->register();
    }

    /**
     * Bind Request Class to Container
     */
    private function bindRequest()
    {
        //Bind Request to Container
        $this->plugin->instance('request', Request::capture());
    }

    /**
     * Get Response Class to Container
     */
    private function bindResponse()
    {
        $this->plugin->instance('response', new Response());
    }

    /**
     * Bind Views Class to Container
     */
    private function bindViews()
    {
        //IllumineFramework
        with(new ViewServiceProvider($this->plugin))->register();
    }

    /**
     * Bind Cache Class to Container
     */
    private function bindCache()
    {
        if ($this->plugin['config']->get('cache.enabled')) {
            with(new CacheServiceProvider($this->plugin))->register();
        }
    }

    /**
     * Bind CookieJar Class to Container
     */
    private function bindCookieJar()
    {
        //Bind CookieJar to Container
        if ($this->plugin['config']->get('session.enabled')) {
            $this->plugin->bind('cookie', function () {
                $cookieJar = new CookieJar();
                $cookieJar->setDefaultPathAndDomain(
                    $this->plugin['config']->get('session.path'),
                    $this->plugin['config']->get('session.domain'),
                    $this->plugin['config']->get('session.secure')
                );
                return $cookieJar;
            }, true);
        }
    }

    /**
     * Bind Session Class to Container
     */
    private function bindSession()
    {

        if ($this->plugin['config']->get('session.enabled')) {

            with(new SessionServiceProvider($this->plugin))->register();

            //Start Session
            if (!$this->plugin['session']->isStarted()) {

                //Detect Session ID from Cookies
                if (isset($_COOKIE[$this->plugin['config']->get('session.cookie')])) {

                    //Set Session ID from Existing Cookie if Available
                    $this->plugin['session']->setId($_COOKIE[$this->plugin['config']->get('session.cookie')]);

                } else {

                    //Create new Session ID and Set Cookie
                    $cookie = $this->plugin['cookie']->make($this->plugin['session']->getName(), $this->plugin['session']->getId(), 3600);
                    setcookie($cookie->getName(),
                        $cookie->getValue(),
                        $cookie->getExpiresTime(),
                        $cookie->getPath(),
                        $cookie->getDomain(),
                        $cookie->isSecure(),
                        $cookie->isHttpOnly());
                }

                //Start the Session
                $this->plugin['session']->start();

                //Regenerate CSRF token with each request
                if ($this->plugin['request']->method() == 'GET') {
                    $this->plugin['session']->regenerateToken();
                }

                //Save the Session State
                $this->plugin['session']->save();
            }
        }
    }

    /**
     * Bind Validator Class to Container
     */
    private function bindValidator()
    {
        if ($this->plugin['config']->get('database.enabled') && $this->plugin['config']->get('validator.enabled')) {

            $this->plugin->singleton('translator', function () {
                return new Translator(new FileLoader($this->plugin['files'], 'language'), $this->plugin['config']->get('validator.locale'));
            });

            with(new ValidationServiceProvider($this->plugin))->register();
        }
    }

    /**
     * Bind Custom Provider Classes to Container
     */
    private function bindProviders()
    {

        //Count Providers Array in Config
        if (count($this->plugin['config']->get('providers')) > 0) {

            foreach ($this->plugin['config']->get('providers') as $namespace) {

                if ($this->plugin['config']->get('encryption.enabled') && $namespace == \Illuminate\Encryption\Encrypter::class) {

                    //If Illuminate\Encryption Provider Bind with Key & Cipher
                    $this->plugin->bind('encrypter', function () use ($namespace) {
                        return new $namespace($this->plugin['config']->get('encryption.key'), $this->plugin['config']->get('encryption.cipher'));
                    });

                } else {

                    //Bind Normally
                    with(new $namespace($this->plugin))->register();

                }
            }
        }
    }


    /**
     * Bind Exceptions Class to Container
     */
    private function bindExceptions()
    {
        $this->plugin->bind('exception', function(){
            return new \Illumine\Framework\Support\ExceptionHandler();
        });
    }


    /**
     * Bind Router Class to Container
     */
    private function bindRouter()
    {
        if ($this->plugin['config']->get('routes.enabled')) {
            with(new RoutingServiceProvider($this->plugin))->register();
        }
    }

    /**
     * Load Routes into Router
     */
    private function loadRoutes()
    {

        if ($this->plugin['config']->get('routes.enabled')) {


            /**
             * Use Cached Routes if Available
             */
            if ($this->plugin['config']->get('routes.cache') && $this->plugin['files']->exists($this->plugin['config']->get('routes.compiled'))) {

                $contents = $this->plugin['files']->get($this->plugin['config']->get('routes.compiled'));

                if (!empty($contents)) {
                    //Get Cached Routes & Set Them
                    $this->plugin['router']->setRoutes(unserialize(base64_decode($contents)));
                }
            } else {
                //Assign Router to Simple Variable for Include
                $route = $this->plugin['router'];
                $response = $this->plugin['response'];

                //Include Routes
                require_once $this->plugin['config']->get('base') . '/app/Http/routes.php';
            }

            /**
             * Store Cached Routes
             */
            if ($this->plugin['config']->get('routes.cache') && !$this->plugin['files']->exists($this->plugin['config']->get('routes.compiled'))) {

                try {

                    //Set Routes Cache
                    if (!$this->plugin['files']->exists($this->plugin['config']->get('routes.compiled'))) {
                        $allRoutes = $this->plugin['router']->getRoutes();

                        //If Routes then Serialize
                        if (count($allRoutes) > 0) {
                            foreach ($allRoutes as $routeObject) {
                                $routeObject->prepareForSerialization();
                            }
                        }
                        //Store Routes in Cache
                        $this->plugin['files']->put($this->plugin['config']->get('routes.compiled'), base64_encode(serialize($allRoutes)));
                    }
                } catch (\Exception $exception) {

                    if (!empty($exception->getMessage())) {

                        add_action('admin_notices', function () use ($exception) {
                            ?>
                            <div class="error notice">
                                <p>&#9888; <?php echo $exception->getMessage(); ?></p>
                                <p><em><? _e('Route caching cannot serialize closures', 'illumine'); ?>.</em></p>
                            </div>
                            <?php
                        });
                    }
                }
            }

        }
    }

    /**
     * Access Plugin Container in Static Array
     * (Reflection Class Passes Namespace)
     * @param $namespace
     * @return \Illuminate\Container\Container
     */
    public static function getInstance($namespace)
    {
        return self::$instances[explode('\\', $namespace)[0]];
    }

    /**
     * Boot Plugin Instance
     * (Allows Facade Class Usage)
     */
    public function bootInstance()
    {

        add_action('widgets_init', function () {
            $this->bindCache();
            $this->bindCookieJar();
            $this->bindSession();
            $this->bindValidator();
            $this->bindProviders();
            $this->bindRouter();
            $this->loadRoutes();
            $this->bindWpSupport();
            $this->setInstance();
            $this->developerMode();
        });

        /**
         * Route Requests on Frontend
         */
        add_action('init', function () {

            if (!is_admin()) {
                if ($this->plugin['config']->get('routes.loading') == 'eager') {
                    $this->routeRequest();
                } else {
                    add_action('template_redirect', function () {
                        if (is_404()) {
                            $this->routeRequest();
                        }
                    });
                }
            }

        });

    }

    /**
     * Bind Custom Provider Classes to Container
     */
    private function bindWpSupport()
    {


        //Bind WpShortcode Class
        if (!$this->plugin->bound('shortcodes')) {
            $this->plugin->bind('shortcodes', function () {
                return new ShortcodeFactory($this->plugin);
            }, true);
        }
        //Bind WpWidget Class
        if (!$this->plugin->bound('widgets')) {
            $this->plugin->bind('widgets', function () {
                return new WidgetFactory($this->plugin);
            }, true);
        }
        //Bind WpAdmin Class
        if (!$this->plugin->bound('admin')) {
            $this->plugin->bind('admin', function () {
                return new AdminFactory($this->plugin);
            }, true);
        }

        //Loop Wordpress Directories
        foreach (array('Shortcodes', 'Settings', 'PostTypes', 'Actions', 'Filters', 'Hooks', 'Widgets', 'Menus') as $directoryName) {

            //Assign WP Support Container Classes to Simple Variables
            $config = $this->plugin['config'];
            $shortcodes = $this->plugin['shortcodes'];
            $widgets = $this->plugin['widgets'];
            $admin = $this->plugin['admin'];
            $plugin = $this;

            //Require All Php Files
            foreach ($this->plugin['files']->glob($this->plugin['config']->get('base') . "/app/Wordpress/{$directoryName}/*.php") as $file) {
                require_once $file;
            }
        }

    }

    /**
     * Store Plugin Container in Static Array
     */
    private function setInstance()
    {
        //Set Self Instance of Plugin Container
        $this->plugin->setInstance($this->plugin);

        //Place Plugin Container in Static Array for Later Access
        self::$instances[$this->plugin['config']->get('namespace')] = $this->plugin;
    }

    /**
     * Show Developer Admin Panel
     */
    private function developerMode()
    {
        if ($this->plugin['config']->get('mode') == 'development') {
            if (is_admin()) {
                //Setup Admin Panel
                $this->plugin['admin']->addPanel(
                    $this->plugin['config']->get('namespace'), //$page_title
                    $this->plugin['config']->get('namespace'), //$menu_title
                    'manage_options', //$capability
                    strtolower($this->plugin['config']->get('namespace')), //$menu_slug
                    'Illumine\Framework\Controllers\DevController'
                );
            }

            $this->plugin['admin']->addBarNode(
                str_slug($this->plugin['config']->get('namespace')),
                $this->plugin['config']->get('namespace'),
                null,
                '?page=' . str_slug($this->plugin['config']->get('namespace')) . '&tab=config',
                null,
                array('class' => 'fooBar'),
                100
            );


            if ($this->plugin['config']->get('cache.enabled')) {
                $this->plugin['admin']->addBarNode(
                    str_slug($this->plugin['config']->get('namespace')) . '_flush_objects',
                    'Flush Objects',
                    str_slug($this->plugin['config']->get('namespace')),
                    '#',
                    null,
                    array(
                        'class' => str_slug($this->plugin['config']->get('namespace')) . '_dev_flush_objects'
                    )
                );
            }
            if ($this->plugin['config']->get('session.enabled')) {
                $this->plugin['admin']->addBarNode(
                    str_slug($this->plugin['config']->get('namespace')) . '_flush_sessions',
                    'Flush Sessions',
                    str_slug($this->plugin['config']->get('namespace')),
                    '#',
                    null,
                    array(
                        'class' => str_slug($this->plugin['config']->get('namespace')) . '_dev_flush_sessions'
                    )
                );
            }
            if ($this->plugin['config']->get('routes.enabled') && $this->plugin['config']->get('routes.cache')) {
                $this->plugin['admin']->addBarNode(
                    str_slug($this->plugin['config']->get('namespace')) . '_flush_routes',
                    'Flush Routes',
                    str_slug($this->plugin['config']->get('namespace')),
                    '#',
                    null,
                    array(
                        'class' => str_slug($this->plugin['config']->get('namespace')) . '_dev_flush_routes'
                    )
                );
            }

            if ($this->plugin['config']->get('view.compiled')) {
                $this->plugin['admin']->addBarNode(
                    str_slug($this->plugin['config']->get('namespace')) . '_flush_views',
                    'Flush Views',
                    str_slug($this->plugin['config']->get('namespace')),
                    '#',
                    null,
                    array(
                        'class' => str_slug($this->plugin['config']->get('namespace')) . '_dev_flush_views'
                    )
                );
            }

            if ($this->plugin['config']->get('routes.enabled')) {
                $this->plugin['admin']->addBarNode(
                    str_slug($this->plugin['config']->get('namespace')) . '_routes',
                    'Routes',
                    str_slug($this->plugin['config']->get('namespace')),
                    admin_url('admin.php?page=' . str_slug($this->plugin['config']->get('namespace')) . '&tab=routes')
                );
            }

            $this->plugin['admin']->addBarNode(
                str_slug($this->plugin['config']->get('namespace')) . '_config',
                'Configuration',
                str_slug($this->plugin['config']->get('namespace')),
                admin_url('admin.php?page=' . str_slug($this->plugin['config']->get('namespace')) . '&tab=config')
            );


            //Append Framework Views in Dev Mode
            $userPaths = $this->plugin['config']->get('view.paths');
            $paths = [];
            foreach ($userPaths as $path) {
                $paths[] = $path;
            }
            $paths[] = realpath(__DIR__ . '/resources/views/');
            $this->plugin['config']->set('view.paths', $paths);


            //Add Framework Cache Ajax Script to Footer
            add_action('wp_footer', function () {
                echo $this->plugin['view']->make('admin.framework.scripts', array('namespace' => str_slug($this->plugin['config']->get('namespace'))));
            }, 99);
            add_action('admin_footer', function () {
                echo $this->plugin['view']->make('admin.framework.scripts', array('namespace' => str_slug($this->plugin['config']->get('namespace'))));
            }, 99);

            //Add Framework Cache Ajax Controller
            add_action("wp_ajax_" . str_slug($this->plugin['config']->get('namespace')) . '_dev', function () {
                return new \Illumine\Framework\Controllers\DevController(array(
                    'plugin' => $this->plugin
                ));
            });
        }

    }

    /**
     * Try Routing Requests
     */
    private function routeRequest()
    {

        //Try Routing the Request
        try {

            //Set BaseController Response Type: Shortcode (Echo) / Route (Response)
            $this->plugin['router']->matched(function ($route) {
                $this->plugin->routeDispatched = true;
            });

            //Dispatch Request
            $this->plugin['router']->prepareResponse($this->plugin['request'], $this->plugin['router']->dispatch($this->plugin['request']));

            exit; //Prevent Wordpress from loading

        } catch (\Exception $e) {

            //Show Error
            if (!empty($e->getMessage())) {

                $message = '<h1>' . $e->getMessage() . '</h1>';
                $message .= '<h4>' . $e->getFile() . ' ' . $e->getLine() . '</h4>';
                $message .= '<pre style="overflow-x: auto">' . $e->getTraceAsString() . '</pre>';

                $message .= '<p><strong>Illumine Framework</strong> - <em>Made with Laravel</em>';
                $message .= '<br/><a href="https://github.com/wordpresspluginpro/illumine-framework" style="font-size: 12px;">https://github.com/wordpresspluginpro/illumine-framework</a></p>';

                $message .= '<style type="text/css">#error-page{ max-width:90% !important;}</style>';
                wp_die($message);
            }

            return; //Stay Silent
        }
    }

}

