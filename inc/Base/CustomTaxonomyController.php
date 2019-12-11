<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/3/2019
 * Time: 6:18 PM
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\TaxonomyCallbacks;

class CustomTaxonomyController extends BaseController {
    public $settings;
    public $callback;
    public $tax_callback;
    public $subpages = array();
    public $taxonomies = array();

    public function register() {

        if(!$this->activated('taxonomy_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();
        $this->tax_callback = new TaxonomyCallbacks();

        $this->setSubPages();

        $this->storeSettings();
        $this->storeSections();
        $this->storeFields();

        $this->settings->addSubPages($this->subpages)->register();

        $this->storeCustomTaxonomies();

        if(!empty($this->taxonomies)) {
            add_action('init', array($this, 'registerCustomTaxonomy'));
        }
    }

    public function setSubPages() {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Taxonomy',
                'menu_title'  => 'Taxonomy Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_tax',
                'callback'    => array($this->callback, 'adminTaxonomy'),
            )
        );
    }

    public function storeSettings() {
        $args = array(
            array(
                'option_group' => 'ultimate_plugin_tax_settings',
                'option_name'  => 'ultimate_plugin_tax',
                'callback'     => array($this->tax_callback, 'taxSanitize')
            )
        );

        $this->settings->setSettings($args);
    }

    public function storeSections() {
        $args = array(
            array(
                'id'       => 'ultimate_tax_index',
                'title'    => 'Custom Taxonomy Manager',
                'callback' => array($this->tax_callback, 'taxSectionManager'),
                'page'     => 'ultimate_plugin_tax'
            )
        );

        $this->settings->setSections($args);
    }

    public function storeFields() {
        $args = array(
            array(
                'id'        => 'taxonomy',
                'title'     => 'Custom Taxonomy ID',
                'callback'  => array($this->tax_callback, 'textField'),
                'page'      => 'ultimate_plugin_tax',
                'section'   => 'ultimate_tax_index',
                'args' => array(
                    'option_name' => 'ultimate_plugin_tax',
                    'label_for'   => 'taxonomy',
                    'placeholder' => 'eg. genre',
                    'array'       => 'taxonomy'
                )
            ),
            array(
                'id'        => 'singular_name',
                'title'     => 'Singular Name',
                'callback'  => array($this->tax_callback, 'textField'),
                'page'      => 'ultimate_plugin_tax',
                'section'   => 'ultimate_tax_index',
                'args' => array(
                    'option_name' => 'ultimate_plugin_tax',
                    'label_for'   => 'singular_name',
                    'placeholder' => 'eg. Genre',
                    'array'       => 'taxonomy'
                )
            ),
            array(
                'id'       => 'hierarchical',
                'title'    => 'hierarchical',
                'callback' => array($this->tax_callback, 'checkboxField'),
                'page'     => 'ultimate_plugin_tax',
                'section'  => 'ultimate_tax_index',
                'args'     => array(
                    'option_name' => 'ultimate_plugin_tax',
                    'label_for'   => 'hierarchical',
                    'class'       => 'ui-toggle',
                    'array'       => 'taxonomy'
                )
            ),      
        );

        $this->settings->setFields($args);
    }

    public function storeCustomTaxonomies() {

        $options = get_option('ultimate_plugin_tax') ?: array();

        foreach ($options as $option) {

            $labels = array(
                'name'              => $option['singular_name'],
                'singular_name'     => $option['singular_name'],
                'search_items'      => 'Search ' . $option['singular_name'],
                'all_items'         => 'All ' . $option['singular_name'],
                'parent_item'       => 'Parent ' . $option['singular_name'],
                'parent_item_colon' => 'Parent ' . $option['singular_name'] . ':',
                'edit_item'         => 'Edit ' . $option['singular_name'],
                'update_item'       => 'Update ' . $option['singular_name'],
                'add_new_item'      => 'Add New ' . $option['singular_name'],
                'new_item_name'     => 'New ' . $option['singular_name'] . ' Name',
                'menu_name'         => $option['singular_name'],
            );

            $this->taxonomies[] = array(
                'hierarchical'      => isset($option['hierarchical']) ? true : false,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => $option['taxonomy']),
            );
        }
    }

    public function registerCustomTaxonomy() {
        foreach ($this->taxonomies as $taxonomy) {
            register_taxonomy($taxonomy['rewrite']['slug'], array('post'), $taxonomy);
        }
    }

}
