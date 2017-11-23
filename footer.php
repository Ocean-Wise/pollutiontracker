<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pollution_Tracker
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer max-width">
		<div class="footer-top">
			<?php wp_nav_menu( array(
			'theme_location' => 'footer-top',
			'depth'         => 1
			) );?>
			<img class="logo" src="<?php echo get_template_directory_uri();?>/images/logo-oceanwise.svg">
		</div>
		<div class="footer-bottom">
			<?php wp_nav_menu( array(
				'theme_location' => 'footer-bottom',
				'depth'         => 1
			) );?>
			<div class="copyright">&copy;<?php echo date('Y');?> Ocean&nbsp;Wise</div>
			<ul class="social-icons">
				<li><a href="#" class="socicon-facebook"></a></li>
				<li><a href="#" class="socicon-twitter"></a></li>
				<li><a href="#" class="socicon-instagram"></a></li>
				<li><a href="#" class="socicon-youtube"></a></li>
				<li><a href="#" class="socicon-snapchat"></a></li>
			</ul>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
