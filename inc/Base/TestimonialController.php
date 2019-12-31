<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:28 AM
 */

namespace Inc\Base;


use Inc\Api\SettingsApi;
use Inc\Api\Callbacks\TestimonialCallbacks;

class TestimonialController extends BaseController
{
    public $settings;
    public $callbacks;

    public function register() {

        if(!$this->activated('testimonial_manager')) return;

        $this->settings = new SettingsApi();
        $this->callbacks = new TestimonialCallbacks();

        add_action('init', array($this, 'testimonialCpt'));
        add_action('add_meta_boxes', array($this, 'addMetaBoxes'));
        add_action('save_post', array($this, 'saveMetaBox'));
        add_action('manage_testimonial_posts_columns', array($this, 'setCustomColumns'));
        add_action('manage_testimonial_posts_custom_column', array($this, 'setCustomColumnsData'), 10, 2);

        add_filter('manage_edit-testimonial_sortable_columns', array($this, 'setCustomColumnsSortable'), 10, 2);

        $this->setShortcodePage();

        add_shortcode('testimonial-form', array($this, 'testimonialForm'));
        add_shortcode('testimonial-slideshow', array($this, 'testimonialSlideshow'));
        add_action('wp_ajax_submit_testimonial', array($this, 'submitTestimonial'));
        add_action('wp_ajax_nopriv_submit_testimonial', array($this, 'submitTestimonial'));
    }

    public function submitTestimonial() {

        if(!DOING_AJAX || !check_ajax_referer('testimonial-nonce', 'nonce', false)) {
            $this->returnJson('error');
        }

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        $data = array(
            'name' => $name,
            'email' => $email,
            'approved' => 0,
            'featured' => 0
        );

        $args = array(
            'post_title' => 'Testimonial from '.$name,
            'post_content' => $message,
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'testimonial',
            'meta_input' => array(
                '_ultimate_testimonial_key' => $data
            )
        );

        $postID = wp_insert_post($args);

        if($postID) {
            $this->returnJson('success');
        }

        $this->returnJson('error');

    }

    public function returnJson($status) {
        $return = array(
            'status' => $status
        );
        wp_send_json($return);

        wp_die();
    }

    public function testimonialForm() {
        ob_start();
        echo '<link rel="stylesheet" href="'.$this->plugin_url.'/assets/form.css" type="text/css" media="all">';
        require_once("$this->plugin_path/templates/contact-form.php");
        echo '<script src="'.$this->plugin_url.'assets/form.js"></script>';
        return ob_get_clean();

    }

    public function testimonialSlideshow() {
        ob_start();
        echo '<link rel="stylesheet" href="'.$this->plugin_url.'/assets/slider.css" type="text/css" media="all">';
        require_once("$this->plugin_path/templates/slider.php");
        echo '<script src="'.$this->plugin_url.'assets/slider.js"></script>';
        return ob_get_clean();
    }

    public function setShortcodePage() {
        $subpage = array(
            array(
                'parent_slug' => 'edit.php?post_type=testimonial',
                'page_title' => 'Shortcodes',
                'menu_title' => 'Shortcodes',
                'capability' => 'manage_options',
                'menu_slug' => 'utlimate_testimonial_schortcode',
                'callback' => array($this->callbacks, 'shortCodePage')
            )
        );

        $this->settings->addSubPages($subpage)->register();
    }

    public function testimonialCpt() {

        $labels = array(
            'name' => 'Testimonials',
            'singular_name' => 'Testimonials'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-testimonial',
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'supports' => array('title', 'editor'),
            'show_in_rest' => true
        );

        register_post_type('testimonial', $args);

    }

    public function addMetaBoxes() {

        add_meta_box(
            'testimonial_author',
            'Testimonial Options',
            array($this, 'renderFeaturesBox'),
            'testimonial',
            'side',
            'default'
        );

    }

    public function renderFeaturesBox($post) {

        wp_nonce_field('ultimate_testimonial', 'ultimate_testimonial_nonce');

        $data = get_post_meta( $post->ID, '_ultimate_testimonial_key', true );
        $name = isset($data['name']) ? $data['name'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $approved = isset($data['approved']) ? $data['approved'] : false;
        $featured = isset($data['featured']) ? $data['featured'] : false;

        ?>
        <p>
            <label for="ultimate_testimonial_author">Testimonial Author</label>
            <input type="text" id="ultimate_testimonial_author" name="ultimate_testimonial_author" value="<?php echo esc_attr($name); ?>">
        </p>
        <p>
            <label class="meta-label" for="ultimate_testimonial_email">Author Email</label>
            <input type="email" id="ultimate_testimonial_email" name="ultimate_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
        </p>
        <div class="meta-container">
            <label class="meta-label w-50 text-left" for="ultimate_testimonial_approved">Approved</label>
            <div class="text-right w-50 inline">
                <div class="ui-toggle inline"><input type="checkbox" id="ultimate_testimonial_approved" name="ultimate_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
                    <label for="ultimate_testimonial_approved"><div></div></label>
                </div>
            </div>
        </div>
        <div class="meta-container">
            <label class="meta-label w-50 text-left" for="ultimate_testimonial_featured">Featured</label>
            <div class="text-right w-50 inline">
                <div class="ui-toggle inline"><input type="checkbox" id="ultimate_testimonial_featured" name="ultimate_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
                    <label for="ultimate_testimonial_featured"><div></div></label>
                </div>
            </div>
        </div>

        <?php
    }

    public function saveMetaBox($post_id) {

        if (!isset($_POST['ultimate_testimonial_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['ultimate_testimonial_nonce'];

        if (!wp_verify_nonce( $nonce, 'ultimate_testimonial')) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id )) {
            return $post_id;
        }

        $data = array(
            'name' => sanitize_text_field($_POST['ultimate_testimonial_author']),
            'email' => sanitize_email($_POST['ultimate_testimonial_email']),
            'approved' => isset($_POST['ultimate_testimonial_approved']) ? 1 : 0,
            'featured' => isset($_POST['ultimate_testimonial_featured']) ? 1 : 0,
        );

        update_post_meta( $post_id, '_ultimate_testimonial_key', $data );
    }

    public function setCustomColumns($columns) {

        $title = $columns['title'];
        $date = $columns['date'];
        unset($columns['title'], $columns['date']);

        $columns['name'] = 'Author Name';
        $columns['title'] = $title;
        $columns['approved'] = 'Approved';
        $columns['featured'] = 'Featured';
        $columns['date'] = $date;

        return $columns;
    }

    public function setCustomColumnsData($column, $post_id) {
        $data = get_post_meta( $post_id, '_ultimate_testimonial_key', true );
        $name = isset($data['name']) ? $data['name'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $approved = isset($data['approved']) && $data['approved'] == 1 ? '<strong>YES</strong>' : 'NO';
        $featured = isset($data['featured']) && $data['featured'] == 1 ? '<strong>YES</strong>' : 'NO';

        switch($column) {
            case 'name':
                echo '<strong>'.$name.'</strong></br><a href="malito:"'.$email.'">'.$email.'</a>';
                break;
            case 'approved':
                echo $approved;
                break;
            case 'featured':
                echo $featured;
                break;
        }
    }

    public function setCustomColumnsSortable($columns) {
        $columns['name'] = 'name';
        $columns['approved'] = 'approved';
        $columns['featured'] = 'featured';

        return $columns;
    }
}