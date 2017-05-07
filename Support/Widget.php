<?php namespace Illumine\Framework\Support;

class Widget extends \WP_Widget
{
    public $widget, $form, $update;

    /**
     * Constructor
     * Add Plugin Container
     * @param $name , $title, $attributes
     */
    public function __construct($name, $title, $attributes)
    {
        parent::__construct($name, $title, $attributes);
    }

    /**
     * Add Callable Properties
     * @return callable
     */
    public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        }
    }

    /**
     * Wp Required Methods
     */
    public function widget($args, $instance)
    {
    }

    public function form($instance)
    {
    }

    public function update($new_instance, $old_instance)
    {
    }
}