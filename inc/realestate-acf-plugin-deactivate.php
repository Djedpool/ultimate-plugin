<?php
/**
 * @package RealEstateACFPlugin
 */

class RealEstateACFPluginDeactivate
{
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
