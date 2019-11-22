<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc\Pages;

use \RealEstateInc\Base\BaseController;
use \RealEstateInc\Api\SettingsApi;
use \RealEstateInc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
	public $settings;
    public $callback;
	public $pages = array();
    public $subpages = array();


	public function register() {

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setPages();
        $this->setSubPages();

        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() {
        $this->pages = array(
            array(
                'page_title' => 'Real Estate ACF Plugin',
                'menu_title' => 'Real Estate',
                'capability' => 'manage_options',
                'menu_slug'  => 'realestate_acf_plugin',
                'callback'   => array($this->callback, 'adminDashboard'),
                'icon_url'   => 'dashicons-admin-home',
                'position'   => 110
            )
        );
    }

    public function setSubPages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'realestate_acf_plugin',
                'page_title'  => 'Custom Post Types',
                'menu_title'  => 'CPT',
                'capability'  => 'manage_options',
                'menu_slug'   => 'realestate_acf_plugin_cpt',
                'callback'    => array($this->callback, 'adminCpt'),
            ),
            array(
                'parent_slug' => 'realestate_acf_plugin',
                'page_title'  => 'Custom Taxonomies',
                'menu_title'  => 'Taxonomies',
                'capability'  => 'manage_options',
                'menu_slug'   => 'realestate_acf_plugin_taxonomies',
                'callback'    => array($this->callback, 'adminTaxonomy'),
            ),
            array(
                'parent_slug' => 'realestate_acf_plugin',
                'page_title'  => 'Custom Widgets',
                'menu_title'  => 'Widgets',
                'capability'  => 'manage_options',
                'menu_slug'   => 'realestate_acf_plugin_widgets',
                'callback'    => array($this->callback, 'adminWidget'),
            )
        );
    }
}