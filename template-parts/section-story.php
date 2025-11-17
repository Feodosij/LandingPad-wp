<?php
/**
 * Reusable Template: Our story Section
 */

$our_story_bg = get_field('our_story_image', 'option');
?>

 <section class="our-story" style="<?php echo $our_story_bg ? 'background-image: url(' . esc_url($our_story_bg) . ');' : ''; ?>">
    <div class="container">
        <div class="our-story__content">
            <?php if ( $our_story_title = get_field('our_story_title', 'option') ) { ?>
                <h2 class="our-story__title"><?php echo esc_html( $our_story_title ); ?></h2>
            <?php } ?>

            <?php if ( $our_story_text = get_field('our_story_text', 'option') ) { ?>
                <div class="our-story__text"><?php echo wp_kses_post( $our_story_text ); ?></div>
            <?php } ?>
        </div>                             
    </div>
</section>