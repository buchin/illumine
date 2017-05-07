<?php namespace Illumine\Framework\Factories;
class AdminFactory
{

    protected $this;
    private $plugin;


    /**
     * Constructor
     * Add Plugin Container
     * @param $plugin \Illuminate\Container\Container
     * @return void
     */
    public function __construct($plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * addPanel
     * @return void
     */
    public function addPanel(
        $pageTitle,
        $menuTitle,
        $capability,
        $slug,
        $controllerClass,
        $priority = 1
    )
    {

        add_action('admin_menu', function () use (
            $pageTitle,
            $menuTitle,
            $capability,
            $slug,
            $controllerClass,
            $priority
        ) {
            // Add shortcode support for widgets
            add_menu_page(
                $pageTitle, //$page_title
                $menuTitle, //$menu_title
                $capability, //$capability
                $slug, //$menu_slug
                function () use ($controllerClass, $pageTitle, $menuTitle, $capability, $slug) {

                    $plugin = $this->plugin; //needed for dev controller

                    $this->plugin->when($controllerClass)
                        ->needs('$attributes')
                        ->give(compact('pageTitle', 'menuTitle', 'capability', 'slug', 'plugin'));

                    return $this->plugin->make($controllerClass);
                }
            );
        }, $priority);
    }

    /**
     * addSubPanel
     * @return void
     */
    public function addSubPanel(
        $parentSlug,
        $pageTitle,
        $menuTitle,
        $capability,
        $slug,
        $controllerClass,
        $priority = 1
    )
    {
        add_action('admin_menu', function () use (
            $parentSlug,
            $pageTitle,
            $menuTitle,
            $capability,
            $slug,
            $controllerClass,
            $priority
        ) {
            // Add shortcode support for widgets
            add_submenu_page(
                $parentSlug,
                $pageTitle, //$page_title
                $menuTitle, //$menu_title
                $capability, //$capability
                $slug, //$menu_slug
                function () use ($controllerClass, $parentSlug, $pageTitle, $menuTitle, $capability, $slug) {
                    $plugin = $this->plugin;
                    $this->plugin->when($controllerClass)
                        ->needs('$attributes')
                        ->give(compact('parentSlug', 'pageTitle', 'menuTitle', 'capability', 'slug', 'plugin'));

                    return $this->plugin->make($controllerClass);
                }
            );
        }, $priority);
    }


    /**
     * addBarNode
     * @return void
     */
    public function addBarNode(
        $id,
        $title,
        $parent,
        $href,
        $group = null,
        $meta = null,
        $priority = 100
    )
    {
        add_action('admin_bar_menu', function ($wpAdminBar) use (
            $id,
            $title,
            $parent,
            $href,
            $group,
            $meta,
            $priority
        ) {

            $wpAdminBar->add_node(array(
                'id' => $id,
                'title' => $title,
                'parent' => $parent,
                'href' => $href,
                'group' => $group,
                'meta' => $meta
            ));

        }, $priority);
    }

    /**
     * addWidget
     * @return void
     */
    public function addWidget(
        $id,
        $name,
        $controllerClass
    )
    {
        add_action('wp_dashboard_setup', function () use (
            $id,
            $name,
            $controllerClass
        ) {

            wp_add_dashboard_widget(
                $id,
                $name,
                function () use ($id, $name, $controllerClass) {
                    $plugin = $this->plugin;
                    $this->plugin->when($controllerClass)
                        ->needs('$attributes')
                        ->give(compact('id', 'name', 'plugin'));

                    return $this->plugin->make($controllerClass);
                }
            );
        });
    }
}