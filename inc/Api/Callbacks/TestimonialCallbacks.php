<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/16/2019
 * Time: 10:59 AM
 */

namespace Inc\Api\Callbacks;


use Inc\Base\BaseController;

class TestimonialCallbacks extends BaseController
{
    public function shortCodePage(){
        return require_once( "$this->plugin_path/templates/testimonial.php" );
    }
}