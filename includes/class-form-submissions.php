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
        // Load the form front-end functionality.
        new Form();

        // Load the admin functionalities.
        new Admin();

        // Enqueue front-end assets.
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    /**
     * Enqueue plugin assets such as CSS for the front-end.
     */
    public function enqueue_assets()
    {
        wp_enqueue_style(
            'form-submissions-style',
            plugin_dir_url(__FILE__) . '../assets/css/style.css',
            array(),
            '1.0.0'
        );
    }
}
