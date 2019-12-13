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
            'email' => sanitize_text_field($_POST['ultimate_testimonial_email']),
            'approved' => isset($_POST['ultimate_testimonial_approved']) ? 1 : 0,
            'featured' => isset($_POST['ultimate_testimonial_featured']) ? 1 : 0,
        );

        update_post_meta( $post_id, '_ultimate_testimonial_key', $data );
    }

}