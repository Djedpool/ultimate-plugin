<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/3/2019
 * Time: 7:31 PM
 * @package UltimatePlugin
 */

namespace Inc\Api;

use WP_Widget;

class MediaWidget extends WP_Widget {
    public $widget_ID;
    public $widget_name;
    public $widget_options = array();
    public $control_options = array();

    public function __construct() {
        $this->widget_ID = 'ultimate_media_widget';
        $this->widget_name = 'Ultimate Media Widget';
        $this->widget_options = array(
            'classname' => $this->widget_ID,
            'description' => $this->widget_name,
            'customize_selective_refresh' => true
        );
        $this->control_options = array(
            'width' => 400,
            'height' => 350,
        );
    }

    public function _register() {
        parent::__construct($this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options);

        add_action('widgets_init', array($this, 'widgetInit'));
    }

    public function widgetInit() {
        register_widget($this);
    }

    // widget()

    // form()

    // update()
}