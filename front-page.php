<?php
/*
* Template Name: Front page
* Template Post Type: page
*/

$GLOBALS['accent_main'] = '#2967F0';
$GLOBALS['accent_bg'] = '#DBEBFF';
$GLOBALS['accent_font'] = '#0F38B4';
$GLOBALS['accent_bg_light'] = '#F9FBFF';

get_header(); 

$hero_bg = get_field('background_image');
if ( $hero_bg ) {
    $background_style = 'style="background-image: url(' . esc_url($hero_bg) . ');"';
}
?>

<main>
    <section class="hero" <?php echo $background_style; ?>>
        <div class="hero__container container">
            <div class="hero__content">
                <?php if ( $main_title = get_field('main_title') ) { ?>
                    <h1 class="hero__title">
                        <?php echo esc_html( $main_title ); ?>
                    </h1>
                <?php } ?>

                <?php if ( $main_desc = get_field('main_description') ) { ?>
                    <div class="hero__description">
                        <?php echo wp_kses_post( $main_desc ); ?>
                    </div>
                <?php } ?>
            </div>

            <?php if ( have_rows( 'cards' ) ) { ?>
                <div class="hero__cards">
                    <?php while ( (have_rows( 'cards' ) ) ) {
                        the_row(); 
                        $title  = get_sub_field('card_title');
                        $desc   = get_sub_field('card_description');
                        $btn_text = get_sub_field('button_text');

                        $link   = get_sub_field('card_link');
                        $link_url = $link ? $link : '#';

                        $color  = get_sub_field('card_color');
                        $accent_color = $color ? $color : '#5485F3';  ?>
                        
                        <div class="hero-card" style="--card-accent: <?php echo esc_attr($accent_color); ?>;">
                            <a href="<?php echo esc_url($link_url); ?>" class="hero-card__link">
                                <span class="screen-reader-text"><?php echo esc_html($title); ?></span>
                            </a>

                            <?php if ( $title ) { ?>
                                <h2 class="hero-card__title"><?php echo esc_html($title); ?></h2>
                            <?php } ?>

                            <?php if ( $desc ) { ?>
                                <p class="hero-card__text"><?php echo esc_html($desc); ?></p>
                            <?php } ?>
                            
                            <div class="hero-card__btn-wrapper">
                                <a href="<?php echo esc_url( $link_url ); ?>" class="hero-card__btn">Learn more</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
    
    <!-- section Our story -->
    <?php get_template_part( 'template-parts/section', 'story' ); ?>

    <?php 
    $testimonials_query = new WP_Query( array(
        'post_type' => 'testimonials',
        'post_per_page' => -1,
        'post_status' => 'publish',
    ) ); 

    if ( $testimonials_query->have_posts() ) { ?>

        <section class="testimonials">
            <div class="container">
                <div class="testimonials__slider" id="testimonials">
                    <?php while ( $testimonials_query->have_posts() ) {
                        $testimonials_query->the_post(); 
                        
                        $job = get_field( 'job_position' );
                        $rating = get_field( 'rating' ); ?>

                        <div class="testimonials__item">
                            <article class="testimonial-card">
                                <header class="testimonial-card__header">
                                    <div class="testimonial-card__author">
                                        <h3 class="testimonial-card__name"><?php the_title(); ?></h3>
                                        <?php if ( $job ) { ?>
                                            <div class="testimonial-card__job"><?php echo esc_html( $job ) ?></div>
                                        <?php } ?>
                                    </div>

                                    <div class="testimonial-card__rating">
                                        <?php 
                                            $star_svg = '<svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.66851 0.345484C4.81819 -0.115171 5.4699 -0.115172 5.61957 0.345483L6.49113 3.02786C6.55806 3.23387 6.75004 3.37335 6.96666 3.37335H9.78707C10.2714 3.37335 10.4728 3.99316 10.081 4.27786L7.7992 5.93565C7.62395 6.06298 7.55063 6.28866 7.61756 6.49467L8.48912 9.17704C8.63879 9.6377 8.11156 10.0208 7.7197 9.73606L5.43794 8.07826C5.26269 7.95094 5.02539 7.95094 4.85015 8.07826L2.56839 9.73606C2.17653 10.0208 1.64929 9.6377 1.79897 9.17704L2.67052 6.49467C2.73746 6.28866 2.66413 6.06298 2.48889 5.93565L0.207125 4.27786C-0.184731 3.99316 0.0166557 3.37335 0.501017 3.37335H3.32143C3.53804 3.37335 3.73002 3.23387 3.79696 3.02786L4.66851 0.345484Z" fill="currentColor" /></svg>';
                                            $rating_val = $rating ? (int)$rating : 0;
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ( $i <= $rating_val ) {
                                                    echo '<span class="star filled">' . $star_svg . '</span>';
                                                } else {
                                                    echo '<span class="star empty">' . $star_svg . '</span>';
                                                }
                                            }
                                        ?>
                                    </div>
                                </header>
                                <div class="testimonial-card__text">
                                    <?php the_content(); ?>
                                </div>
                            </article>
                        </div>
                    <?php } wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php } ?>
   

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