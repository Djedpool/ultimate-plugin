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


        $output = get_option('ultimate_plugin_cpt');

        if (count($output) == 0) {
            $output[$input['post_type']] = $input;
            return $output;
        }

        foreach ($output as $key => $value) {
            if ($input['post_type'] === $key) {
                $output[$key] = $input;
            } else {
                $output[$input['post_type']] = $input;
            }
        }

        return $output;
    }

    public function textField($args){
        $name = $args['label_for'];
        $option_name = $args['option_name'];

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="" placeholder="' . $args['placeholder'] . '" required="required">';
    }

    public function checkboxField($args){
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];

        echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class=""><label for="' . $name . '"><div></div></label></div>';
    }
}