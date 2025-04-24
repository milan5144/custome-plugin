<?php

/**
 * Template: Form Layout
 *
 * This file outputs the form for front-end display.
 *
 * Available variables:
 *  - $form_fields: An associative array of form fields (e.g., [ 'name' => 'Name', 'email' => 'Email' ]).
 */

if (! defined('ABSPATH')) {
    exit;
}

// Start form markup.
?>
<form action="#" method="post" class="form">
    <?php
    /**
     * Output a nonce field for security to protect against CSRF.
     */
    wp_nonce_field('form_submissions_action', 'form_submissions_nonce');

    /**
     * Loop through all fields defined in $form_fields and include the
     * `form-field.php` template to render each field individually.
    */
    foreach ($form_fields as $field_name => $field_label) {

        include plugin_dir_path(__FILE__) . 'form-field.php';
    }
    ?>
    <!-- Submit button container -->
    <div class="form__submit">
        <input class="form__button" type="submit" value="<?php echo esc_attr__('Submit', 'form-submissions'); ?>">
    </div>
</form>