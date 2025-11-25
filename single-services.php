<?php
/*
Template Name: Template Single Service
Template Post Type: page
*/
get_header(); 

$GLOBALS['accent_bg_light'] = '#F9FBFF';
$GLOBALS['accent_font'] = '#0F38B4';

?>

<main>
    <section class="single-service">
        <div class="container">
            <?php while ( have_posts() ) {
                the_post(); ?>
                    <h1 class="single-service__title">
                        <?php the_title(); ?>

                        <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.3661 36.7327C22.5245 36.7327 29.8017 36.3895 36.7324 36.3895M12.1285 27.468L26.6829 9.62484M1.73242 24.3797C1.73242 23.2817 1.73242 8.82418 1.73242 1.73268" stroke="#2967F0" stroke-width="3.46535" stroke-linecap="round" />
                        </svg>
                    </h1>
                    <div class="single-service__wrapper">
                        <div class="single-service__content">
                            <?php if ( have_rows( 'service_items' ) ) { 
                                while ( have_rows( 'service_items' ) ) {
                                    the_row();
                                    
                                    $single_title = get_sub_field( 'single_title' );
                                    $single_content = get_sub_field( 'single_content' );
                                    $item_id = sanitize_title( $single_title ); ?>
                                                                        
                                    <div class="accordion">
                                        <details class="accordion__details" name="accordion" id="<?php echo esc_attr( $item_id ); ?>">
                                            <summary class="accordion__summary">
                                                <span class="accordion__title" role="term" aria-details="acc-faq">
                                                    <?php echo esc_html( $single_title ); ?>
                                                </span>
                                                <svg class="accordion__icon" width="23" height="14" viewBox="0 0 23 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.468285 2.73139C-0.156554 2.10655 -0.156554 1.09349 0.468285 0.468651C1.09312 -0.156188 2.10619 -0.156189 2.73103 0.46865L11.4683 9.20591L20.2055 0.468651C20.8304 -0.156188 21.8434 -0.156187 22.4683 0.468651C23.0931 1.09349 23.0931 2.10655 22.4683 2.73139L11.4683 13.7314L0.468285 2.73139Z" fill="#0F0F10" />
                                                </svg>
                                            </summary>
                                        </details>
                                        <div class="accordion__content" id="acc-faq" role="definition">
                                            <div class="accordion__content-body">
                                                <?php echo wp_kses_post( $single_content ); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <aside>
                            <div class="single-aside">
                                <h3 class="single-aside__title">Our services</h3>
                                <?php
                                    $current_post = get_the_ID();

                                    $aside_query = new WP_Query( array(
                                    'post_type' => 'services',
                                    'posts_per_page' => -1,
                                    'post_status' => 'publish',
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC',
                                )); 

                                if ( $aside_query->have_posts() ) { ?>
                                    <ul class="single-aside__list">
                                        <?php while ( $aside_query->have_posts() ) {
                                            $aside_query->the_post(); 
                                            
                                            $post_in_loop = get_the_ID();
                                            $active_item = ( $post_in_loop === $current_post ) ? 'is_active' : '';
                                            ?>
                                            <li class="single-aside__item <?php echo $active_item; ?>">
                                                <a class="single-aside__link" href="<?php the_permalink(); ?>">
                                                    <?php if ( has_post_thumbnail() ) { ?>
                                                        <div class="single-aside__thumbnail">
                                                            <?php the_post_thumbnail(); ?> 
                                                        </div>
                                                    <?php } ?>

                                                    <?php the_title(); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>  
                            </div>

                            <div class="default-card">
                                <?php 
                                    $single_card_question = get_field( 'single_card_question', 'option' );
                                    $single_card_link = get_field( 'single_card_link', 'option' );
                                    $single_card_background = get_field( 'single_card_background', 'option' );
                                ?>
                                <?php if ( $single_card_background ) { ?>
                                    <img src="<?php echo esc_url( $single_card_background ); ?>" alt="card background" class="default-card__background" loading="lazy">
                                <?php } ?>

                                <div class="default-card__content">
                                    <?php if ( $single_card_question ) { ?>
                                        <h4 class="default-card__title"><?php echo esc_html( $single_card_question ); ?></h4>
                                    <?php } ?>

                                    <?php if ( $single_card_link ) { ?>
                                        <a href="<?php echo esc_url( $single_card_link['url'] ); ?>" class="default-card__link">
                                            <?php echo esc_html( $single_card_link['title'] ); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </aside>
                    </div>
            <?php } ?>
        </div>
    </section>

    <!-- section Book a call -->
    <?php get_template_part( 'template-parts/section', 'book-a-call'); ?>

</main>

<?php get_footer(); ?>