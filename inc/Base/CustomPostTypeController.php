<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/2/2019
 * Time: 8:33 AM
 * @package UltimatePlugin
*/

namespace Inc\Base;

use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;

/**
 * Class CustomPostTypeController
 * @package Inc\Base
 */
class CustomPostTypeController extends BaseController
{
    public $settings;
    public $callback;
    public $subpages = array();
    public $custom_post_types = array();

    public function register() {

        if(!$this->activated('cpt_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubpages();

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

    public function storeCustomPostTypes() {
        $this->custom_post_types = array(
            array(
                'post_type'     => 'ultimate_product',
                'name'          => 'Products',
                'singular_name' => 'Product',
                'public'        => true,
                'has_archive'   => true
            ),
            array(
                'post_type'     => 'ultimate_games',
                'name'          => 'Games',
                'singular_name' => 'Game',
                'public'        => true,
                'has_archive'   => true
            ),
        );
    }

    public function registerCustomPostType() {
        foreach ($this->custom_post_types as $post_type) {
            register_post_type($post_type['post_type'],
                array(
                    'labels' => array(
                        'name' => $post_type['name'],
                        'singular_name' => $post_type['singular_name']
                    ),
                    'public' => $post_type['public'],
                    'has_archive' => $post_type['has_archive']
                )
            );
        }
    }
}