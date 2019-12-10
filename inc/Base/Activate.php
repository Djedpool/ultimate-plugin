<?php
/**
 * @package UltimatePlugin
 */

namespace Inc\Base;

class Activate 
{
    public static function activate() {
        flush_rewrite_rules();

        $default = array();

        if ( ! get_option( 'ultimate_plugin' ) ) {
            update_option( 'ultimate_plugin', $default );
        }
        if ( ! get_option( 'ultimate_plugin_cpt' ) ) {
            update_option( 'ultimate_plugin_cpt', $default );
        }
        if ( ! get_option( 'ultimate_plugin_tax' ) ) {
            update_option( 'ultimate_plugin_tax', $default );
        }
    }
}