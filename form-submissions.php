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

// Yahan file ka sahi path dena
require_once plugin_dir_path( __FILE__ ) . 'includes/class-form-submissions-hook.php';
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
