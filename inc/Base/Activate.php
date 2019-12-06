<?php
/**
 * @package UltimatePlugin
 */

namespace Inc\Base;

class Activate 
{
    public static function activate() {
        flush_rewrite_rules();

//        if(get_option('ultimate_plugin')) {
//            return;
//        }
//
//        $default = array();
//
//        update_option('ultimate_plugin', $default);
        $default = array();

        if ( ! get_option( 'ultimate_plugin_cpt' ) ) {
            update_option( 'ultimate_plugin_cpt', $default );
        }

    }
}