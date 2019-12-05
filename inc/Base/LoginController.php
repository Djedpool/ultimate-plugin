<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:47 AM
 */

namespace Inc\Base;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class LoginController extends BaseController
{
    public $settings;
    public $callback;
    public $subpages = array();

    public function register() {
        if(!$this->activated('login_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubPages();

        $this->settings->addSubPages($this->subpages)->register();
    }

    public function activate() {

    }

    public function setSubPages() {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Login',
                'menu_title'  => 'Login Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_login',
                'callback'    => array($this->callback, 'adminWidget')
            )
        );
    }
}
