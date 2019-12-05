<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:36 AM
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class TemplateController extends BaseController
{
    public $settings;
    public $callback;
    public $subpages = array();

    public function register() {
        if(!$this->activated('template_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubPages();

        $this->settings->addSubPages($this->subpages)->register();
    }

    public function activate() {
        // probably not needed but just in case if something cross my mind
    }

    public function setSubPages() {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Template',
                'menu_title'  => 'Template Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_template',
                'callback'    => array($this->callback, 'adminWidget')
            )
        );
    }
}