<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LandingPadTheme
 */


$link_terms = get_field( 'footer_terms_of_service_link', 'option' );
$link_privacy = get_field( 'footer_privacy_policy_link', 'option' );

$url_terms = $link_terms ?: '#';
$url_privacy = $link_privacy ?: '#'; ?>

	<footer id="colophon" class="site-footer footer">
		<div class="footer__container container">
			<div class="footer__copyright">
				<p><a href="<?php echo esc_url( $url_terms ); ?>">Terms of Service</a>
				 	and 
				 	<a href="<?php echo esc_url( $url_privacy ); ?>">Privacy Policy</a>
				</p>
			</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
