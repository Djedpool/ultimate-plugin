<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/2/2019
 * Time: 8:33 AM
 * @package UltimatePlugin
*/

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * Class CustomPostTypeController
 * @package Inc\Base
 */
class CustomPostTypeController extends BaseController
{
    public $settings;
    public $callback;
    public $cpt_callback;
    public $subpages = array();
    public $custom_post_types = array();

    public function register() {

        if(!$this->activated('cpt_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();
        $this->cpt_callback = new CptCallbacks();

        $this->setSubpages();

        $this->storeSettings();
        $this->storeSections();
        $this->storeFields();

        $this->settings->addSubPages($this->subpages)->register();


        $this->storeCustomPostTypes();

        if(!empty($this->custom_post_types)) {
            add_action('init', array($this, 'registerCustomPostType'));
        }
    }

    public function setSubPages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Custom Post Types',
                'menu_title'  => 'CPT Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_cpt',
                'callback'    => array($this->callback, 'adminCpt'),
            )
        );
    }

    public function storeSettings() {

        $args = array(
            array(
                'option_group' => 'ultimate_plugin_cpt_settings',
                'option_name'  => 'ultimate_plugin_cpt',
                'callback'     => array($this->cpt_callback, 'cptSanitize')
            )
        );

        $this->settings->setSettings($args);
    }

    public function storeSections() {
        $args = array(
            array(
                'id'       => 'ultimate_cpt_index',
                'title'    => 'Custom Post Type Manager',
                'callback' => array($this->cpt_callback, 'cptSectionManager'),
                'page'     => 'ultimate_plugin_cpt'
            )
        );

        $this->settings->setSections($args);
    }

    public function storeFields() {
        $args = array(
            array(
                'id'       => 'post_type',
                'title'    => 'Custom Post Type',
                'callback' => array($this->cpt_callback, 'textField'),
                'page'     => 'ultimate_plugin_cpt',
                'section'  => 'ultimate_cpt_index',
                'args'     => array(
                    'option_name' => 'ultimate_plugin_cpt',
                    'label_for'   => 'post_type', //always must to match ID
                    'placeholder' => 'eg. product'
                )
            ),
            array(
                'id'       => 'singular_name',
                'title'    => 'Singular Name',
                'callback' => array($this->cpt_callback, 'textField'),
                'page'     => 'ultimate_plugin_cpt',
                'section'  => 'ultimate_cpt_index',
                'args'     => array(
                    'option_name' => 'ultimate_plugin_cpt',
                    'label_for'   => 'singular_name', //always must to match ID
                    'placeholder' => 'eg. Product'
                )
            ),
            array(
                'id'       => 'plural_name',
                'title'    => 'Plural Name',
                'callback' => array($this->cpt_callback, 'textField'),
                'page'     => 'ultimate_plugin_cpt',
                'section'  => 'ultimate_cpt_index',
                'args'     => array(
                    'option_name' => 'ultimate_plugin_cpt',
                    'label_for'   => 'plural_name',
                    'placeholder' => 'eg. Products'
                )
            ),
            array(
                'id'       => 'public',
                'title'    => 'Public',
                'callback' => array($this->cpt_callback, 'checkboxField'),
                'page'     => 'ultimate_plugin_cpt',
                'section'  => 'ultimate_cpt_index',
                'args'     => array(
                    'option_name' => 'ultimate_plugin_cpt',
                    'label_for'   => 'public',
                    'class'       => 'ui-toggle'
                )
            ),
            array(
                'id'       => 'has_archive',
                'title'    => 'Has Archive',
                'callback' => array($this->cpt_callback, 'checkboxField'),
                'page'     => 'ultimate_plugin_cpt',
                'section'  => 'ultimate_cpt_index',
                'args'     => array(
                    'option_name' => 'ultimate_plugin_cpt',
                    'label_for'   => 'has_archive',
                    'class'       => 'ui-toggle'
                )
            )
        );

        $this->settings->setFields($args);
    }

    public function storeCustomPostTypes() {
        $this->custom_post_types = array(
            array(
                'post_type'             => 'test',
                'name'                  => '',
                'singular_name'         => '',
                'menu_name'             => '',
                'name_admin_bar'        => '',
                'archives'              => '',
                'attributes'            => '',
                'parent_item_colon'     => '',
                'all_items'             => '',
                'add_new_item'          => '',
                'add_new'               => '',
                'new_item'              => '',
                'edit_item'             => '',
                'update_item'           => '',
                'view_item'             => '',
                'view_items'            => '',
                'search_items'          => '',
                'not_found'             => '',
                'not_found_in_trash'    => '',
                'featured_image'        => '',
                'set_featured_image'    => '',
                'remove_featured_image' => '',
                'use_featured_image'    => '',
                'insert_into_item'      => '',
                'uploaded_to_this_item' => '',
                'items_list'            => '',
                'items_list_navigation' => '',
                'filter_items_list'     => '',
                'label'                 => '',
                'description'           => '',
                'supports'              => false,
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page'
            ),
        );
    }

    public function registerCustomPostType() {
        foreach ($this->custom_post_types as $post_type) {
            register_post_type($post_type['post_type'],
                array(
                    'labels' => array(
                        'name'                  => $post_type['name'],
                        'singular_name'         => $post_type['singular_name'],
                        'menu_name'             => $post_type['menu_name'],
                        'name_admin_bar'        => $post_type['name_admin_bar'],
                        'archives'              => $post_type['archives'],
                        'attributes'            => $post_type['attributes'],
                        'parent_item_colon'     => $post_type['parent_item_colon'],
                        'all_items'             => $post_type['all_items'],
                        'add_new_item'          => $post_type['add_new_item'],
                        'add_new'               => $post_type['add_new'],
                        'new_item'              => $post_type['new_item'],
                        'edit_item'             => $post_type['edit_item'],
                        'update_item'           => $post_type['update_item'],
                        'view_item'             => $post_type['view_item'],
                        'view_items'            => $post_type['view_items'],
                        'search_items'          => $post_type['search_items'],
                        'not_found'             => $post_type['not_found'],
                        'not_found_in_trash'    => $post_type['not_found_in_trash'],
                        'featured_image'        => $post_type['featured_image'],
                        'set_featured_image'    => $post_type['set_featured_image'],
                        'remove_featured_image' => $post_type['remove_featured_image'],
                        'use_featured_image'    => $post_type['use_featured_image'],
                        'insert_into_item'      => $post_type['insert_into_item'],
                        'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
                        'items_list'            => $post_type['items_list'],
                        'items_list_navigation' => $post_type['items_list_navigation'],
                        'filter_items_list'     => $post_type['filter_items_list']
                    ),
                    'label'                     => $post_type['label'],
                    'description'               => $post_type['description'],
                    'supports'                  => $post_type['supports'],
                    'taxonomies'                => $post_type['taxonomies'],
                    'hierarchical'              => $post_type['hierarchical'],
                    'public'                    => $post_type['public'],
                    'show_ui'                   => $post_type['show_ui'],
                    'show_in_menu'              => $post_type['show_in_menu'],
                    'menu_position'             => $post_type['menu_position'],
                    'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
                    'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
                    'can_export'                => $post_type['can_export'],
                    'has_archive'               => $post_type['has_archive'],
                    'exclude_from_search'       => $post_type['exclude_from_search'],
                    'publicly_queryable'        => $post_type['publicly_queryable'],
                    'capability_type'           => $post_type['capability_type']
                )
            );
        }
    }
}