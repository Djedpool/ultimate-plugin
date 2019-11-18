<?php
/**
 * @package RealEstateACFPlugin
 */

class RealEstateACFPluginActivate 
{
    public static function activate() {
        flush_rewrite_rules();
    }
}