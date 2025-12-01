<?php
/**
 * The template for displaying single apartments
 */

get_header();

$gallery  = get_field('apartment_gallery');
$map = get_field('apartment_map');

$tags = get_the_terms( get_the_ID(), 'apartment_tag' );

?>

<main>

    <?php while ( have_posts() ) {
        the_post(); ?>

        <section class="apartment-single">
            <div class="container">
                <div class="apartment-single__wrapper">
                    <div class="apartment-single__gallery">
                        <div class="apartment-slider" id="js-apartment-slider">
                            <?php if ( has_post_thumbnail() ) {
                                $featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                            ?>
                                <a href="<?php echo esc_url( $featured_img_url ); ?>" class="js-lightbox-trigger">
                                    <div class="apartment-slider__item">
                                        <?php
                                        the_post_thumbnail('full'); 
                                        ?>
                                    </div>
                                </a>
                            <?php } ?>

                            <?php if ( $gallery ) { ?>
                                <?php foreach( $gallery as $image ) { ?>
                                    <a href="<?php echo esc_url( $image['url'] ); ?>" class="js-lightbox-trigger">

                                    <div class="apartment-slider__item">
                                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="slider-img" loading="lazy">
                                    </div>
                                </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="apartment-single__info">
                        <h1 class="apartment-single__title">
                            <?php the_title(); ?>
                        </h1>

                        <div class="apartment-single__content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                
                <?php if ( $tags ) { ?>
                    <div class="apartment-single__features">
                        <h3 class="apartment-single__tags-title">Apartment Features:</h3>
                        <div class="apartment-single__tags-list">
                            <?php foreach ( $tags as $tag ) { ?>
                                <span class="apartment-single__tag">
                                    <?php echo esc_html( $tag->name ); ?>
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ( $map ) { ?>
                    <div class="apartment-single__map-wrapper">
                        <div class="acf-map" data-zoom="15">
                            <div class="marker" 
                                data-lat="<?php echo esc_attr($map['lat']); ?>" 
                                data-lng="<?php echo esc_attr($map['lng']); ?>"
                                data-title="<?php the_title_attribute(); ?>"
                                data-address="<?php echo esc_attr($map['address']); ?>">
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    <?php } ?>

    <!-- section Contacts -->
    <?php get_template_part( 'template-parts/section', 'contacts' ); ?>

    <!-- section Book a call -->
    <?php get_template_part( 'template-parts/section', 'book-a-call'); ?>


    <div id="simple-lightbox" class="lightbox">
        <div class="lightbox__content">
            <span class="lightbox__close"> 
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.3904 0.390382C16.1403 0.140421 15.8013 0 15.4477 0C15.0942 0 14.7551 0.140421 14.505 0.390382L8.39038 6.50505L2.27572 0.390382C2.02568 0.140421 1.6866 0 1.33305 0C0.979496 0 0.640419 0.140421 0.390382 0.390382C0.140421 0.640419 0 0.979496 0 1.33305C0 1.6866 0.140421 2.02568 0.390382 2.27572L6.50505 8.39038L0.390382 14.505C0.140421 14.7551 0 15.0942 0 15.4477C0 15.8013 0.140421 16.1403 0.390382 16.3904C0.640419 16.6403 0.979496 16.7808 1.33305 16.7808C1.6866 16.7808 2.02568 16.6403 2.27572 16.3904L8.39038 10.2757L14.505 16.3904C14.7551 16.6403 15.0942 16.7808 15.4477 16.7808C15.8013 16.7808 16.1403 16.6403 16.3904 16.3904C16.6403 16.1403 16.7808 15.8013 16.7808 15.4477C16.7808 15.0942 16.6403 14.7551 16.3904 14.505L10.2757 8.39038L16.3904 2.27572C16.6403 2.02568 16.7808 1.6866 16.7808 1.33305C16.7808 0.979496 16.6403 0.640419 16.3904 0.390382Z" fill="white" />
                </svg>
            </span>

            <img class="lightbox__image" src="" alt="">
            <div class="lightbox__caption"></div>

            <div class="lightbox__counter"></div>

            <a class="lightbox__prev">
                <button type="button" class="slick-prev slick-arrow">
                    <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.17005 18.2811C9.29503 18.1571 9.39422 18.0096 9.46191 17.8472C9.5296 17.6847 9.56445 17.5104 9.56445 17.3344C9.56445 17.1584 9.5296 16.9841 9.46191 16.8216C9.39422 16.6591 9.29503 16.5117 9.17005 16.3877L3.06339 10.2811C2.93842 10.1571 2.83923 10.0096 2.77153 9.84716C2.70384 9.68468 2.66899 9.51041 2.66899 9.33439C2.66899 9.15837 2.70384 8.9841 2.77153 8.82162C2.83923 8.65914 2.93842 8.51167 3.06339 8.38772L9.17006 2.28106C9.29503 2.15711 9.39422 2.00964 9.46191 1.84716C9.5296 1.68468 9.56445 1.51041 9.56445 1.33439C9.56445 1.15837 9.5296 0.9841 9.46191 0.821621C9.39422 0.659142 9.29503 0.511674 9.17006 0.387723C8.92024 0.139389 8.5823 -4.29311e-08 8.23006 -5.83284e-08C7.87781 -7.37256e-08 7.53987 0.139389 7.29006 0.387723L1.17006 6.50772C0.420986 7.25773 0.000240918 8.27439 0.000240872 9.33439C0.000240825 10.3944 0.420986 11.4111 1.17005 12.1611L7.29005 18.2811C7.53987 18.5294 7.87781 18.6688 8.23005 18.6688C8.5823 18.6688 8.92024 18.5294 9.17005 18.2811Z" fill="white" />
                    </svg>
                </button>
            </a>
            <a class="lightbox__next">
                <button type="button" class="slick-next slick-arrow">
                    <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.394398 0.387737C0.269427 0.511688 0.170234 0.659155 0.102542 0.821632C0.0348509 0.984112 2.0881e-07 1.15839 2.06711e-07 1.3344C2.04612e-07 1.51042 0.0348509 1.68469 0.102542 1.84717C0.170234 2.00965 0.269427 2.15712 0.394398 2.28107L6.50106 8.38774C6.62604 8.51169 6.72523 8.65915 6.79292 8.82163C6.86061 8.98411 6.89546 9.15839 6.89546 9.3344C6.89546 9.51042 6.86061 9.68469 6.79292 9.84717C6.72523 10.0097 6.62604 10.1571 6.50106 10.2811L0.394398 16.3877C0.269427 16.5117 0.170234 16.6592 0.102542 16.8216C0.0348507 16.9841 1.80114e-08 17.1584 1.59124e-08 17.3344C1.38135e-08 17.5104 0.0348507 17.6847 0.102542 17.8472C0.170234 18.0097 0.269427 18.1571 0.394398 18.2811C0.644214 18.5294 0.98215 18.6688 1.3344 18.6688C1.68665 18.6688 2.02458 18.5294 2.2744 18.2811L8.3944 12.1611C9.14347 11.4111 9.56421 10.3944 9.56421 9.3344C9.56421 8.2744 9.14347 7.25774 8.3944 6.50774L2.2744 0.387737C2.02458 0.139402 1.68665 1.14642e-05 1.3344 1.146e-05C0.98215 1.14558e-05 0.644215 0.139402 0.394398 0.387737Z" fill="white" />
                    </svg>
                </button>
            </a>
        </div>
    </div>
</main>

<?php
get_footer();