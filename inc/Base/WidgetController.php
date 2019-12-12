<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/12/2019
 * Time: 7:31 PM
 * @package UltimatePlugin
 */

namespace Inc\Base;

use Inc\Api\Widgets\MediaWidget;

class WidgetController extends BaseController {

    public function register() {
        if(!$this->activated('media_widget')) return;

        $media_widget = new MediaWidget();
        $media_widget->register();
    }

}