<?php
/**
 * Reusable Template: Team Section
 */


$team_title = get_field( 'team_section_title', 'option' );
$team_subtitle = get_field( 'team_section_subtitle', 'option' );

$bg_color     = get_field('team_bg_color') ?: '#DBEBFF';
$accent_color = get_field('team_accent_color') ?: '#0F38B4';

$team_query = new WP_Query( array(
    'post_type' => 'team',
    'posts_per_page' => 4,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

if ( $team_query->have_posts() ) { ?>

    <section class="team" style="--team-bg: <?php echo esc_attr( $bg_color ); ?>; --team-accent: <?php echo esc_attr( $accent_color ); ?>;">
        <div class="team__wrapper">
            <div class="container">
                <div class="team__header">
                    <?php if ( $team_title ) { ?>
                        <h2 class="team__title"><?php echo esc_html( $team_title ); ?></h2>
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
                                        <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php the_title_attribute(); ?>" class="team-card__image">
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