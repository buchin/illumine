<?php namespace Illumine\Framework\Traits;

use Illuminate\Support\HtmlString;

trait AccessibleTrait
{
    /**
     * Access Encrypter
     * @return \Illuminate\Encryption\Encrypter
     */
    public function encrypter()
    {
        return $this->plugin['encrypter'];
    }


    /**
     * Access Queue
     * @return \Illuminate\Queue\QueueManager
     */
    public function queue()
    {
        return $this->plugin['queue'];
    }


    /**
     * Access ViewFactory
     * @return \Illuminate\View\Factory
     */
    public function viewFactory(){
        return $this->plugin['view'];
    }
    /**
     * Access View
     * @return mixed
     */
    public function view($template, $parameters = array(), $status = 200)
    {

        //Setup Template Variables
        $data = array(
            'request' => $this->request(),
            'currentUserId' => $this->currentUserId(),
        );

        //Loop & Combine User Template Variables
        foreach ($parameters as $parameter => $value) {
            $data[$parameter] = $value;
        }

        //Bind Template Variables to ViewRendered
        $this->viewRendered = new HtmlString($this->plugin['view']->make($template, $data)->render());

        if ($this->plugin->routeDispatched) {
            $this->respond();
        } else {
            echo $this->viewRendered;
        }

    }

    /**
     * Access Request
     * @return \Illuminate\Http\Request
     */
    public function request()
    {
        return $this->plugin['request'];
    }

    /**
     * Access CurrentUserID
     * @return integer
     */
    public function currentUserId()
    {
        return get_current_user_id();
    }

    /**
     * Send Response with CookieJar
     * @return $this
     * end chain
     */
    public function respond($content = null, $status = 200)
    {

        if ($this->config()->get('session.enabled')) {
            //Loop CookieJar
            foreach ($this->cookie()->getQueuedCookies() as $cookie) {

                //Set Cookie
                setcookie($cookie->getName(),
                    $cookie->getValue(),
                    $cookie->getExpiresTime(),
                    $cookie->getPath(),
                    $cookie->getDomain(),
                    $cookie->isSecure(),
                    $cookie->isHttpOnly());
            }
        }
        //Set Status Code
        $this->response()->setStatusCode($status);

        //Set Content
        $this->response()->setContent((is_null($content) ? $this->viewRendered : $content));

        //Send Response
        $this->response()->send();
    }

    /**
     * Access Configuration
     * @return \Illuminate\Config\Repository
     */
    public function config()
    {
        return $this->plugin['config'];
    }

    /**
     * Access CookieJar
     * @return \Illuminate\Cookie\CookieJar
     */
    public function cookie()
    {
        return $this->plugin['cookie'];
    }

    /**
     * Access Response
     * @return \Illuminate\Http\Response
     */
    public function response()
    {
        return $this->plugin['response'];
    }

    /**
     * Access Validator
     * @return \Illuminate\Validation\Factory
     */
    public function validator()
    {
        return $this->plugin['validator'];
    }

    /**
     * Access Router Class
     * @return \Illuminate\Routing\RouteCollection
     */
    public function router()
    {
        return $this->plugin['router'];
    }

    /**
     * Access Url Generator Class
     * @return \Illuminate\Routing\UrlGenerator
     */
    public function urlGenerator()
    {
        return $this->plugin['url'];
    }

    /**
     * Access RouteDispatched Property
     * @return boolean
     */
    public function routerStatus()
    {
        return $this->plugin->routeDispatched;
    }

    /**
     * Access FileSystem Class
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function files()
    {
        return $this->plugin['files'];
    }

    /**
     * Access Cache Class
     * @return \Illuminate\Cache\CacheManager
     */
    public function cache()
    {
        return $this->plugin['cache'];
    }

    /**
     * Access Session Class
     * @return \Illuminate\Database\Capsule\Manager
     */
    public function database()
    {
        return $this->plugin['db'];
    }

    /**
     * Access Session Token
     * @return string
     */
    public function getToken()
    {
        return $this->plugin['session']->token();
    }

    /**
     * Redirect Response
     * @return string
     */
    public function redirect($url = '', $status = 302, $headers = array())
    {
        return \Illuminate\Http\RedirectResponse::create($url, $status, $headers)->send();
    }

    /**
     * Verify CSRF Token Presence
     * @return boolean
     */
    public function verifyCSRF()
    {

        if (!$this->request()->isMethod('get') && $this->request()->get('_token') == $this->session()->get('_token')) {
            $this->session()->regenerateToken();
            $this->session()->save();
            return true;
        } else {
            return false;
        }

    }

    /**
     * Access Session Class
     * @return \Illuminate\Session\Store
     */
    public function session()
    {
        return $this->plugin['session'];
    }

}