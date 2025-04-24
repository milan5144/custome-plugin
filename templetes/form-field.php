<?php

/**
 * Template: Form Field
 *
 * Renders an individual form field.
 *
 * Variables expected:
 *   - $field_name: The key/name for the field.
 *   - $field_label: The label for the field.
 */
if (! defined('ABSPATH')) {
    exit;
}
// Ensure the required variables are set. If not, assign default values.
if (! isset($field_name, $field_label)) {
    // Optionally handle the error or assign default values.
    $field_name  = 'default_name';
    $field_label = 'Default Label';
}
/*
 * Render the input field. If the field name is "email", render an email input.
 * Otherwise, render a text input.
*/
echo Input_Field::render(('email' === $field_name ? 'email' : 'text'), $field_name, $field_label);
