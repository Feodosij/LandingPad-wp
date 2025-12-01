<?php
/**
 * Reusable Template: Intro content (use for rent, build, buy page)
 */

if ( ! have_rows( 'intro_apartment_content' ) ) {
    return;
}
?>

<section class="intro-apartment">
    <div class="container">
        <?php if ( have_rows( 'intro_apartment_content' ) ) { ?>
            <div class="intro-apartment__wrapper">
                <?php while ( have_rows( 'intro_apartment_content' ) ) {
                    the_row();
                    $item_title = get_sub_field( 'intro_title' );
                    $item_description = get_sub_field( 'intro_description' );
                    $item_image = get_sub_field( 'intro_image' );
                    ?>
                    <article class="intro-apartment__item">
                        <div class="intro-apartment__item-image">
                            <img src="<?php echo esc_url($item_image); ?>" alt="intro image" loading="lazy">
                        </div>

                        <div class="intro-apartment__item-content">
                            <h3 class="intro-apartment__item-title"><?php echo wp_kses_post($item_title); ?></h3>
                            <div class="intro-apartment__item-description"><?php echo wp_kses_post($item_description); ?></div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>