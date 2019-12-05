<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:28 AM
 */

namespace Inc\Base;


use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class TestimonialController extends BaseController
{
    public $settings;
    public $callback;
    public $subpages = array();

    public function register() {
        if(!$this->activated('testimonial_manager')) return;

        $this->settings = new SettingsApi();
        $this->callback = new AdminCallbacks();

        $this->setSubPages();

        $this->settings->addSubPages($this->subpages)->register();
    }

    public function activate() {
        // setting testimonials
    }


    public function setSubPages() {
        $this->subpages = array(
            array(
                'parent_slug' => 'ultimate_plugin',
                'page_title'  => 'Testimonials',
                'menu_title'  => 'Testimonials Manager',
                'capability'  => 'manage_options',
                'menu_slug'   => 'ultimate_plugin_testimonials',
                'callback'    => array($this->callback, 'adminWidget'),
            )
        );
    }
}