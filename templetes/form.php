<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get all form fields via the Form_Plugin_Form class
$form_fields = ( new Form_Plugin_Form() )->get_form_fields();
?>

<form method="post" class="form">
    <?php
    // Nonce field for security
    wp_nonce_field( 'form_submissions_action', 'form_submissions_nonce' );

    // Loop through and render all form fields
    foreach ( $form_fields as $field_name => $field_label ) {
        echo Input_Field::render(
            $field_name === 'email' ? 'email' : 'text',
            $field_name,
            $field_label
        );
    }
    ?>

    <!-- Submit Button -->
    <div class="form__submit">
        <button class="form__button" type="submit">
            <?php echo esc_html__( 'Submit', 'form-submissions' ); ?>
        </button>
    </div>
</form>
