<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/3/2019
 * Time: 7:31 PM
 * @package UltimatePlugin
 */

namespace Inc\Api\Widgets;

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

    public function register() {
        parent::__construct($this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options);

        add_action('widgets_init', array($this, 'widgetInit'));
    }

    public function widgetInit() {
        register_widget($this);
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        if(!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        if(!empty($instance['image'])) {
            echo '<img src="' . esc_url($instance['image']) . '" alt="">';
        }
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Custom Text', 'ultimate_plugin');
        $image = !empty($instance['image']) ? $instance['image'] : '';

        $titleID = esc_attr($this->get_field_id('title'));
        $imageID = esc_attr($this->get_field_id('image'));

        ?>
            <p>
                <label for="<?php echo $titleID; ?>">Title</label>
                <input type="text" class="widefat" id="<?php echo $titleID; ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo $imageID; ?>">Image</label>
                <input type="text" class="widefat image-upload" id="<?php echo $imageID; ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_url($image); ?>">
                <button type="button" class="button button-primary js-image-upload">Select Image</button>
            </p>
        <?php

    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['image'] = !empty($new_instance['image']) ? $new_instance['image'] : '';

        return $instance;
    }

}