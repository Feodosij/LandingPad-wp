<?php
/**
 * Reusable Template: Team Section
 */

$team_title = get_field( 'team_section_title', 'option' );
$team_subtitle = get_field( 'team_section_subtitle', 'option' );

$team_query = new WP_Query( array(
    'post_type' => 'team',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

if ( $team_query->have_posts() ) { ?>

    <section class="team" id="team">
        <div class="team__wrapper">
            <div class="container">
                <div class="team__header">
                    <?php if ( $team_title ) { ?>
                        <h2 class="team__title">
                            <?php echo esc_html( $team_title ); ?>

                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M53.5 28.9857C53.5 22.9889 53 12.4946 53 2.5M40 37.9808L14 16.9922M35.5 52.9727C33.9 52.9727 12.8333 52.9727 2.5 52.9727" stroke="#0F38B4" stroke-width="5" stroke-linecap="round" />
                            </svg>
                        </h2>
                    <?php } ?>
                    
                    <?php if ( $team_subtitle ) { ?>
                        <div class="team__subtitle"><?php echo wp_kses_post( $team_subtitle ); ?></div>
                    <?php } ?>
                </div>

                <div class="team__grid">
                    <?php while ( $team_query->have_posts() ) { 
                        $team_query->the_post(); 

                        $member_job = get_field( 'job_position_company_name' );
                        $photo_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' ); ?>

                        <article class="team-card">
                            <div class="team-card__header">
                                <div class="team-card__image-wrapper">
                                    <?php if ( $photo_url ) { ?>
                                        <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php the_title_attribute(); ?>" class="team-card__image" loading="lazy">
                                    <?php } ?>
                                </div>

                                <div class="team-card__name">
                                    <?php the_title(); ?>
                                </div>

                                <?php if ( $member_job ) { ?>
                                    <div class="team-card__position"><?php echo esc_html( $member_job ); ?></div>
                                <?php } ?>
                            </div>

                            <div class="team-card__description"><?php the_content(); ?></div>
                        </article>
                    <?php } wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>