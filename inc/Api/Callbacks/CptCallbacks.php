<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 11:42 AM
 */

namespace Inc\Api\Callbacks;

class CptCallbacks
{
    public function cptSectionManager(){
        echo 'Create as many Custom Post Types as you want.';
    }

    public function cptSanitize($input) {
        return $input;
    }

    public function textField($args) {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option($option_name);
        $value =  $input[$name];


        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="'.$args['placeholder'].'">';
    }

    public function checkboxField($args){
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $checkbox = get_option($option_name);

        echo '<div class="'.$classes.'"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ($checkbox[$name] ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
    }
}