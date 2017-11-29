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

$contaminants = $wpdb->get_results("SELECT * FROM wp_contaminants ORDER BY name;");
$nav_contaminants = $wpdb->get_results("
SELECT *
FROM
	wp_contaminants WHERE
	(parent_id IS NULL AND aggregate IS NULL) OR
	(is_group=1 AND aggregate=1) OR
	parent_id = 38
ORDER BY name;"
);


$arrNav = [];
$arrContaminantsAssoc = [];

if ($contaminant){
	$values = PollutionTracker::getContaminantValues(array('contaminant_id'=>$contaminant_id));
	//echo "<pre>" . print_r($values,true) . "</pre>";
	$max_sediment = 0;
	$max_mussels = 0;
	foreach($values as $value){
		if ($value->sediment_value > $max_sediment) $max_sediment = $value->sediment_value;
		if ($value->mussels_value > $max_mussels) $max_mussels = $value->mussels_value;
	}

}




get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();
			?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header max-width">
			<a href="/contaminants" class="showLeftNav arrowLeft">View all contaminants</a>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">

			<table class="histogram">

			<?php

			//echo $nav_html;
			if ($values){
				foreach($values as $site){
					$sediment_percent = ($max_sediment)?($site->sediment_value / $max_sediment * 100):0;
					$mussels_percent = ($max_mussels)?($site->mussels_value / $max_mussels * 100):0;
					echo "<tr><td class='sediment'><div class='bar' style='max-width:{$sediment_percent}%;'><div class='value'>{$site->sediment_value}</div></div></td><td class='name'><a class='border' href='#Map|{$site->site_id}'>{$site->name}</a></td><td class='mussels'><div class='bar' style='max-width:{$mussels_percent}%;'><div class='value'>{$site->mussels_value}</div></div></td></tr>";
				}
			}
			the_content();?>

			</table>

		<?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->

		<div id="left-nav">
			<div class="close">&times;</div>
			<h2>Contaminants</h2>
			<ul>
			<?php
			$walker = new PTWalker();
			echo $walker->walk($nav_contaminants,3);
			?>
			</ul>
		</div>

	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();