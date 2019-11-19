<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc;

class Deactivate
{
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
