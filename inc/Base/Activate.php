<?php
/**
 * @package RealEstateACFPlugin
 */

namespace RealEstateInc\Base;

class Activate 
{
    public static function activate() {
        flush_rewrite_rules();
    }
}