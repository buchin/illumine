<?php namespace Illumine\Framework\Controllers;

use Illuminate\Routing\Controller;
use Illumine\Framework\Assembler;
use Illumine\Framework\Traits\AccessibleTrait;
use Illumine\Framework\Traits\ReflectibleTrait;

abstract class BaseController extends Controller
{

    use ReflectibleTrait;
    use AccessibleTrait;

    protected
        $this,
        $plugin,
        $config,
        $session,
        $filesystem,
        $router,
        $routeDispatched,
        $currentUserId,
        $request,
        $response,
        $cookieJar,
        $cookies,
        $view,
        $viewRendered,
        $validator;

    /**
     * BaseController constructor.
     * @param $namespace (optional)
     * Allows Framework to Load the BuiltIn Dev Controller
     */
    public function __construct($namespace = null)
    {
        $this->plugin = Assembler::getInstance((is_null($namespace) ? $this->reflect()->getNamespaceName() : $namespace));
        $this->cookies = array();
        $this->viewRendered = null;
    }
}