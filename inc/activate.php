<?php
/**
 * @package RealEstateACFPlugin
 */
namespace RealEstateInc;

class Activate 
{
    public static function activate() {
        flush_rewrite_rules();
    }
}