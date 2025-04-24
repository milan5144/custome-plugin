<?php

/**
 * Class Form
 *
 * Handles the rendering of the dynamic form and submission processing.
 */
class Form
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Register shortcode to display the form on the front end.
        add_shortcode('form_submissions', array($this, 'render_form'));

        // Handle form submission.
        add_action('init', array($this, 'handle_form_submission'));
    }

    /**
     * Get default form fields (Reusable).
     *
     * @return array
     */
    public function get_form_fields()
    {
        return apply_filters('form_submissions_fields', array(
            'first_name'  => 'First Name :',
            'last_name' => 'Last Name',
            'email' => 'Email :',
            'phone' => 'Phone Number',
            'message' => 'Your Message',
        ));
    }

    /**
     * Renders the form by including the template.
     *
     * @return string HTML content of the form.
     */
    public function render_form()
    {
        ob_start();

        // Get form fields using reusable method.
        $form_fields = $this->get_form_fields();

        // Include the form template.
        include plugin_dir_path(__FILE__) . '../templetes/form.php';

        return ob_get_clean();
    }

    /**
     * Handles form submission.
     */
    public function handle_form_submission()
    {
        // Check if form is submitted
        if (isset($_POST['form_submissions_nonce'])) {

            // Verify nonce for security.
            if (! isset($_POST['form_submissions_nonce']) || ! wp_verify_nonce($_POST['form_submissions_nonce'], 'form_submissions_action')) {
                wp_die(esc_html__('Security check failed.', 'form-submissions'));
            }

            // Sanitize and prepare form data.
            $data   = array();
            $fields = $this->get_form_fields();

            foreach ($fields as $key => $label) {
                // Use appropriate sanitization function.
                if ('email' === $key) {
                    $data[$key] = isset($_POST[$key]) ? sanitize_email($_POST[$key]) : '';
                } else {
                    $data[$key] = isset($_POST[$key]) ? sanitize_text_field($_POST[$key]) : '';
                }
            }

            // Get page title from referer
            $page_title = '';
            if (isset($_SERVER['HTTP_REFERER'])) {
                $referer_url = esc_url_raw($_SERVER['HTTP_REFERER']);
                $page_id     = url_to_postid($referer_url);

                if ($page_id) {
                    $title = get_the_title($page_id);
                    if ($title && $title !== '') {
                        $page_title = $title;
                    }
                }
            }

            // Create new post to save form data
            $post_id = wp_insert_post(array(
                'post_title'   => sanitize_text_field($page_title),
                'post_type'    => 'form_submissions',
                'post_status'  => 'publish',
            ));

            // Save each sanitized field value as post meta.
            if ($post_id && ! is_wp_error($post_id)) {
                foreach ($data as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                }
            }

            // Redirect after submission
            wp_redirect(add_query_arg('submitted', 'true', wp_get_referer()));
            exit;
        }
    }
}
