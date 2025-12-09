<?php
/*
* Blog page
*/

get_header(); ?>

<main>
    <section class="blog-header">
        <div class="container">
            <div class="breadcrumbs">
                <a href="<?php echo home_url(); ?>" class="breadcrumbs__link">Main Page</a>
                <span class="breadcrumbs__sep">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.99925 13.2801L5.65258 8.93339C5.13924 8.42005 5.13924 7.58006 5.65258 7.06672L9.99925 2.72005" stroke="#292D32" stroke-width="1.33333" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
					</svg>                </span>
                <span class="breadcrumbs__current"><?php single_post_title(); ?></span>
            </div>

            <h1 class="blog_title">
                <?php single_post_title(); ?>
                <svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.9059 24.5C15.7574 24.5 20.7475 24.2745 25.5 24.2745M8.62871 18.4118L18.6089 6.68628M1.5 16.3824C1.5 15.6608 1.5 6.16013 1.5 1.5" stroke="#2967F0" stroke-width="3" stroke-linecap="round" />
                </svg>
            </h1>
        </div>
    </section>
   
    <section class="blog-list">
        <div class="container">
            <?php if ( have_posts() ) { ?> 
                <div class="blog-list__wrapper">
                    <?php while ( have_posts() ) { the_post(); 
                       
                       get_template_part( 'template-parts/content', 'blog-card' );

                    } ?>
                </div>

                <?php global $wp_query;
                if (  $wp_query->max_num_pages > 1 ) { ?>
                    <div class="load-more-container load_more_blog">
                        <button id="load-more-btn" class="load_more_button" data-current-page="1" data-max-pages="<?php echo $wp_query->max_num_pages; ?>">
                            Load More
                        </button>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <!-- section Contacts -->
    <?php get_template_part( 'template-parts/section', 'contacts'); ?>

    <!-- section Book a call -->
    <?php get_template_part( 'template-parts/section', 'book-a-call'); ?>

    <!-- section Instagram -->
    <?php get_template_part( 'template-parts/section', 'instagram'); ?>

</main>

<?php get_footer(); ?>