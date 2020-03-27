<?php
/*
 * The Footer Widget Area
 * @package plum
 */
if ( is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') ) : ?>
		 	<?php
				if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-1'); ?>
					</div>
				<?php endif;

				if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="footer-column">
						<?php dynamic_sidebar( 'footer-2'); ?>
					</div>
				<?php endif;

				if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="footer-column"> <?php
						dynamic_sidebar( 'footer-3'); ?>
					</div>
				<?php endif;

				?>
<?php endif; ?>
