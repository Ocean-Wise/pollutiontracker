<?php
/*
Template Name: Contaminant Page
*/


$values = get_post_custom( $post->ID );
$contaminant_id = isset( $values['contaminant_id'] ) ? array_pop($values['contaminant_id']) : '';
$contaminant = null;
$values = null;

if ($contaminant_id){
	$sql = $wpdb->prepare("SELECT * FROM wp_contaminants WHERE id=%d", $contaminant_id);
	$contaminant = $wpdb->get_row($sql);
}

if ($contaminant){
	$values = PollutionTracker::getContaminantValues(array('contaminant_id'=>$contaminant_id));
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			if ($values){
				foreach($values as $site){
					echo "<div>{$site->name}: {$site->value}</div>";
				}
			}
			the_content();

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();