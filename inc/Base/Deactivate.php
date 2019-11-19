<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc\Base;

class Deactivate
{
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
