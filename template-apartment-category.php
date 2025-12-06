<?php
/*
Template Name: Template Apartment Category
Template Post Type: page
*/

$page_slug = get_post_field( 'post_name', get_the_ID() );

if ( $page_slug === 'rent' ) {
    $term_slug = 'rent';
    $GLOBALS['accent_main'] = 'rgb(23, 205, 204)';
    $GLOBALS['accent_bg'] = '#DFF7F8';
    $GLOBALS['accent_font'] = '#14A4AD';
    $GLOBALS['accent_bg_light'] = '#F8FDFD';

} elseif ( $page_slug === 'buy' ) {
    $term_slug = 'buy';
    $GLOBALS['accent_main'] = 'rgb(158, 102, 212)';
    $GLOBALS['accent_bg'] = '#EFEAF9';
    $GLOBALS['accent_font'] = '#714A99';
    $GLOBALS['accent_bg_light'] = '#FCF9FF';
} elseif ( $page_slug === 'build' ) {
    $term_slug = 'build';
    $GLOBALS['accent_main'] = 'rgb(84, 151, 128)';
    $GLOBALS['accent_bg'] = '#E7F0EC';
    $GLOBALS['accent_font'] = '#376E5B';
    $GLOBALS['accent_bg_light'] = '#F9FDFB';
}

get_header();
?>

<main>

    <!-- section Hero Services -->
    <?php get_template_part( 'template-parts/section', 'hero-services' ); ?>

    <!-- section Intro Apartment -->
    <?php get_template_part( 'template-parts/section', 'intro-apartment' ); ?>

    <?php 
    $posts_per_page = 3;

    $paged = 1;

    $apartments_query = new WP_Query( array(
        'post_type' => 'apartment',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'paged' => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'apartments_category',
                'field'    => 'slug',
                'terms'    => $term_slug,
            ),
        ),
    ) ); 

    if ( $apartments_query->have_posts() ) { ?>

        <section class="apartments">
            <div class="container">
                <?php $apartment_section_title = get_field( 'apartment_section_title' );
                    if ( $apartment_section_title ) {?>
                        <h2 class="apartments__title">
                            <?php echo wp_kses_post( $apartment_section_title ); ?>
                            <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.3661 36.7327C22.5245 36.7327 29.8017 36.3895 36.7324 36.3895M12.1285 27.468L26.6829 9.62482M1.73242 24.3797C1.73242 23.2817 1.73242 8.82417 1.73242 1.73266" stroke="#14A4AD" stroke-width="3.46535" stroke-linecap="round" />
                            </svg>
                        </h2>
                <?php } ?>

                <?php $apartment_section_subtitle = get_field( 'apartment_section_subtitle' );
                    if ( $apartment_section_subtitle ) { ?>
                        <h3 class="apartments__subtitle"><?php echo esc_html( $apartment_section_subtitle ); ?></h3>
                <?php } ?>

                <div class="apartments__wrapper" id="apartments-wrapper"
                    data-term="<?php echo esc_attr( $term_slug ); ?>"
                    data-per-page="<?php echo esc_attr( $posts_per_page ); ?>"
                    data-current-page="1"
                    data-max-pages="<?php echo esc_attr( $apartments_query->max_num_pages ); ?>">

                    <?php while ( $apartments_query->have_posts() ) { 
                        $apartments_query->the_post(); 

                        get_template_part( 'template-parts/content', 'apartment-card' );

                    } wp_reset_postdata(); ?>
                </div>
                
                <?php if ($apartments_query->max_num_pages > 1 ) { ?>
                    <div class="apartments__load-more">
                        <button id="apartments-load-more" class="load_more_button">Load more</button>
                    </div>
                <?php } ?>
            </div>
        </section>

    <?php } ?>

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