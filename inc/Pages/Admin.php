<?php
/**
 * @package UltimatePlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;

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
        $this->storeSettings();
        $this->storeSections();
        $this->storeFields();

        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() {
        $this->pages = array(
            array(
                'page_title' => 'Ultimate Plugin',
                'menu_title' => 'Ultimate Plugin',
                'capability' => 'manage_options',
                'menu_slug'  => 'ultimate_plugin',
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
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Custom Post Types',
                'menu_title'  => 'CPT',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_cpt',
                'callback'    => array($this->callback, 'adminCpt'),
            ),
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Custom Taxonomies',
                'menu_title'  => 'Taxonomies',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_taxonomies',
                'callback'    => array($this->callback, 'adminTaxonomy'),
            ),
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Custom Widgets',
                'menu_title'  => 'Widgets',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_widgets',
                'callback'    => array($this->callback, 'adminWidget'),
            )
        );
    }

    // This are classical setters but I use store
    public function storeSettings() {
        $args = array(
            array(
                'option_group' => 'ultimate_options_group',
                'option_name'  => 'text_example',
                'callback'     => array($this->callback, 'ultimateOptionsGroup')
            )
        );

        $this->settings->setSettings($args);
    }

    public function storeSections() {
        $args = array(
            array(
                'id'       => 'ultimate_admin_index',
                'title'    => 'Settings',
                'callback' => array($this->callback, 'ultimateAdminSection'),
                'page'     => 'ultimate_plugin'
            )
        );

        $this->settings->setSections($args);
    }

    public function storeFields() {
        $args = array(
            array(
                'id'       => 'text_example',
                'title'    => 'Text Example',
                'callback' => array($this->callback, 'ultimateTextExample'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'text_example',
                    'class'     => 'example-class'
                )
            )
        );

        $this->settings->setFields($args);
    }
}