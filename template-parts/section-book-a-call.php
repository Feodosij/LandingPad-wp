<?php
/**
 * Reusable Template: Book a call Section
 */

$accent_font = isset($GLOBALS['accent_font']) ? $GLOBALS['accent_font'] : '#2967F0';
$accent_bg_light = isset($GLOBALS['accent_bg_light']) ? $GLOBALS['accent_bg_light'] : '#2967F0';

$form_shortcode = '[contact-form-7 id="7f0ba5d" title="Get in touch"]';
?>

<section class="book-call" id="form" style="--accent_font: <?php echo esc_attr( $accent_font ); ?>; --accent_bg_light: <?php echo esc_attr( $accent_bg_light ); ?>;">
    <div class="container">
        <div class="book-call__header">
            <h2 class="book-call__title">
                <span>Book</span> an call
                <svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.0941 24.5C11.2426 24.5 6.25248 24.2745 1.5 24.2745M18.3713 18.4118L8.39109 6.68628M25.5 16.3824C25.5 15.6608 25.5 6.16013 25.5 1.5" stroke="#2967F0" stroke-width="3" stroke-linecap="round" />
                </svg>
            </h2>
        </div>
        
        <div class="book-call__form-wrapper">
            <?php echo do_shortcode( $form_shortcode ); ?>
        </div>
    </div>
</section>