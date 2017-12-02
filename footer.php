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

	<footer id="colophon" class="site-footer max-width lightText">
		<div class="footer-top">
			<?php wp_nav_menu( array(
			'theme_location' => 'footer-top',
			'depth'         => 1
			) );?>
			<a class="logo" href="https://ocean.org" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/logo-oceanwise.svg"></a>
		</div>
		<div class="footer-bottom">
			<?php wp_nav_menu( array(
				'theme_location' => 'footer-bottom',
				'depth'         => 1
			) );?>
			<div class="copyright"><a href="https://ocean.org" target="_blank">&copy;<?php echo date('Y');?> Ocean&nbsp&nbsp;Wise</a></div>
			<ul class="social-icons">
				<li><a href="https://www.facebook.com/vanaqua" target="_blank" class="socicon-facebook"></a></li>
				<li><a href="https://twitter.com/vanaqua" target="_blank" class="socicon-twitter"></a></li>
				<li><a href="https://instagram.com/vanaqua" target="_blank" class="socicon-instagram"></a></li>
				<li><a href="https://www.youtube.com/user/VancouverAquarium" target="_blank" class="socicon-youtube"></a></li>
				<li><a href="https://snapchat.com/add/vanaqua" target="_blank" class="socicon-snapchat"></a></li>
			</ul>
		</div>
	</footer><!-- #colophon -->

	<div id="map-wrap">
		<?php echo do_shortcode('[PTMap]');?>
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
