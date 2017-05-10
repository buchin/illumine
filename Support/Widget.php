<?php namespace Illumine\Framework\Support;


class Widget extends \WP_Widget
{
    public $plugin, $widget, $form, $update;

    /**
     * Constructor
     * Add Plugin Container / Make Controller Class with Attributes
     * @param $name
     * @param $title
     * @param $attributes
     * @param $plugin
     * @param $controllerClass
     */
    public function __construct($name, $title, $attributes, $plugin, $controllerClass)
    {
        parent::__construct($name, $title, $attributes);

        $this->plugin = $plugin;

        $this->plugin->when($controllerClass)
            ->needs('$attributes')
            ->give(compact('name', 'title', 'properties'));

        $this->widget = $this->plugin->make($controllerClass);
    }

    /**
     * Wp Required Methods
     */

    public function widget($args, $instance)
    {
        return $this->widget->widget($args, $instance);
    }

    public function form($instance)
    {
        return $this->widget->form($instance);
    }

    public function update($new_instance, $old_instance)
    {
        return $this->widget->update($new_instance, $old_instance);
    }
}