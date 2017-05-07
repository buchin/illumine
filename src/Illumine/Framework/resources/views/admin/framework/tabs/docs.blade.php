<div id="post-body" class="metabox-holder columns-2">
    <div id="post-body-content">
        <div class="postbox">

            <div class="illumine-header">
                <h1>illumine</h1>
                <h2>Laravel Based Wordpress Plugin Framework</h2>
                <p>
                    <a href="https://github.com/wordpresspluginpro/illumine-framework" class="button-primary"
                       target="_blank">Illumine Framework GitHub</a>
                    <a href="https://github.com/illuminate" class="button-primary" target="_blank">Laravel Components
                        GitHub</a>
                </p>
            </div>
            <div class="inside illumine-inside">

                <p>Illumine Framework provides an architecture that allows rapid development of Wordpress plugins where
                    speed and dexterity is preferred over native WP methods. This codebase was inspired by Laravel and
                    tries to take full advantage of it's core libraries while remaining component driven. The following
                    guide outlines the architecture of the framework so you can understand the depth of it's
                    capabilities. I hope you enjoy this tool. Please help by contributing or reporting problems
                    encountered to the framework's GitHub repository.</p>

                <p>Developer: <strong>Dan Alvidrez</strong></p>
                <!-- SECTION DIVIDER -->
                <hr/>
                <!-- SECTION DIVIDER -->

                <h4><em>Special thanks to:</em></h4>
                <ul class="specialThanks">
                    <li>
                        <a href="http://laravel.com" target="_blank">
                            <strong>Taylor Otwell</strong> (Laravel)
                        </a>
                    </li>
                    <li>
                        <a href="http://laracasts.com" target="_blank">
                            <strong>Jeffery Way</strong>, (Laracasts)
                        </a>
                    </li>
                    <li>
                        <a href="https://github.com/mattstauffer" target="_blank">
                            <strong>Matt Stauffer</strong>, (GitHub)
                        </a>
                    </li>
                    <li>
                        <a href="http://getherbert.com" target="_blank">
                            <strong>Jason Agnew</strong>, (GetHerbert)
                        </a>
                    </li>
                </ul>

                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_containers"></a>
                <h1>Plugin Containers</h1>
                <!-- SECTION DIVIDER -->

                <p>Each Illumine plugin is loaded into a container which is bound to the framework's static array of
                    instances. This allows you to access the complete instance of any other Illumine based plugin
                    including all of its core services providers for operations between them.</p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_instances"></a>
                <h1>Plugin Container Instance Access</h1>
                <!-- SECTION DIVIDER -->

                <p>The plugin's container instance is resolved out of the framework using 3 methods that can be used
                    within your plugin:</p>

                <ol>
                    <li>
                        <p>
                            <strong>Auto-Appended Magic Property</strong>
                            <br/>
                            <em>Pre-configured to be available inside controller classes: (MyController extends
                                BaseController)</em>
                        </p>
                        <code>$this->plugin</code>
                    </li>
                    <li>
                        <p>
                            <strong>Helper Class Method</strong>
                            <br/>
                            <em>Use inside custom classes:</em>
                        </p>
                        <code>
                            use \MyNamespace\Helper;
                            <br/><br/>
                            $myPlugin = Helper::plugin();
                        </code>
                    </li>
                    <li>
                        <p>
                            <strong>Framework Class Method:</strong>
                            <br/>
                            <em>For interacting with other Illumine framework based plugins:</em>
                        </p>
                        <code>
                            use \IllumineFramework\IlluminePlugin;
                            <br/><br/>
                            $otherPlugin = IlluminePlugin::getInstance('MyOtherPluginNamespace');
                        </code>
                    </li>
                </ol>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_binding"></a>
                <h1>Class Binding</h1>
                <!-- SECTION DIVIDER -->

                <p>Custom Classes can be bound to the plugin container just as you would do in Laravel.</p>
                <code>

                    $config = $plugin->container['config'];
                    <br/><br/>
                    $plugin->container->bind('fooBar', function() use ($config){
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return new MyClass($config->get('api_key'),
                    $config->get('api_token'));
                    <br/>});
                </code>

                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_components"></a>
                <h1>Laravel Components</h1>
                <!-- SECTION DIVIDER -->

                <p>Some of the included Laravel components can activated or deactivated by toggling the corresponding
                    boolean value of in your configuration. If your plugin doesn't require a router, simple disable it
                    in your config. Composer packages can be uninstalled from your plugin's vendor library if your
                    configuration doesn't require them.</p>


                <table class="widefat">
                    <thead>
                    <tr>
                        <th class="row-title">Component</th>
                        <th>Shortcut Method</th>
                        <th>Required</th>
                        <th>Package</th>
                        <th>Docs</th>
                    </tr>
                    </thead>

                    <tr valign="top">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_containers">Container</a>
                            </label>
                        </th>
                        <td>plugin()</td>
                        <td>Yes</td>
                        <td><a href="https://github.com/illuminate/container" target="_blank">"illuminate/container":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Container/Container.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>

                    <tr valign="top" class="alternate">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_config">Config</a>
                            </label>
                        </th>
                        <td>config()</td>
                        <td>Yes</td>
                        <td><a href="https://github.com/illuminate/config" target="_blank">"illuminate/config":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Config/Repository.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_cache">Cache</a>
                            </label>
                        </th>
                        <td>cache()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/cache" target="_blank">"illuminate/cache":"5.4.*"</a>
                        </td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Cache/Repository.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>


                    <tr valign="top" class="alternate">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_cookie">Cookie</a>
                            </label>
                        </th>
                        <td>cookie()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/cookie" target="_blank">"illuminate/cookie":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Cookie/CookieJar.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>


                    <tr valign="top">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_database">Database</a>
                            </label>
                        </th>
                        <td>database()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/database" target="_blank">"illuminate/database":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Database.html" class="button-secondary"
                               target="_blank">View</a></td>
                    </tr>


                    <tr valign="top" class="alternate">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_encrypter">Encrypter</a>
                            </label>
                        </th>
                        <td>encrypter()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/encryption" target="_blank">"illuminate/encryption":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Encryption/Encrypter.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>


                    <tr valign="top">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_files">Files</a>
                            </label>
                        </th>
                        <td>files()</td>
                        <td>Yes</td>
                        <td><a href="https://github.com/illuminate/filesystem" target="_blank">"illuminate/filesystem":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Filesystem/Filesystem.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>


                    <tr valign="top" class="alternate">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_pagination">Pagination</a>
                            </label>
                        </th>
                        <td>paginate()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/pagination" target="_blank">"illuminate/pagination":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Pagination/Paginator.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>


                    <tr valign="top">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_request">Request</a>
                            </label>
                        </th>
                        <td>request()</td>
                        <td>Yes</td>
                        <td><a href="https://github.com/illuminate/http" target="_blank">"illuminate/http": "5.4.*"</a>
                        </td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Http/Request.html" class="button-secondary"
                               target="_blank">View</a></td>
                    </tr>

                    <tr valign="top" class="alternate">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_response">Response</a>
                            </label>
                        </th>
                        <td>response()</td>
                        <td>Yes</td>
                        <td><a href="https://github.com/illuminate/http" target="_blank">"illuminate/http": "5.4.*"</a>
                        </td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Http/Response.html" class="button-secondary"
                               target="_blank">View</a></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_router">Router</a>
                            </label>
                        </th>
                        <td>router()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/routing" target="_blank">"illuminate/routing":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Routing/RouteCollection.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>

                    <tr valign="top" class="alternate">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_session">Session</a>
                            </label>
                        </th>
                        <td>session()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/session" target="_blank">"illuminate/session":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Session/Store.html" class="button-secondary"
                               target="_blank">View</a></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_validation">Validator</a>
                            </label>
                        </th>
                        <td>validator()</td>
                        <td>Optional</td>
                        <td><a href="https://github.com/illuminate/validation" target="_blank">"illuminate/validation":
                                "5.4.*"</a></td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/Validation/Validator.html"
                               class="button-secondary" target="_blank">View</a></td>
                    </tr>


                    <tr valign="top" class="alternate">
                        <th scope="row">
                            <label for="tablecell">
                                &#9507; <a href="#illumine_view">View</a>
                            </label>
                        </th>
                        <td>view()</td>
                        <td>Yes</td>
                        <td><a href="https://github.com/illuminate/view" target="_blank">"illuminate/view": "5.4.*"</a>
                        </td>
                        <td><a href="https://laravel.com/api/5.4/Illuminate/View/View.html" class="button-secondary"
                               target="_blank">View</a></td>
                    </tr>


                </table>


                <h2>Shortcut Methods</h2>
                <p>Loaded services can be accessed by calling the <u>shortcut()</u> methods listed above on <strong>$this</strong>
                    in controller context.</p>

                <code>
                    $this->cache()->forever('hello', 'world');
                </code>

                <h2>Binding Method</h2>
                <p>All class bindings (including your custom bindings) can be accessed by calling the <u>plugin()</u>
                    method on the <a href="#illumine_instances">instance</a>.</p>

                <code>
                    $this->plugin('MyClass")->myMethod($var1, $var2);
                </code>

                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_config"></a>
                <p class="float-right"><strong><em>config()</em></strong></p>
                <h1>Config Repository</h1>
                <!-- SECTION DIVIDER -->

                <p>Each plugin configuration provides a blueprint of the services and their required values to the
                    framework.
                    Instead of a directory of config files as seen in laravel, place all your values in this single
                    file. You can include custom values as well.
                </p>
                <code>
                    'facebook' => [<br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'api' => [<br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'app_id' => '123456',<br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'secret' => '123456'<br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]<br/>
                    ],
                </code>


                <h2>config() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class to retrieve your values based on the
                    dot syntax shown below:</p>
                <code>
                    $this->config()->get('facebook.api.secret');
                </code>

                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_cache"></a>
                <p class="float-right"><strong><em>cache()</em></strong></p>
                <h1>Cache Repository</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Cache Repository Component saves data to your database, or as flat files in the cache directory.
                    Specify the preferred method in your configuration file.
                </p>

                <p>
                    A database table for your cache can be automatically created and deleted with pre-configured classes
                    within the <u>~/app/Wordpress</u> directory.
                    See <a href="#illumine_activate">Activate</a>, <a href="#illumine_deactivate">DeActivate</a> and <a
                            href="#illumine_uninstall">UnInstall</a> for more information.
                </p>

                <h2>cache() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class to set or forget values as shown
                    below:</p>

                <code>
                    $this->cache()->put('foo', 'bar');
                    <br/><br/>
                    $this->cache()->remember('foo', 'bar', 60); //60 Minutes
                    <br/><br/>
                    $this->cache()->rememberForever('foo', 'bar');
                    <br/><br/>
                    $this->cache()->get('foo');
                    <br/><br/>
                    $this->cache()->forget('foo');
                </code>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_cookie"></a>
                <p class="float-right"><strong><em>cookie()</em></strong></p>
                <h1>CookieJar</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The CookieJar Component is designed to work with routes only. Shortcodes, Widgets etc, cannot modify
                    response headers because they are rendered after a page started loading. Sensible defaults have been
                    pre-configured for you.
                </p>

                <h2>cookie() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class as shown below:</p>

                <code>
                    $this->cookie()->queue('foo', 'bar'); //Set Cookie
                    <br/><br/>
                    $this->cookie()->queue($this->cookie()->forget('testCookie')); //Remove Cookie
                </code>

                <p>
                    **This component requires <u>Routes</u>.
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_database"></a>
                <p class="float-right"><strong><em>database()</em></strong></p>
                <h1>Database</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Database Component uses Wordpress settings to determine the proper connection. You can toggle
                    off this component by setting the proper value in your <u>~/config.php</u> file.
                </p>


                <h2>database() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class as shown below:</p>

                <code>
                    $this->database()->listen(function($query) {
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;echo $query->sql.' in '.$query->time.' ms';
                    <br/>});
                </code>

                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_encrypter"></a>
                <p class="float-right"><strong><em>encrypter()</em></strong></p>
                <h1>Encrypter</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Encrypter Component provides an encryption suite for easy use. Be sure to specify a unique
                    encryption key in your configuration.
                </p>


                <h2>encrypter() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class shown below:</p>

                <code>
                    $this->encrypter()->encrypt('MySecret');
                    <br/><br/>
                    $this->encrypter()->decrypt('eyJpdiI6IkYxcWV1VytLeXhFZFZzNWR2ODlKc...');
                </code>

                <p>You can disable this component by setting the proper value in your <u>~/config.php</u> file.</p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_files"></a>
                <p class="float-right"><strong><em>files()</em></strong></p>
                <h1>Files</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Files Component provides allows you to easily manage the local filesystem.
                </p>


                <h2>files() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class shown below:</p>

                <code>
                    $this->files()->exists('/some/path/to/file.php');
                    <br/><br/>
                    $this->files()->put('/some/path/to/image.jpg');
                    <br/><br/>
                    $this->files()->get('/some/path/to/image.jpg');
                    <br/><br/>
                    $this->files()->delete('/some/path/to/image.jpg');
                </code>


                <p>You can use the "base" setting in your configuration as a shortcut to your plugin folder.</p>

                <code>
                    $basePath = $this->config()->get('base');
                    <br/><br/>
                    $this->files()->delete($basePath.'resources/assets/img/image.jpg');
                </code>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_pagination"></a>
                <p class="float-right"><strong><em>paginate()</em></strong></p>
                <h1>Pagination</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Pagination Component provides allows you paginate results from your eloquent models.
                </p>


                <h2>paginate() Method</h2>

                <p>Use the method provided by eloquent models as shown below:</p>

                <code>
                    $posts = WpPost::take(20)->paginate(5);
                    <br/><br/>
                    $posts = WpPost::take(20)->paginateSimple(5);
                </code>

                <p>Default pagination views have been provided for quick setup. Use the <u>&#x40;include()</u> method
                    and assign your collection to the "paginator" property. </p>

                <code>
                    &#x40;include('pagination.default',[
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'paginator' => $posts
                    <br/>])
                </code>
                <p>*The normal "Laravel style" links() method doesn't work, if you have a solution for this issue,
                    please submit a pull request.</p>
                <p>
                    **The Pagination component is optional.
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_request"></a>
                <p class="float-right"><strong><em>request()</em></strong></p>
                <h1>Request</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Request Component allows you to retrieve or modify values from the global http request object.
                </p>


                <h2>request() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class as shown below:</p>

                <code>
                    $this->request()->has('image');
                    <br/><br/>
                    $this->request()->file('image');
                    <br/><br/>
                    $this->request()->merge([
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'search' => '%'.$this->request()->get('search').'%'
                    <br/>]);
                </code>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_response"></a>
                <p class="float-right"><strong><em>response()</em></strong></p>
                <h1>Response</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Response Component allows you to return custom responses for use with routes. Collection
                    instances will automatically convert the response into an appropriate json header type as shown in
                    the second example.
                </p>

                <h2>response() Method</h2>

                <p>In Controllers, use the method provided by "$this->plugin" or the "Helper" Class as shown below:</p>

                <code>
                    $this->response()->create('Hello World!', 200)->send();
                </code>

                <p>In your routes file, use the $request variable. </p>
                <code>
                    $route->get('/custom/posts/api', function() use ($response){
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;$posts = WpPost::take(20)->get();
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;$response->create($posts)->send();
                    <br/>});
                </code>
                <p>
                    **The Response component requires <u>Router</u>.
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_router"></a>
                <p class="float-right"><strong><em>router()</em></strong></p>
                <h1>Router</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Router Component allows you to use custom routes with your plugin.
                </p>

                <h2>Configuration</h2>
                <p>The setting "loading" accepts two values which can be used to change how the router intercepts
                    requests during the Wordpress load lifecycle.</p>
                <ol>
                    <li><strong>Eager</strong>: Routes will overwrite a matching request always.</li>
                    <li><strong>Lazy</strong>: Routes will intercept a matching request when a 404 is triggered by
                        wordpress.
                    </li>
                </ol>
                <p>**Take care when naming your routes, a namespaced group is best practice.</p>
                <p>The setting "cache" can be used to enable route caching if your plugin uses a large number of routing
                    rules.</p>

                <h2>$route Variable</h2>
                <p>In your routes file (~/app/Http/routes.php), use the <u>$route</u> variable to setup routes for your
                    plugin.</p>
                <code>
                    $route->get('/my-route/{page?}', 'Plugin1\Http\Controllers\MyController@index')->name('my-index');
                </code>


                <h2>router() Method</h2>
                <p>Use the router() method to access the route collection elsewhere in your plugin.</p>

                <code>
                    $routes = $this->router()->getRoutes();
                    <br/>
                    <br/>
                    $routes[0]->getName();
                </code>


                <h2>Middleware</h2>

                <p>Routes can specify middleware. See the provided example <u>~/app/Http/Middleware/CsrfFilter.php</u>
                </p>
                <p>
                    **The Routes component is optional.
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_session"></a>
                <p class="float-right"><strong><em>session()</em></strong></p>

                <h1>Session</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The Session Component saves data to your database, or as flat files in the cache directory. Specify
                    the preferred method in your configuration file. Sessions automatically save a cookie in the browser
                    which identifies the current user's CSRF token and session data.
                </p>

                <p>
                    A database table for sessions can be automatically created and deleted with pre-configured classes
                    within the <u>~/app/Wordpress</u> directory.
                    See <a href="#illumine_activate">Activate</a>, <a href="#illumine_deactivate">DeActivate</a> and <a
                            href="#illumine_uninstall">UnInstall</a> for more information.
                </p>

                <h2>session() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class to set or forget values as shown
                    below:</p>

                <code>
                    $this->session()->put('foo', 'bar');
                    <br/><br/>
                    $this->session()->get('foo');
                    <br/><br/>
                    $this->session()->forget('foo'); //delete a record
                    <br/><br/>
                    $this->session()->flush(); //delete everything
                </code>

                <p>
                    **The Session component is optional and requires <u>CookieJar</u>.
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_validator"></a>
                <p class="float-right"><strong><em>validator()</em></strong></p>

                <h1>Validator</h1>
                <!-- SECTION DIVIDER -->
                <p>
                    The Validator Component allows you to compare a data-set against a rule-set before performing an
                    operation.
                </p>
                <p>You can disable this component by setting the proper value in your <u>~/config.php</u> file.</p>

                <h2>validator() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class to validate values as shown
                    below:</p>

                <code>
                    $rules = array(
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'display_name' => 'required',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'_token' => 'required'
                    <br/>);
                    <br/>
                    <br/>

                    $messages = array(
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'display_name.required' => 'A Sisplay Name is required.',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'_token.required' => 'A Security Token must be present & valid.'
                    <br/>);
                    <br/>
                    <br/>
                    $validation = $this->validator()->make($this->request()->all(),$rules,$messages);
                    <br/>
                    <br/>
                    if($validation->passes()){
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;//Do Something
                    <br/>}
                </code>


                <p>
                    **The Validator component is optional and requires the <u>Database</u> component when using the
                    "unique in table" rule.
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_view"></a>
                <p class="float-right"><strong><em>view()</em></strong></p>
                <h1>View</h1>
                <!-- SECTION DIVIDER -->

                <p>
                    The View Component allows you to render views and data from controllers easily. The engine is
                    preconfigured to use the <u>~/resources/views/</u> path specified in your configuration file. You
                    can also specify additional paths as well.
                </p>

                <h2>view() Method</h2>

                <p>Use the method provided by "$this->plugin" or the "Helper" Class to render a view as shown below:</p>

                <code>
                    $this->view('forms.profile',compact('posts'));
                </code>

                <p>
                    **The View component will "echo" in shortcode context and "respond" in route context. The rendering
                    context is set to "respond" (before your controller initializes), when a route is matched.
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_integrations"></a>
                <p class="float-right"><strong><em>~/app/Wordpress/*</em></strong></p>
                <h1>Integrations</h1>
                <!-- SECTION DIVIDER -->
                <p>
                    The "Wordpress Integrations" directory is a special <u>auto-loading</u> structure designed to
                    require <u>.php</u> files in alphabetical order. You can think of this directory as a way to spread
                    out a bloated <u>functions.php</u> file into manageable files that are easily found. You can include
                    standard wordpress functions such as actions, filters, hooks and enqueue's as you would normally and
                    store them here.
                </p>

                <h2><u>$plugin</u> Container Object Variable</h2>
                <p>Files in this structure do not require a namespace to resolve your plugin instance, instead they are
                    provided access to a special pre-configured object variable which you can use to access your
                    plugin's component classes if needed.</p>

                <code>
                    See Example File: ~/app/Wordpress/Actions/delete_post.php
                    <br/><br/>add_action('delete_post', function() use ($plugin){
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;$plugin->cache()->flush();
                    <br/>}, 99);
                </code>

                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_factories"></a>
                <p class="float-right"><strong><em>~/app/Wordpress/*</em></strong></p>
                <h1>Factories</h1>
                <!-- SECTION DIVIDER -->
                <p><a href="#illumine_integrations">Integration Files</a> also provided access to additional
                    pre-configured object variables which come in the form of "Integration Factories" which allow you to
                    create Wordpress Integrations on the fly such as "Shortcodes", "Widgets", "Admin Panels", "Admin Bar
                    Menu Nodes" etc... </p>


                <h2>Factory Object Variables</h2>
                <p>Factories are abstractions designed to attach controller classes to Wordpress functions easily.
                    Factories are designed for ease of use over configurability. If you prefer your own methods you can
                    simply ignore these variables in favor of your preferred methods.</p>

                <code>
                    $admin;
                    <br/>$shortcodes;
                    <br/>$widgets;
                </code>
                <p> **Integration Factories are a work in progress, only a few are currently available. Feel free to
                    submit ideas to the repo.</p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_adminFactory"></a>
                <p class="float-right"><strong><em>$admin</em></strong></p>
                <h1>Admin Factory</h1>
                <!-- SECTION DIVIDER -->

                <p>The Admin Factory provides several methods for creating and mapping Wp Admin UI features:</p>

                <h2><u>$admin</u> Object Variable</h2>
                <p>Use the <u>$admin</u> object variable to call the following methods:</p>


                <h2><u>addPanel()</u> Method</h2>
                <p>The <u>addPanel()</u> method allows you too add a side menu panel as seen in use on this page:</p>
                <p><strong>Parameters:</strong>
                    $pageTitle,
                    $menuTitle,
                    $capability,
                    $slug,
                    $controllerClass,
                    $priority
                </p>
                <code>
                    See Example File: ~/app/Wordpress/Menus/panel.php

                    <br/><br/>$admin->addPanel(
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'My Panel',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'My Plugin',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'manage_options',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'my-parent-panel',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'MyPlugin\Controllers\AdminPanelController',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;99
                    <br/>);
                </code>
                <p>Source: <a href="https://developer.wordpress.org/reference/functions/add_menu_page/" target="_blank">https://developer.wordpress.org/reference/functions/add_menu_page/</a>
                </p>


                <h2><u>addSubPanel()</u> Method</h2>
                <p>The <u>addPanel()</u> method allows you too add a side menu sub-panel to a panel that has been
                    previously defined:</p>
                <p><strong>Parameters:</strong>
                    $parentSlug,
                    $pageTitle,
                    $menuTitle,
                    $capability,
                    $slug,
                    $controllerClass,
                    $priority
                </p>
                <code>
                    See Example File: ~/app/Wordpress/Menus/panel.php
                    <br/><br/>$admin->addSubPanel(
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'my-parent-panel',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'My Panel',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'My Plugin',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'manage_options',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'my-sub-panel',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'MyPlugin\Controllers\AdminPanelController',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;99
                    <br/>);
                </code>
                <p>Source: <a href="https://developer.wordpress.org/reference/functions/add_submenu_page/"
                              target="_blank">https://developer.wordpress.org/reference/functions/add_submenu_page/</a>
                </p>

                <h2><u>addBarNode()</u> Method</h2>
                <p>The <u>addBarNode()</u> method allows you too add a Admin Bar menu item node:</p>
                <p><strong>Parameters:</strong>
                    $id,
                    $title,
                    $parent,
                    $href,
                    $group,
                    $meta,
                    $priority
                </p>
                <code>
                    See Example File: ~/app/Wordpress/Menus/adminBar.php
                    <br/><br/>$admin->addBarNode(
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'my-menu',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'My Menu',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;null,
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'http://myawesome.link',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;null,
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;array('class' => 'fooBar'),
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;99
                    <br/>);
                </code>

                <p>Source: <a href="https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_node" target="_blank">https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_node</a>
                </p>

                <h2><u>addWidget()</u> Method</h2>
                <p>The <u>addWidget()</u> method allows you too add a Admin Dashboard widget:</p>
                <p><strong>Parameters:</strong>
                    $id,
                    $name,
                    $controllerClass
                </p>
                <code>
                    See Example File: ~/app/Wordpress/Widgets/dashboard.php
                    <br/><br/>$admin->addWidget(
                    <br/>&nbsp;&nbsp;&nbsp; 'my-widget',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'My Widget',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'MyPlugin\Controllers\WidgetController',
                    <br/>);
                </code>

                <p>Source: <a href="https://codex.wordpress.org/Function_Reference/wp_add_dashboard_widget"
                              target="_blank">https://codex.wordpress.org/Function_Reference/wp_add_dashboard_widget</a>
                </p>


                <!-- SECTION DIVIDER -->
                <hr/>
                <a class="illumine_anchor" id="illumine_shortcodeFactory"></a>
                <p class="float-right"><strong><em>~/app/Wordpress/*</em></strong></p>
                <h1>Shortcode Factory</h1>
                <!-- SECTION DIVIDER -->

                <p>The Shortcode Factory provides a method for creating and mapping Wordpress Shortcodes:</p>

                <h2><u>$shortcode</u> Object Variable</h2>
                <p>The add() method allows you too add a Shortcode: </p>
                <p>Parameters: $name, $controllerClass</p>

                <code>
                    See Example File: ~/app/Wordpress/Shortcodes/search.php
                    <br/><br/>$shortcodes->add(
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'my-shortcode',
                    <br/>&nbsp;&nbsp;&nbsp;&nbsp;'MyPlugin\Http\Controllers\MyShortcodeController'
                    <br/>);
                </code>


            </div>
        </div>
    </div>
    <div id="postbox-container-1" class="postbox-container illumine-sidebar">
        <h1>Documentation</h1>
        <ul class="docs-tree">
            <li>
                <a href="#illumine_containers">
                    <strong>Containers</strong>
                </a>
                <ul>
                    <li>&#9507; <a href="#illumine_instances">Instances</a></li>
                    <li>&#9495; <a href="#illumine_binding">Binding</a></li>
                </ul>
            </li>
        </ul>

        <ul class="docs-tree">
            <li>
                <a href="#illumine_components">
                    <strong>Components</strong>
                </a>
                <ul>
                    <li>&#9507; <a href="#illumine_config">Config</a></li>
                    <li>&#9507; <a href="#illumine_cache">Cache</a></li>
                    <li>&#9507; <a href="#illumine_cookie">Cookie</a></li>
                    <li>&#9507; <a href="#illumine_database">Database</a></li>
                    <li>&#9507; <a href="#illumine_encrypter">Encrypter</a></li>
                    <li>&#9507; <a href="#illumine_files">Files</a></li>
                    <li>&#9507; <a href="#illumine_pagination">Pagination</a></li>
                    <li>&#9507; <a href="#illumine_request">Request</a></li>
                    <li>&#9507; <a href="#illumine_response">Response</a></li>
                    <li>&#9507; <a href="#illumine_router">Router</a></li>
                    <li>&#9507; <a href="#illumine_session">Session</a></li>
                    <li>&#9507; <a href="#illumine_validation">Validation</a></li>
                    <li>&#9495; <a href="#illumine_view">View</a></li>
                </ul>
            </li>
        </ul>

        <ul class="docs-tree">
            <li>
                <a href="#illumine_integrations">
                    <strong>Integrations</strong>
                </a>
                <ul style="display: none;">
                    <li>&#9507; <a href="#illumine_actions">Actions</a></li>
                    <li>&#9507; <a href="#illumine_enqueue">Enqueue</a></li>
                    <li>&#9507; <a href="#illumine_filters">Filters</a></li>
                    <li>&#9507; <a href="#illumine_hooks">Hooks</a></li>
                    <li>&#9507; <a href="#illumine_menus">Menus</a></li>
                    <li>&#9507; <a href="#illumine_postTypes">PostTypes</a></li>
                    <li>&#9507; <a href="#illumine_settings">Settings</a></li>
                    <li>&#9507; <a href="#illumine_shortcodes">Shortcodes</a></li>
                    <li>&#9495; <a href="#illumine_widgets">Widgets</a></li>
                </ul>
            </li>
        </ul>
        <ul class="docs-tree">
            <li>
                <a href="#illumine_factories">
                    <strong>Factories</strong>
                </a>
                <ul>
                    <li>&#9507; <a href="#illumine_adminFactory">AdminFactory</a></li>
                    <li>&#9507; <a href="#illumine_shortcodeFactory">ShortcodeFactory</a></li>
                    <li>&#9495; <a href="#illumine_widgetFactory">WidgetFactory</a></li>
                </ul>
            </li>
        </ul>

        <ul class="docs-tree">
            <li>
                <a href="">
                    <strong>Utilities</strong>
                </a>
                <ul>
                    <li>&#9507; <a href="#illumine_helper">Helper</a></li>
                    <li>&#9507; <a href="#illumine_activate">Activate</a></li>
                    <li>&#9507; <a href="#illumine_deActivate">DeActivate</a></li>
                    <li>&#9495; <a href="#illumine_unInstall">UnInstall</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<style type="text/css">
    a.illumine_anchor {
        float: left;
        margin-top: -50px;
    }

    .illumine-header {
        background-color: #00b9eb;
        padding: 20px;
    }

    .illumine-header h1,
    .illumine-header h2 {
        color: #fff;
        margin: 0;
        padding: 0 !important;
        text-shadow: 1px 2px 2px #0073aa;
    }

    .illumine-header h1 {
        font-size: 36px;
        margin: 0 0 10px 0;
    }

    .illumine-header h2 {
        font-size: 12px !important;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .illumine-header p {
        margin: 15px 0 0 0;
    }

    .illumine-inside {
        padding: 25px 25px 25px 25px !important;
    }

    .illumine-inside p {
        font-size: 14px;
    }

    .illumine-inside p.float-right {
        float: right;
        margin: 5px 0 0 0;
        padding: 0;
    }

    .illumine-inside hr {
        margin: 35px 0;
        padding: 0;
        border: none;
        height: 4px;
        background: #f3f3f3;
    }

    .illumine-inside h1 {
        color: #0073aa;
    }

    .illumine-inside h2 {
        font-size: 18px !important;
        margin: 25px 0 5px 0 !important;
        padding: 0 !important;
    }

    .illumine-inside code {
        background-color: #f9f9f9;
        border: 1px solid #b9daf7;
        border-left: 6px solid #00b9eb;
        padding: 20px;
        margin: 15px 0;
        text-wrap: normal;
        display: block;
    }

    .illumine-inside .specialThanks li {
        display: inline-block;
        padding: 5px 10px;
        margin: 0 5px 10px 0;
        background-color: #f3f3f3;
        border: 1px solid #b9daf7;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        font-size: 14px;
    }

    .illumine-inside .specialThanks li a {
        text-decoration: none;
    }

    .illumine-inside .specialThanks {
        padding: 0;
        margin: 10px 0 0 0;
    }

    #post-body {
        position: relative;
    }

    .illumine-sidebar {
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
        box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
    }

    .illumine-sidebar h1 {
        font-size: 20px;
        padding: 20px 20px 0px 20px;
    }

    .illumine-sidebar .docs-tree * {
        font-size: 13px;
        line-height: 15px;
    }

    .illumine-sidebar ul.docs-tree {
        padding: 5px 0 10px 20px;
    }

    .illumine-sidebar ul.docs-tree li {
        display: block;
    }

    .illumine-sidebar ul.docs-tree li a strong {
        line-height: 16px !important;
        font-size: 16px !important;
        margin-bottom: 5px;
        display: block;
    }
</style>
<script type="text/javascript">
    //    $ = jQuery;
    //    $(function() {
    //        var $illumine_sidebar   = $(".illumine-sidebar"),
    //        $illumine_window    = $(window),
    //        $illumine_offset    = $illumine_sidebar.offset(),
    //        topPadding = 50;
    //        $illumine_window_height = $illumine_window.innerHeight();
    //
    //        $illumine_window.scroll(function() {
    //            if ($illumine_window.scrollTop() > $illumine_offset.top) {
    //                $illumine_sidebar.stop().animate({
    //                    marginTop: $illumine_window.scrollTop() - $illumine_offset.top + topPadding
    //                });
    //            } else {
    //                $illumine_sidebar.stop().animate({
    //                    marginTop: 0
    //                });
    //            }
    //        });
    //    });
</script>

