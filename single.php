<?php
/**
 * The template for displaying single post
 *
 */

get_header();
?>

<main>
	<section class="single-blog">
		<div class="container">
			<div class="breadcrumbs">
				<a href="<?php echo home_url(); ?>" class="breadcrumbs__link">Main Page</a>
				<span class="breadcrumbs__sep">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.99925 13.2801L5.65258 8.93339C5.13924 8.42005 5.13924 7.58006 5.65258 7.06672L9.99925 2.72005" stroke="#292D32" stroke-width="1.33333" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
					</svg>		
				</span>
				<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="breadcrumbs__link">Blog</a>
				<span class="breadcrumbs__sep breadcrumbs__sep-last">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.99925 13.2801L5.65258 8.93339C5.13924 8.42005 5.13924 7.58006 5.65258 7.06672L9.99925 2.72005" stroke="#292D32" stroke-width="1.33333" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
					</svg>		
				</span>
				<span class="breadcrumbs__current"><?php single_post_title(); ?></span>
			</div>

			<?php while ( have_posts() ) { the_post(); 
				$post_data = get_content_with_toc( get_the_content() );
				$modified_content = $post_data['content'];
				$toc_html = $post_data['toc']; ?>

				<header class="single-blog__header">
					<h1 class="single-blog__title">
						<?php the_title(); ?>
					</h1>

					<div class="single-blog__meta">
						<time datetime="<?php echo get_the_date('c'); ?>">
							<?php echo get_the_date('M j, Y'); ?>
						</time>
					</div>

					<?php if ( has_post_thumbnail() ) { ?>
						<div class="single-blog__thumbnail">
							<?php the_post_thumbnail('full'); ?>
						</div>
					<?php } ?>
				</header>

				<div class="single-blog__wrapper">
					<div class="single-blog__content">
						<?php echo apply_filters( 'the_content', $modified_content ); ?>
					</div>

					<div class="single-blog__sidebar">
						<div class="toc">
							<?php if ( $toc_html ) { 
								echo $toc_html;
							} ?>
						</div>
					</div>
				</div>
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
