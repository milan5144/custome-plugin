<?php

/**
 * Plugin Name: Form Submissions
 * Description: A plugin to create custom form submissions.
 * Version: 1.0.0
 * Author: milan baraiya
 */

if (! defined('ABSPATH')) {
    exit;
}

define('FORM_SUBMISSIONS_DIR', plugin_dir_path(__FILE__));
    

// Include required classes.
require_once FORM_SUBMISSIONS_DIR . 'includes/class-form-submissions.php';
require_once FORM_SUBMISSIONS_DIR . 'includes/class-form.php';
require_once FORM_SUBMISSIONS_DIR . 'includes/class-input-field.php';
require_once FORM_SUBMISSIONS_DIR . 'includes/class-admin.php';

/**
 * Initialize the plugin.
 * Instantiates the main plugin class and calls its `run()` method.
*/
function form_submissions_init()
{
    $plugin = new Form_Submissions();
    $plugin->run();
}
form_submissions_init();

/**
 * Enqueue custom styles in the admin area for the form submissions post type.
 *
 * @param string $hook The current admin page hook.
*/
add_action('admin_enqueue_scripts', 'custom_form_plugin_admin_styles');
function custom_form_plugin_admin_styles($hook)
{
    global $post_type;
    if ('form_submissions' === $post_type) {
        wp_enqueue_style(
            'custom-form-admin-style',
            plugin_dir_url(__FILE__) . 'assets/css/style.css',
            array(),
            '1.0.0'
        );
    }
}

/**
 * Add custom fields to the form dynamically using a filter.
 *
 * This allows extension of the form without modifying core logic.
 *
 * @param array $fields Existing form fields.
 * @return array Modified form fields.
 */
add_filter('form_submissions_fields', 'add_custom_fields_to_form');
function add_custom_fields_to_form($fields)
{
    $fields['last_name'] = 'Last Name :';
    $fields['phone'] = 'Phone Number :';
    $fields['message'] = 'Your Message :';
    return $fields;
}
