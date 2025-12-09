<?php
/**
 * Template part for post card
 *
 */

?>

<a href="<?php the_permalink(); ?>" class="blog-list__link">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card' ) ?>>
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="blog-card__image-wrapper">
                <?php the_post_thumbnail( 'full', ['class' => 'blog-card__img'] ); ?>
            </div>
        <?php } ?>

        <div class="blog-card__content">

            <h3 class="blog-card__title">
                <?php the_title(); ?>
            </h3>

            <div class="blog-card__meta">
                <time class="blog-card__date" datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date('M j, Y'); ?>
                </time>
            </div>

            <div class="blog-card__excerpt">
                <?php the_excerpt(); ?>
            </div>
        </div>
    </article>
</a>