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
    public function register() {
        if(!$this->activated('testimonial_manager')) return;

        add_action('init', array($this, 'testimonialCpt'));
    }

    public function testimonialCpt() {

        $labels = array(
            'name' => 'Testimonials',
            'singular_name' => 'Testimonials'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-testimonial',
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'supports' => array('title', 'editor')
        );

        register_post_type('testimonial', $args);
    }
}