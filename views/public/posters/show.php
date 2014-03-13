<?php

$pageTitle = 'Poster: &quot;' . html_escape($poster->title) . '&quot;';
echo head(array('title'=>$pageTitle));

?>

<div id="primary">
    <h1><?php echo $pageTitle; ?></h1>

	<div id="poster">
		<div id="poster-info">
		<?php echo $poster->description; ?>
		</div>

		<?php //set_items_for_loop($poster->Items); ?>
		<?php //while ($item = loop_items()): ?>
		<div class="poster-item">
	        <h2><?php //echo link_to_item(); ?></h2>
			<?php //if (item_has_thumbnail()) echo link_to_item(item_thumbnail()); ?>
			<div class="poster-item-annotation">
		        <?php //echo $item->annotation; ?>
			</div>
		</div>
		<?php //endwhile; ?>

		<?php 
         $disclaimer = get_option('poster_disclaimer');
		 if (!empty($disclaimer)): 
		?>
		<div id="poster-disclaimer">
			<h2 id="poster-disclaimer-title">Disclaimer</h2>
			<?php echo html_escape($disclaimer); ?>
		</div>
		<?php endif; ?>
	</div>
</div> <!-- end primary div -->
<?php echo foot(); ?>
