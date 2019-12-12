<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/3/2019
 * Time: 7:31 PM
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class WidgetController extends BaseController {

    public $settings;
    public $callback;
    public $widget_callback;
    public $subpages = array();
    public $widgets = array();

    public function register() {

        if(!$this->activated('media_widget')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubPages();

        $this->settings->addSubPages($this->subpages)->register();
    }

    public function activate() {
        // Probably register widget
    }

    public function setSubPages() {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Widget',
                'menu_title'  => 'Widget Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_widget',
                'callback'    => array($this->callback, 'adminWidget'),
            )
        );
    }
}