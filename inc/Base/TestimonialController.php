<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/5/2019
 * Time: 8:28 AM
 */

namespace Inc\Base;


use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;

class TestimonialController extends BaseController
{
    public function register() {

        if(!$this->activated('testimonial_manager')) return;

        add_action('init', array($this, 'testimonialCpt'));
        add_action('add_meta_boxes', array($this, 'addMetaBoxes'));
        add_action('save_post', array($this, 'saveMetaBox'));

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
            'supports' => array('title', 'editor')
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

        wp_nonce_field('ultimate_testimonial_author', 'ultimate_testimonial_author_nonce');
        $value = get_post_meta($post->ID, '_ultimate_testimonial_author_key', true);

        ?>
        <p>
            <label for="ultimate_testimonial_author">Testimonial Author</label>
            <input type="text" id="ultimate_testimonial_author" name="ultimate_testimonial_author" value="<?php echo esc_attr($value)?>">
        </p>
        <p>
            <label class="meta-label" for="alecaddd_testimonial_email">Author Email</label>
            <input type="email" id="alecaddd_testimonial_email" name="alecaddd_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
        </p>
        <div class="meta-container">
            <label class="meta-label w-50 text-left" for="alecaddd_testimonial_approved">Approved</label>
            <div class="text-right w-50 inline">
                <div class="ui-toggle inline"><input type="checkbox" id="alecaddd_testimonial_approved" name="alecaddd_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
                    <label for="alecaddd_testimonial_approved"><div></div></label>
                </div>
            </div>
        </div>
        <div class="meta-container">
            <label class="meta-label w-50 text-left" for="alecaddd_testimonial_featured">Featured</label>
            <div class="text-right w-50 inline">
                <div class="ui-toggle inline"><input type="checkbox" id="alecaddd_testimonial_featured" name="alecaddd_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
                    <label for="alecaddd_testimonial_featured"><div></div></label>
                </div>
            </div>
        </div>

        <?php
    }

    public function saveMetaBox($post_id) {
        if(!isset($_POST['ultimate_testimonial_author_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['ultimate_testimonial_author_nonce'];

        if(!wp_verify_nonce($nonce, 'ultimate_testimonial_author')) {
            return $post_id;
        }

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if(!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        $data = sanitize_text_field($_POST['ultimate_testimonial_author']);
        update_post_meta($post_id, '_ultimate_testimonial_author_key', $data);
    }

}