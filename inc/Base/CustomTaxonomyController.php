<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/3/2019
 * Time: 6:18 PM
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class CustomTaxonomyController extends BaseController {
    public $settings;
    public $callback;
    public $subpages = array();

    public function register() {

        if(!$this->activated('taxonomy_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubPages();

        $this->settings->addSubPages($this->subpages)->register();

//        add_action('init', array($this, 'activate'));
    }

    public function activate() {
        // to probably register taxonomy
    }

    public function setSubPages() {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Taxonomy',
                'menu_title'  => 'Taxonomy Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_taxonomy',
                'callback'    => array($this->callback, 'adminTaxonomy'),
            )
        );
    }
}
