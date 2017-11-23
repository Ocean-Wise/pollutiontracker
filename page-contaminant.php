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
$arrNav = [];
$arrContaminantsAssoc = [];
foreach($contaminants as $item){
	/*$posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'contaminant_id' AND  meta_value = {$item->id} LIMIT 1", ARRAY_A);
	if (count($posts) && $posts[0]['post_id']){
		$post_id = $posts[0]['post_id'];
		$slug = get_post_field( 'post_name', $post_id );
		$item->slug = $slug;
	}*/
	//$arrContaminantsAssoc[$item['id']]=$item;
};

/*
// Put contaminants in to heirarchy for nav
$arrNav = get_nav_children(null, $arrContaminantsAssoc);
function get_nav_children($parent, $arr_items){
	$arr_return = [];
	foreach($arr_items as $item) {
		if ($item['parent_id']==$parent) {
			$children = get_nav_children($item['id'], $arr_items);
			$item['items'] = $children;
			$arr_return[] = $item;
		}
	}
	return $arr_return;
}
*/


if ($contaminant){
	$sediment_values = PollutionTracker::getContaminantValues(array('contaminant_id'=>$contaminant_id, 'source_id'=>1));
	$mussels_values = PollutionTracker::getContaminantValues(array('contaminant_id'=>$contaminant_id, 'source_id'=>2));
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

			$walker = new PTWalker();
			echo $walker->walk($contaminants, 3);

?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php

			echo $nav_html;

			if ($sediment_values){
				foreach($sediment_values as $site){
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