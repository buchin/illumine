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
     * @param $name , $title, $attributes, $class
     */
    public function add($name, $title, $attributes, $class)
    {


        $widget = new Widget($name, $title, $attributes);

        $widget->widget = function ($args, $instance) {

        };
        $widget->form = function ($instance) {

        };
        $widget->update = function ($new_instance, $old_instance) {

        };
        register_widget($widget);
    }
}

