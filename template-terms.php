<?php
/**
 * Template Name: Terms & Privacy
 */

get_header(); ?>

<main>
    <sectoin class="legal">
        <div class="container">
            <h1 class="legal__title">
                <?php the_title(); ?>
            </h1>

            <div class="legal__content">
                <?php while ( have_posts() ) { the_post();
                    the_content();
                } ?>
            </div>
        </div>
    </sectoin>
</main>

<?php get_footer(); ?>