<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc\Pages;

use \RealEstateInc\Base\BaseController;
use \RealEstateInc\Api\SettingsApi;

class Admin extends BaseController
{
    public $settings;
    public $pages = array();

    public function __construct() {
        $this->settings = new SettingsApi();
        $this->pages = array (
            array (
                'page_title' => 'Real Estate ACF Plugin', 
                'menu_titile'=> 'Real Estate', 
                'capability' => 'manage_options', 
                'menu_slug'  => 'realestate_acf_plugin', 
                'callback'   => function() { echo '<h1>RealEstate</h1>';}, 
                'icon_url'   => 'dashicons-admin-home',
                'position'   => 110
            )
       );
    }

    public function register() {
        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
    }
}