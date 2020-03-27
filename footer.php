<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tarsasnavigator_s
 */

?>

	<footer id="colophon" class="site-footer">
		<?php get_sidebar('footer'); ?>
		<div class="site-info">
			<?php echo ( esc_html(get_theme_mod('tarsasnavigator_s_footer_text')) == '' ) ? ('&copy; '.date('Y').' '.get_bloginfo('name').__('. All Rights Reserved. ','tarsasnavigator_s')) : esc_html( get_theme_mod('tarsasnavigator_s_footer_text') ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
