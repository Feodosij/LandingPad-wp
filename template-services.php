<?php
/*
Template Name: Template Services
Template Post Type: page
*/
get_header();

$GLOBALS['accent_bg'] = '#DBEBFF';
$GLOBALS['accent_font'] = '#0F38B4';
$GLOBALS['accent_blur'] = '#3060C9';
$GLOBALS['accent_bg_light'] = '#F9FBFF';

$accent_font = isset($GLOBALS['accent_font']) ? $GLOBALS['accent_font'] : '#0F38B4';

$section_services_title = get_field('section_services_title');
$section_services_subtitle = get_field('section_services_subtitle');
$section_services_text = get_field('section_services_text');

?>

<main>

    <!-- section Hero Services -->
    <?php get_template_part( 'template-parts/section', 'hero-services' ); ?>

    <section class="services" style="--accent_font: <?php echo esc_attr( $accent_font ); ?>;">
        <div class="container">
            <div class="services__header">
                <?php if ( $section_services_title ) { ?>
                    <h2 class="services__title">
                        <?php echo wp_kses_post( $section_services_title ); ?>

                        <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.3661 36.7327C22.5245 36.7327 29.8017 36.3895 36.7324 36.3895M12.1285 27.468L26.6829 9.62482M1.73242 24.3797C1.73242 23.2817 1.73242 8.82417 1.73242 1.73266" stroke="#0F38B4" stroke-width="3.46535" stroke-linecap="round" />
                        </svg>
                    </h2>
                <?php } ?>

                <?php if ( $section_services_subtitle ) { ?>
                    <div class="services__subtitle"><?php echo esc_html( $section_services_subtitle ); ?></div>
                <?php } ?>
                
                <?php if ( $section_services_text ) { ?>
                    <div class="services__text"><?php echo esc_html( $section_services_text ); ?></div>
                <?php } ?>
            </div>
            
            <?php
                $services_query = new WP_Query( array(
                'post_type' => 'services',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC'
            )); 
            
            if ( $services_query->have_posts() ) { ?>
                <div class="services__grid">
                    <?php while ( $services_query->have_posts() ) { 
                        $services_query->the_post(); ?>

                        <article class="service-card">
                            <div class="service-card__header">
                                <?php if ( has_post_thumbnail() ) { ?>
                                    <div class="service-card__thumbnail">
                                        <?php the_post_thumbnail(); ?> 
                                    </div>
                                <?php } ?>

                                <h3 class="service-card__title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                            </div>

                            <?php if ( have_rows( 'service_items' ) ) { ?>
                                <ul class="service-card__list">
                                    <?php while ( have_rows( 'service_items' ) ) { 
                                        the_row(); 
                                        $item_title = get_sub_field( 'single_title' );
                                        $item_slug = sanitize_title( $item_title );

                                        $service_permalink = get_permalink();
                                        $full_link = $service_permalink . '#' . esc_attr( $item_slug ); ?>

                                        <li class="service-card__item">
                                            <a class="service-card__item-link" href="<?php echo esc_url( $full_link ); ?>">
                                                <?php echo esc_html( $item_title ); ?>

                                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.366 11.2344C1.05358 11.5468 0.54705 11.5468 0.234631 11.2344C-0.0777886 10.9219 -0.0777893 10.4154 0.23463 10.103L4.60326 5.73436L0.23463 1.36573C-0.0777892 1.05332 -0.0777891 0.546782 0.23463 0.234364C0.54705 -0.0780554 1.05358 -0.0780564 1.366 0.234363L6.866 5.73436L1.366 11.2344Z" fill="#0F0F10" />
                                                </svg>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </article>
                    <?php } wp_reset_postdata(); ?>

                    <article class="default-card">
                        <?php 
                            $default_card_question = get_field( 'default_card_question' );
                            $default_card_link = get_field( 'default_card_link' );
                            $default_card_background = get_field( 'default_card_background' );
                        ?>
                        <?php if ( $default_card_background ) { ?>
                            <img src="<?php echo esc_url( $default_card_background ); ?>" alt="card background" class="default-card__background" loading="lazy">
                        <?php } ?>

                        <div class="default-card__content">
                            <?php if ( $default_card_question ) { ?>
                                <h4 class="default-card__title"><?php echo esc_html( $default_card_question ); ?></h4>
                            <?php } ?>

                            <?php if ( $default_card_link ) { ?>
                                <a href="<?php echo esc_url( $default_card_link['url'] ); ?>" class="default-card__link">
                                    <?php echo esc_html( $default_card_link['title'] ); ?>
                                </a>
                            <?php } ?>
                        </div>
                    </article>
                </div>
            <?php } ?>  
        </div>
    </section>

    <!-- section Our story -->
    <?php get_template_part( 'template-parts/section', 'story' ); ?>

    <!-- section Team -->
    <?php get_template_part( 'template-parts/section', 'team' ); ?>

    <!-- section Contacts -->
    <?php get_template_part( 'template-parts/section', 'contacts'); ?>

    <!-- section Book a call -->
    <?php get_template_part( 'template-parts/section', 'book-a-call'); ?>

    <!-- section Instagram -->
    <?php get_template_part( 'template-parts/section', 'instagram'); ?>

</main>

<?php get_footer(); ?>