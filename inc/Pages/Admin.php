<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc\Pages;

use \RealEstateInc\Base\BaseController;

class Admin extends BaseController
{
    public function register() {
        add_action('admin_menu', array($this, 'add_admin_pages'));
    }

    public function add_admin_pages() {
        add_menu_page('Real Estate ACF Plugin', 'Real Estate', 'manage_options', 'realestate_acf_plugin', array($this, 'admin_index'), 'dashicons-admin-home', 110);
    }

    public function admin_index() {
        require_once $this->plugin_path . 'templates/admin.php'; 
    }
}