<?php namespace Illumine\Framework\Factories;

use Illumine\Framework\Support\Widget;

class WidgetFactory
{
    protected $this;
    private $plugin;

    /**
     * Constructor
     * Add Plugin Container
     * @param $plugin \Illuminate\Container\Container
     */
    public function __construct($plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * AddWidget
     * Add Plugin Container
     * @param $name
     * @param $title
     * @param $properties
     * @param $controllerClass
     */
    public function add($name, $title, $properties, $controllerClass)
    {

        register_widget(new Widget($name, $title, $properties, $this->plugin, $controllerClass));
    }
}

