<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc\Base;


class Enqueue 
{
    public function register() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    public function enqueue() {
        //enqueue all our scripts
        wp_enqueue_style('mypluginstyle', PLUGIN_URL . 'assets/style.css');
        wp_enqueue_script('mypluginscript', PLUGIN_URL . 'assets/script.js');
    }
}