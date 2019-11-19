<?php
/**
 * @package RealEstateACFPlugin
 */

/*
Plugin Name: RealEstate ACF Plugin
Plugin URI: https://github.com/Oljacic/realestate-acf-plugin
Description: This plugin is for testing my skills and ability to nail a job!
Version: 1.0.0
Author: Stefan "Stef" Oljacic
License: GPLv2 or latter
Text Domain: realestate-acf-plugin
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

defined('ABSPATH') or die('Hi there! What are you doing here, you can\' access this file, you silly human?');

if (file_exists(dirname(__FILE__). '/vendor/autoload.php')) {
    require_once dirname(__FILE__). '/vendor/autoload.php';
}

use RealEstateInc\Activate;
use RealEstateInc\Deactivate;
use RealEstateInc\Admin\AdminPages;

if (!class_exists('RealEstateACFPlugin')) {

    class RealEstateACFPlugin
    {
        public $plugin;

        public function __construct() {
            $this->plugin = plugin_basename(__FILE__);
        }

        function register() {
            add_action('admin_enqueue_scripts', array($this, 'enqueue'));
            add_action('admin_menu', array($this, 'add_admin_pages'));

            add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
        }

        public function settings_link($links) {
            $settings_link = '<a href="admin.php?page=realestate_acf_plugin">Settings</a>';
            array_push( $links, $settings_link);
            return $links;
        }

        public function add_admin_pages() {
            add_menu_page('Real Estate ACF Plugin', 'Real Estate', 'manage_options', 'realestate_acf_plugin', array($this, 'admin_index'), 'dashicons-admin-home', 110);
        }

        public function admin_index() {
            require_once plugin_dir_path(__FILE__) . 'templates/admin.php'; 
        }

        protected function create_post_type() {
            add_action('init', array($this, 'custom_post_type'));
        }

        function custom_post_type() {
            register_post_type('real_estate', [
                'public' => true,
                'label'  => 'Real Estate'
            ]);
        }

        function enqueue() {
            //enqueue all our scripts
            wp_enqueue_style('mypluginstyle', plugins_url('/assets/style.css', __FILE__));
            wp_enqueue_script('mypluginscript', plugins_url('/assets/script.js', __FILE__));
        }

        function activate() {
            // require_once plugin_dir_path(__FILE__) . 'inc/realestate-acf-plugin-activate.php'; 
            Activate::activate();
        }

        function deactivate() {
            // require_once plugin_dir_path(__FILE__) . 'inc/realestate-acf-plugin-deactivate.php'; 
            Deactivate::deactivate();
        }


    }

    $realEstateACFPlugin = new RealEstateACFPlugin();
    $realEstateACFPlugin->register();

    // activation
    register_activation_hook(__FILE__, array($realEstateACFPlugin, 'activate'));

    // deactivation
    register_deactivation_hook(__FILE__, array($realEstateACFPlugin, 'deactivate'));

}