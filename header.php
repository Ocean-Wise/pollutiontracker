<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pollution_Tracker
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header<?php if (is_front_page()) echo" lightText";?>">
        <div class="hello-bar">
            <div class="hello-bar-text">
                Explore <span class="hello-bar-hide-mobile">more at </span><a href="https://ocean.org" target="_blank">ocean.org</a>
            </div>

            <div class="hello-bar-logo-toggle">
                <img class="hello-bar-logo" src="<?php echo get_template_directory_uri();?>/images/hello-bar-ow-logo.svg">
                <a id="hello-bar-toggle" class="hello-bar-btn hello-bar-btn-open">
                    <img class="hello-bar-icon" src="<?php echo get_template_directory_uri();?>/images/hello-bar-chevron.svg">
                </a>
            </div>

            <div class="hello-bar-menu hello-bar-menu-closed">
                <ul class="hello-bar-nav">
                    <li><a href="https://ocean.org" target="_blank">Ocean Wise</a></li>
                    <li><a href="http://vanaqua.org" target="_blank">Vancouver Aquarium</a></li>
                    <li><a href="https://ocean.org/seafood" target="_blank">Sustainable Seafood</a></li>
                    <li><a href="https://shorelinecleanup.ca" target="_blank">Shoreline Cleanup</a></li>
                    <li><a href="https://ocean.org/research" target="_blank">Ocean Research</a></li>
                    <li><a href="https://ocean.org/education" target="_blank">Ocean Education</a></li>
                    <li><a href="http://wildwhales.org" target="_blank">Whale Sightings</a></li>
                    <li><a href="https://aquablog.ca/" target="_blank">Aquablog</a></li>
                    <li><a href="https://ocean.org/donate" target="_blank">Donate</a></li>
                </ul>
            </div>
        </div>
        <div class="max-width">
            <div class="top-bar ">
                <div class="logo"><a href="/"><span class="bold">Pollution</span>Tracker</a></div>

                <nav id="site-navigation" class="main-navigation">
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                            'depth'         => 1
                        ) );
                    ?>
                </nav><!-- #site-navigation -->
                <nav id="site-navigation-mobile" class="main-navigation-mobile">
                    <div class="burger"><div class="line"></div><div class="line"></div><div class="line"></div></div>
                    <div class="nav-panel">
                        <a class="close" href="#">&times;</a>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'depth'         => 1
                    ) );
                    ?>
                    </div>
                </nav><!-- #site-navigation -->
            </div>
        </div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
