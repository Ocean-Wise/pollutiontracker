<?php
/*
Template Name: Contaminant Page
*/


$values = get_post_custom( $post->ID );
$contaminant_id = isset( $values['contaminant_id'] ) ? array_pop($values['contaminant_id']) : '';
$contaminant = null;
$child_contaminants = null;
$values = null;

if ($contaminant_id){
	$sql = $wpdb->prepare("SELECT * FROM wp_contaminants WHERE id=%d", $contaminant_id);
	$contaminant = $wpdb->get_row($sql);
}

// If aggregate contaminant, get children
/*if ($contaminant->aggregate){
    $child_contaminants = PollutionTracker::getChildContaminantValues(array('contaminant_id'=>$contaminant->id));
}*/

$contaminants = $wpdb->get_results("SELECT * FROM wp_contaminants ORDER BY name;");

$arrNav = [];
$arrContaminantsAssoc = [];

if ($contaminant){
    $max_sediment = 0;
    $max_mussels = 0;
    $off_scale_factor = 1.5;
    $sediment_off_scale = false;
    $mussels_off_scale = false;
    
	$values = PollutionTracker::getContaminantValues(array('contaminant_id'=>$contaminant_id));

    $values_sorted_sediment = $values;
    usort($values_sorted_sediment, function($a, $b){
        return $a->sediment_value < $b->sediment_value;
    });

    $values_sorted_mussels = $values;
    usort($values_sorted_mussels, function($a, $b){
        return $a->mussels_value < $b->mussels_value;
    });

    // Figure out if the largest value should go off scale
    
    
    // If the largest item a lot larger than the second item, show the first one off scale
    if ($values_sorted_sediment[0]->sediment_value > $values_sorted_sediment[1]->sediment_value*$off_scale_factor && $values_sorted_sediment[1]->sediment_value>0){
        $sediment_off_scale = true;
        $max_sediment = $values_sorted_sediment[1]->sediment_value;
        $values_sorted_sediment[0]->sediment_off_scale = true;
    }else{
        $max_sediment = $values_sorted_sediment[0]->sediment_value;
    }

    if ($values_sorted_mussels[0]->mussels_value > $values_sorted_mussels[1]->mussels_value*$off_scale_factor && $values_sorted_mussels[1]->mussels_value > 0){
        $mussels_off_scale = true;
        $max_mussels = $values_sorted_mussels[1]->mussels_value;
        $values_sorted_mussels[0]->mussels_off_scale = true;
    }else{
        $max_mussels = $values_sorted_mussels[0]->mussels_value;
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
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
            <?php if ($contaminant){?>

            <div class="histogram-wrap">

                <table class="histogram">
                    <tr><th>
                            <h3>Sediment</h3>
                            <div class="units"><span class="extra"><?php echo $contaminant->name;?> (</span><?php echo $contaminant->units_sediment;?> dry&nbsp;weight<span class="extra">)</span></div>
                        </th>
                        <th></th>
                        <th>
                            <h3>Mussels</h3>
                            <div class="units"><span class="extra"><?php echo $contaminant->name;?> (</span><?php echo $contaminant->units_mussels;?> wet&nbsp;weight<span class="extra">)</span></div>
                        </th>
                    </tr>
                    <tr class="gridrow">
                        <th>
                            <div class="gridlines sediment">
                                <div class="guideline sediment-quality tooltip" data-tooltipster='{"distance":10}' data-label="Guideline" data-value="<?php echo $contaminant->sediment_quality_guideline;?>" title="Sediment Quality Guideline (<?php echo $contaminant->sediment_quality_guideline . ' ' . $contaminant->units_sediment;?>)">
                                </div>
                                <div class="guideline effects-level tooltip" data-tooltipster='{"distance":10}' data-label="Probable Effects Level" data-value="<?php echo $contaminant->probable_effects_level;?>" title="Probable Effects Level (<?php echo $contaminant->probable_effects_level . ' ' . $contaminant->units_sediment;?>)"></div>
                            </div>
                        </th>
                        <th></th>
                        <th>
                            <div class="gridlines mussels">
                                <div class="guideline tissue-residue-guideline" data-tooltipster='{"distance":10}' data-label="Guideline" data-value="<?php echo $contaminant->tissue_residue_guideline;?>" title="Tissue Residue Guideline (<?php echo $contaminant->tissue_residue_guideline . ' ' . $contaminant->units_mussels;?>)"></div>
                            </div>
                        </th>
                    </tr>
                <?php

                if ($values){
                    foreach($values as $site){
                        $sediment_percent = ($max_sediment)?($site->sediment_value / $max_sediment * 100):0;
                        $mussels_percent = ($max_mussels)?($site->mussels_value / $max_mussels * 100):0;
                        $extra_label_sediment = (($site->sediment_value===null)?"<div class='extra-label'>Not analyzed</div>":(($site->sediment_not_detected)?"<div class='extra-label'>Not detected</div>":''));
                        $extra_label_mussels = (($site->mussels_value===null)?"<div class='extra-label'>Not analyzed</div>":(($site->mussels_not_detected)?"<div class='extra-label'>Not detected</div>":''));

                        // We're doing a join, so if there's no id for a contaminant/site, it wasn't sampled
                        if ($site->sediment_id===null) $extra_label_sediment = "<div class='extra-label'>Not sampled</div>";
                        if ($site->mussels_id===null) $extra_label_mussels = "<div class='extra-label'>Not sampled</div>";


                        echo "<tr>";
                        echo "<td class='sediment" . (($contaminant->aggregate && $site->sediment_value)?" tooltip-ajax":" tooltip") . (($site->sediment_value!==null)?' bg-bar':'') . (($site->sediment_off_scale)?' off-scale':'') . "' data-site-id='{$site->id}' data-source-id='1' data-contaminant-id='{$contaminant->id}' title='" . (($extra_label_sediment)?strip_tags($extra_label_sediment):$site->sediment_value . (($site->sediment_value==0)?' ':'') . $contaminant->units_sediment) . "'>" . $extra_label_sediment;
                        echo "<div class='bar' data-value='{$site->sediment_value}'>";
                        echo "<div class='bar-fill'><div class='value light'>" . (($extra_label_sediment)?'':$site->sediment_value . ' ' . $contaminant->units_sediment) . "</div></div><div class='value dark'>" . (($extra_label_sediment)?'':$site->sediment_value  . ' ' . $contaminant->units_sediment) . "</div>";
                        echo "</div>";

                        echo "</td>";

                        echo "<td class='name'><a class='border' href='#Map|{$site->site_id}'>{$site->name}</a></td>";

                        //echo "<td class='mussels" . (($site->mussels_value!==null)?' bg-bar':'') . "'>" . $extra_label_mussels;
                        echo "<td class='mussels" . (($contaminant->aggregate && $site->mussels_value)?" tooltip-ajax":" tooltip") . (($site->mussels_value!==null)?' bg-bar':'') . (($site->mussels_off_scale)?' off-scale':'') . "' data-site-id='{$site->id}' data-source-id='2' data-contaminant-id='{$contaminant->id}' title='" . (($extra_label_mussels)?strip_tags($extra_label_mussels):$site->mussels_value . (($site->mussels_value==0)?' ':'') . $contaminant->units_mussels) . "'>" . $extra_label_mussels;

                        echo "<div class='bar' data-value='{$site->mussels_value}'>";
                        echo "<div class='bar-fill'><div class='value light'>" . (($extra_label_mussels)?'':$site->mussels_value  . ' ' . $contaminant->units_mussels) . "</div></div><div class='value dark'>" . (($extra_label_mussels)?'':$site->mussels_value . ' ' . $contaminant->units_mussels) . "</div>";
                        echo "</div></td>";
                        echo "</tr>";
                    }
                } ?>

                </table>

            </div>
            <?php } ?>

            <?php the_content();?>


            <script type="text/javascript">
                var sedimentGrid = new GridLines({graph: jQuery('.histogram-wrap .gridlines.sediment'), min: 0, max: <?php echo $max_sediment;?>, direction:-1});
                var musselsGrid = new GridLines({graph: jQuery('.histogram-wrap .gridlines.mussels'), min: 0, max: <?php echo $max_mussels;?>, direction: 1, });

                $('.histogram .sediment .bar').each(function(item){
                    $(this).css({maxWidth: (sedimentGrid.gridMax?($(this).attr('data-value') / sedimentGrid.gridMax * 100):0) + '%'});
                });

                $('.histogram .mussels .bar').each(function(item){
                    $(this).css({maxWidth: (musselsGrid.gridMax?($(this).attr('data-value') / musselsGrid.gridMax * 100):0) + '%'});
                });

                $('.histogram .sediment .guideline').each(function(){
                    if ($(this).attr('data-value')) {
                        var percent = (sedimentGrid.gridMax ? ($(this).attr('data-value') / sedimentGrid.gridMax * 100) : 0);
                        if (percent > 100){
                            percent = 100;
                            $(this).hide();
                        }
                        $(this).css({left: (100 - percent) + '%'});
                    }
                });

                $('.histogram .mussels .guideline').each(function(){
                    if ($(this).attr('data-value')) {
                        var percent = (musselsGrid.gridMax ? ($(this).attr('data-value') / musselsGrid.gridMax * 100) : 0);
                        if (percent > 100){
                            percent = 100;
                            $(this).hide();
                        }
                        $(this).css({left: percent + '%'});
                    }
                });
            </script>

		<?php
		endwhile; // End of the loop.
		?>

        </div></article>
		</main><!-- #main -->

		<div id="left-nav">
			<div class="close">&times;</div>
			<?php /*<h3>Contaminants</h3>*/?>
			<ul>
			<?php
            wp_nav_menu( array( 'theme_location' => 'contaminant-left-nav' ) );
			?>
			</ul>
		</div>

	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();