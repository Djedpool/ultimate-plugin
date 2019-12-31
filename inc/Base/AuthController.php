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
        add_action('wp_ajax_nopriv_ultimate_login', array($this, 'login'));
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

    public function login() {
        check_ajax_referer('ajax-login-nonce', 'ultimate_auth');

        $info = array();

        $info['user_login'] = $_POST['username'];
        $info['user_password'] = $_POST['password'];
        $info['remember'] = true;

        $user_signon = wp_signon($info, true);

        if(is_wp_error($user_signon)) {
            echo json_encode(
                array(
                    'status' => false,
                    'message' => 'Wrong username or password.'
                )
            );

            die();
        }

        echo json_encode(
            array(
                'status' => true,
                'message' => 'Login successful, redirecting...'
            )
        );

        die();


    }
}
