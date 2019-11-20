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
    public $subpages = array();
    
	public function __construct(){
        $this->settings = new SettingsApi();
        
		$this->pages = array(
			array(
                'page_title' => 'Real Estate ACF Plugin', 
                'menu_title' => 'Real Estate', 
                'capability' => 'manage_options', 
                'menu_slug'  => 'realestate_acf_plugin', 
                'callback'   => function() { echo '<h1>RealEstate</h1>';}, 
                'icon_url'   => 'dashicons-admin-home',
                'position'   => 110
			)
        );
        
		$this->subpages = array(
            array(
				'parent_slug' => 'realestate_acf_plugin', 
				'page_title'  => 'Custom Post Types', 
				'menu_title'  => 'CPT', 
				'capability'  => 'manage_options', 
				'menu_slug'   => 'realestate_acf_plugin_cpt', 
				'callback'    => function() { echo '<h1>CPT Manager</h1>'; }
			),
			array(
                'parent_slug' => 'realestate_acf_plugin', 
                'page_title'  => 'Custom Taxonomies', 
                'menu_title'  => 'Taxonomies', 
                'capability'  => 'manage_options', 
                'menu_slug'   => 'realestate_acf_plugin_taxonomies',  
                'callback'    => function() { echo '<h1>Taxonomies Manager</h1>';}
			),
			array(
			    'parent_slug' => 'realestate_acf_plugin', 
                'page_title'  => 'Custom Widgets', 
                'menu_title'  => 'Widgets', 
                'capability'  => 'manage_options', 
                'menu_slug'   => 'realestate_acf_plugin_widgets',  
                'callback'    => function() { echo '<h1>WidgetsManager</h1>';}
			)
		);
    }
    
	public function register() {
		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}
}