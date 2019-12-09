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

        $post_type = strtolower(str_replace(' ', '', $input['post_type']));

        $output = get_option('ultimate_plugin_cpt');

        if(isset($_POST['remove'])) {

            $delete = strtolower(str_replace(' ', '', $_POST['remove']));
            unset($output[$delete]);

            return $output;
        }


        if (count($output) == 0) {
            $output[$post_type] = $input;
            return $output;
        }

        foreach ($output as $key => $value) {
            if ($post_type === $key) {
                $output[$key] = $input;
            } else {
                $output[$post_type] = $input;
            }
        }
        return $output;
    }

    public function textField($args){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $readonly = '';

        if(isset($_POST["edit_post"])) {
            $input = get_option($option_name);
            $value = $input[strtolower(str_replace(' ', '',$_POST['edit_post']))][$name];

            $readonly = ($name === 'post_type') ? 'readonly' : '';
        }

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'. $value .'" placeholder="' . $args['placeholder'] . '" required="required" ' . $readonly .'>';
    }

    public function checkboxField($args){
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $checked = false;
        if (isset($_POST["edit_post"])) {
            $post_type_name = strtolower(str_replace(' ', '', $_POST["edit_post"]));
            $checkbox = get_option($option_name);
            $checked = isset($checkbox[$post_type_name][$name])?: false;
        }
        echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
    }
}