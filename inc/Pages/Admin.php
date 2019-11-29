<?php
/**
 * @package UltimatePlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Admin extends BaseController
{
	public $settings;
    public $callback;
    public $callback_mngr;
	public $pages = array();
    public $subpages = array();


	public function register() {

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();
        $this->callback_mngr = new ManagerCallbacks();

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
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'cpt_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'taxonomy_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'media_widget',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'gallery_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'testimonial_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'template_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'login_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'membership_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            ),
            array(
                'option_group' => 'ultimate_plugin_settings',
                'option_name'  => 'chat_manager',
                'callback'     => array($this->callback_mngr, 'checkboxSanitize')
            )
        );

        $this->settings->setSettings($args);
    }

    public function storeSections() {
        $args = array(
            array(
                'id'       => 'ultimate_admin_index',
                'title'    => 'Settings Manager',
                'callback' => array($this->callback_mngr, 'adminSectionManager'),
                'page'     => 'ultimate_plugin'
            )
        );

        $this->settings->setSections($args);
    }

    public function storeFields() {
        $args = array(
            array(
                'id'       => 'cpt_manager',
                'title'    => 'Activate CPT Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'cpt_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'taxonomy_manager',
                'title'    => 'Activate Taxonomy Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'taxonomy_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'media_widget',
                'title'    => 'Activate Media Widget',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'media_widget', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'gallery_manager',
                'title'    => 'Activate Gallery Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'gallery_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'testimonial_manager',
                'title'    => 'Activate Testimonial Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'testimonial_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'template_manager',
                'title'    => 'Activate Template Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'template_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'login_manager',
                'title'    => 'Activate Login Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'login_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'membership_manager',
                'title'    => 'Activate Membership Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'membership_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'chat_manager',
                'title'    => 'Activate Chat Manager',
                'callback' => array($this->callback_mngr, 'checkboxField'),
                'page'     => 'ultimate_plugin',
                'section'  => 'ultimate_admin_index',
                'args'     => array(
                    'label_for' => 'chat_manager', //always must to match ID
                    'class'     => 'ui-toggle'
                )
            ),
        );

        $this->settings->setFields($args);
    }
}