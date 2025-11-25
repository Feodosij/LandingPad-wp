<?php
/**
 * Reusable Template: Hero-service Section
 */

$hero_service_background = get_field('hero_service_background');
$hero_service_masked_text = get_field('hero_service_masked_text');
$hero_service_title = get_field('hero_service_title');
$hero_service_description = get_field('hero_service_description');
$hero_service_link = get_field('hero_service_link');

?>

<section class="hero-service">
    <div class="container">
        <div class="hero-service__content">
            <?php if ( $hero_service_masked_text ) { ?>
                <h1 class="hero-service__masked"><?php echo esc_html( $hero_service_masked_text ); ?></h1>
            <?php } ?>

            <?php if ( $hero_service_title ) { ?>
                <h2 class="hero-service__title"><?php echo esc_html( $hero_service_title ); ?></h2>
            <?php } ?>

            <?php if ( $hero_service_description ) { ?>
                <p class="hero-service__description"><?php echo esc_html( $hero_service_description ); ?></p>
            <?php } ?>

             <?php if ( $hero_service_link ) { 
                $link_url = esc_url( $hero_service_link['url'] );
                $link_title = esc_html( $hero_service_link['title'] ); ?>

                <a href="<?php echo $link_url ?>" class="hero-service__link"><?php echo $link_title ?></a>
             <?php } ?>
        </div>
    </div>
    <?php if ( $hero_service_background ) { ?>
        <img src="<?php echo esc_url($hero_service_background); ?>" alt="Service Background" class="hero-service__background" loading="lazy">
    <?php } ?>
</section>