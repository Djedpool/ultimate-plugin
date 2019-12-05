<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:20 AM
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class GalleryController extends BaseController
{
    public $settings;
    public $callback;
    public $subpages = array();

    public function register() {
        if(!$this->activated('gallery_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubPages();

        $this->settings->addSubPages($this->subpages)->register();
    }

    public function activate() {
        // Create gallery
    }

    public function setSubPages() {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Gallery',
                'menu_title'  => 'Gallery Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_gallery',
                'callback'    => array($this->callback, 'adminWidget'),
            )
        );
    }

}