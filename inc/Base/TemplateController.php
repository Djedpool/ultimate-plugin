<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:36 AM
 */

namespace Inc\Base;


class TemplateController extends BaseController
{
    public $templates;

    public function register() {
        if(!$this->activated('template_manager')) return;

        $this->templates = array(
            'page-templates/two-columns-tpl.php' => 'Two Columns Layout'
        );

        add_filter('theme_page_templates', array($this, 'customTemplate'));
        add_filter('template_include', array($this, 'loadTemplate'));
    }

    public function customTemplate($templates) {
        $templates = array_merge($templates, $this->templates);
        return $templates;
    }

    public function loadTemplate($template) {
        global $post;

        if(!$post) {
            return $template;
        }

        // If is the front page,  load a custom template
        if(is_front_page()) {
            $file = $this->plugin_path . 'page-templates/front-page.php';

            if(file_exists($file)) {
                return $file;
            }
        }

        $template_name = get_post_meta($post->ID, '_wp_page_template', true);

        if(!isset($this->templates[$template_name])) {
            return $template;
        }

        $file = $this->plugin_path . $template_name;

        if(file_exists($file)) {
            return $file;
        }

        return $template;
    }
}