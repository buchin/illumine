<?php namespace Illumine\Framework\Controllers;
class DevController extends AdminController
{

    public $data, $attributes, $parameters;
    protected $this;

    /**
     * AdminController constructor.
     * @param $attributes (PanelAttributes)
     *
     * $this->attributes['pageTitle'],
     * $this->attributes['menuTitle'],
     * $this->attributes['capability'],
     * $this->attributes['slug'],
     */
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

        $this->attributes['config'] = $this->config();
        $this->attributes['routes'] = $this->router();

        $this->data();
        $this->process();
        $this->render();
    }

    /**
     * Load Data
     * @return mixed
     */
    public function data()
    {

        if ($this->config()->get('session.enabled')) {
            $this->attributes['paths']['sessions'] = $this->config()->get('session.files');
            $this->attributes['sizes']['sessions'] = $this->calcDiskSize($this->attributes['paths']['sessions']);
        }
        if ($this->config()->get('routes.enabled') && $this->config()->get('routes.cache')) {
            $this->attributes['paths']['routes'] = $this->config()->get('routes.compiled');
            $this->attributes['sizes']['routes'] = $this->calcDiskSize($this->attributes['paths']['routes']);
        }
        if ($this->config()->get('cache.enabled')) {
            $this->attributes['paths']['objects'] = $this->config()->get('cache.stores.file.path');
            $this->attributes['sizes']['objects'] = $this->calcDiskSize($this->attributes['paths']['objects']);
        }
        if ($this->config()->get('view.compiled')) {
            $this->attributes['paths']['views'] = $this->config()->get('view.compiled');
            $this->attributes['sizes']['views'] = $this->calcDiskSize($this->attributes['paths']['views']);
        }
    }

    /**
     * Handle Request
     * @return mixed
     */
    public function process()
    {

        if ($this->request()->has('_flush')) {

            if ($this->flushCache($this->request()->get('_flush'))) {

                $this->attributes['alertClass'] = 'success';
                $this->attributes['messages'] = array(
                    '&#10004; ' . $this->config()->get('namespace') . ' ' . ucwords($this->request()->get('_flush')) . ' flushed successfully.'
                );
                //Refresh Data
            } else {

                $this->attributes['alertClass'] = 'error';
                $this->attributes['messages'] = array(
                    '&#9888; ' . $this->config()->get('namespace') . ' ' . ucwords($this->request()->get('_flush')) . ' could not be flushed.  The file(s) may not exist; If they exist, check directory structure, permissions and config paths.'
                );
            }

            $this->data();
        }

    }

    /**
     * Build Template
     * @return mixed
     */
    public function render()
    {

        if ($this->request()->ajax()) {
            $this->response()->setContent(html_entity_decode($this->attributes['messages'][0]))->send();
            exit;
        } else {
            $this->view('admin.framework.settings', $this->attributes);
        }
    }
}

