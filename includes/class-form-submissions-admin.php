<?php

/**
 * Class Admin
 *
 * Handles admin-side functionality, including custom post type registration and metabox.
 */
class Form_Plugin_Admin{
    /**
     * Registers the custom post type for form submissions.
     */
    public function register_custom_post_type()
    {
        $labels = array(
            'name'          => esc_html__('Form Submissions', 'form-submissions'),
            'singular_name' => esc_html__('Form Submission', 'form-submissions'),
            'add_new'       => esc_html__('Add New', 'form-submissions'),
            'add_new_item'  => esc_html__('Add New Submission', 'form-submissions'),
            'edit_item'     => esc_html__('Edit Submission', 'form-submissions'),
            'all_items'     => esc_html__('Form Submissions', 'form-submissions'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'show_ui'            => true,
            'has_archive'        => false,
            'supports'           => array('title'),
            'menu_icon'          => 'dashicons-feedback',
        );

        register_post_type('form_submissions', $args);
    }

    /**
     * Adds a custom metabox for displaying form fields.
     */
    public function add_custom_metabox()
    {
        add_meta_box(
            'form_submission_data',
            esc_html__('Submission Data', 'form-submissions'),
            array($this, 'render_metabox'),
            'form_submissions',
            'normal',
            'default'
        );
    }

    /**
     * Renders the metabox which displays the stored form data.
     *
     * @param WP_Post $post The current post object.
     */
    public function render_metabox($post)
    {
        $meta = get_post_meta($post->ID); // Retrieve the stored metadata.

        // If metadata exists, display it in a list.
        if (! empty($meta)) {
            echo '<div class="admin-meta">';
            echo '<ul class="admin-meta__list">';

            foreach ($meta as $key => $value) {
                echo '<li class="admin-meta__item">';
                echo '<span class="admin-meta__label">' . esc_html(ucfirst($key)) . ':</span> ';
                echo '<span class="admin-meta__value">' . esc_html(maybe_unserialize($value[0])) . '</span>';
                echo '</li>';
            }

            echo '</ul>';
            echo '</div>';
        } else {
            // If no data is found, display a message.
            echo '<p class="admin-meta__empty">' . esc_html__('No form data found.', 'form-submissions') . '</p>';
        }
    }
}
