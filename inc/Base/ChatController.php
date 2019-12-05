<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 9:11 AM
 */

namespace Inc\Base;


use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class ChatController extends BaseController
{
    public $settings;
    public $callback;
    public $subpages = array();

    public function register() {
        if(!$this->activated('chat_manager')) return;

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
                'page_title'  => 'Chat',
                'menu_title'  => 'Chat Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_chat',
                'callback'    => array($this->callback, 'adminWidget')
            )
        );
    }
}