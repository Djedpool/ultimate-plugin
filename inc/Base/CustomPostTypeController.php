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

    public function register() {

        $checkbox = get_option('ultimate_plugin');
        $activated = isset($checkbox['cpt_manager']) ? $checkbox['cpt_manager'] : false;

        if(!$activated) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubpages();

        $this->settings->addSubPages($this->subpages)->register();

        add_action('init', array($this, 'activate'));

    }

    public function activate() {
        register_post_type('ultimate_products',
            array(
                'labels' => array(
                    'name' => 'Products',
                    'singular_name' => 'Product'
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
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
}