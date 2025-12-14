<?php
/**
 * The template for displaying 404 pages (not found)
 */

$title = get_field( '404_title', 'option' );
$subtitle = get_field( '404_subtitle', 'option' );
$background = get_field( '404_background', 'option' );

get_header();
?>

	<main id="primary" class="site-main">
		<section class="error-404 not-found">
			<?php if ( $background ) { ?>
				<img src="<?php echo esc_url($background); ?>" alt="404 Background" class="not-found__background" loading="lazy">
			<?php } ?>

			<div class="not-found__content">
				<?php if ( $title ) { ?>
					<h1 class="not-found__title">
						<?php echo esc_html( $title ); ?>
						<svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M53.5 29C53.5 23 53 12.5 53 2.5M40 38L14 17M35.5 53C33.9 53 12.8333 53 2.5 53" stroke="#2967F0" stroke-width="5" stroke-linecap="round" />
						</svg>
					</h1>
				<?php } ?>

				<?php if ( $subtitle ) { ?>
					<div class="not-found__subtitle"><?php echo esc_html( $subtitle ); ?></div>
				<?php } ?>

				<a href="<?php echo home_url(); ?>" class="not-found__link">
					Go to main page
				</a>
			</div>
		</section>
	</main>

<?php
wp_footer(); 
?>
</body>
</html>
