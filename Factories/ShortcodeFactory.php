<?php namespace Illumine\Framework\Factories;
class ShortcodeFactory
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
     * AddShortcode
     * Add Plugin AddShortcode
     * @param $tag string
     * @param $controllerClass string
     * @return  $controllerClass string
     */
    public function add(
        $tag,
        $controllerClass
    )
    {
        // Add shortcode support for widgets
        add_shortcode($tag, function ($tagAttributes, $tagContent = null) use ($tag, $controllerClass) {

            $attributes = array(
                'tag' => $tag,
                'parameters' => (is_array($tagAttributes) ? $tagAttributes : array()),
                'content' => $tagContent,
            );


            $this->plugin->when($controllerClass)
                ->needs('$attributes')
                ->give($attributes);



            ob_start();

            $this->plugin->make($controllerClass);

            return ob_get_clean();

        });
    }
}