<?php
/**
 * Reusable Template: Instagram Section
 */
?>

<section class="instagram">
    <div class="container">
        <div class="instagram__header">
            <h2 class="instagram__title"> Instagram
                <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.3663 36.7329C22.5247 36.7329 29.802 36.3898 36.7327 36.3898M12.1287 27.4682L26.6832 9.62507M1.73267 24.38C1.73267 23.2819 1.73267 8.82441 1.73267 1.73291" stroke="#0F38B4" stroke-width="3.46535" stroke-linecap="round" />
                </svg>
            </h2>
        </div>
        
        <?php echo do_shortcode( '[instagram-feed feed=1]' ); ?>
    </div>
</section>