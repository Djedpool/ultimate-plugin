<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:47 AM
 */

namespace Inc\Base;

class AuthController extends BaseController
{
    public $settings;
    public $callback;
    public $subpages = array();

    public function register() {
        if(!$this->activated('login_manager')) return;

        add_action('wp_enqueue_scripts', array($this, 'enqueueScript'));
        add_action('wp_head', array($this, 'addAuthTemplate'));
    }

    public function addAuthTemplate() {
        if(is_user_logged_in()) return;

        $file = $this->plugin_path . 'templates/auth.php';

        if(file_exists($file)) {
            load_template($file, true);
        }
    }

    public function enqueueScript() {
        if(is_user_logged_in()) return;

        wp_enqueue_style('authStyle', $this->plugin_url. 'assets/auth.css');
        wp_enqueue_script('authScript', $this->plugin_url. 'assets/auth.js');
    }
}
