<?php

/**
 * Class Form_Submissions
 *
 * Main loader for the Form Submissions plugin.
 */
class Form_Submissions
{

    /**
     * Run the plugin.
     */
    public function run()
    {
        // Include required classes.s
        require_once FORM_SUBMISSIONS_DIR . 'includes/class-form-submissions-form.php';
        require_once FORM_SUBMISSIONS_DIR . 'includes/class-form-submissions-field.php';
        require_once FORM_SUBMISSIONS_DIR . 'includes/class-form-submissions-admin.php';

        // Load the admin functionalities.
        $admin = new Form_Plugin_Admin();

        // Load the form front-end functionality.
        $form = new Form_Plugin_Form();

        // Register custom post type.
        add_action('init', array($admin, 'register_custom_post_type'));

        // Add metabox to display custom fields.
        add_action('add_meta_boxes', array($admin, 'add_custom_metabox'));


        // Register shortcode to display the form on the front end.
        add_shortcode('form_submissions', array($form, 'render_form'));

        // Handle form submission.
        add_action('init', array($form, 'handle_form_submission'));

        add_filter('form_submissions_fields', array($this, 'add_custom_fields_to_form'));

        // Enqueue front-end assets.
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    function add_custom_fields_to_form($fields)
    {
        // Custom fields hum add kar rahe hain
        $custom_fields = array(
            'last_name' => 'Last Name :',
            'phone'     => 'Phone Number :',
            'message'   => 'Your Message :',
        );

        // Default + Custom ko merge karo
        return array_merge($fields, $custom_fields);
    }

    /**
     * Enqueue plugin assets such as CSS for the front-end.
     */
    public function enqueue_assets()
    {
        wp_enqueue_style(
            'form-submissions-style',
            plugin_dir_url(__FILE__) . '../assets/css/style.min.css',
            array(),
            '1.0.0'
        );
    }
}
