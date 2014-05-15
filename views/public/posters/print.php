<!DOCTYPE html>
<head>
<link href="<?php echo css_src('print'); ?>" media="all" rel="stylesheet" type="text/css" />
</head>
</body>
<div id="primary">
<?php $pageTitle = 'Poster: &quot;' . html_escape($poster->title). '&quot;'; ?>
    <h1><?php echo $pageTitle; ?></h1>
    <hr>
	<div id="poster">
        <div id="poster-info">
        <h2>Description:</h2>
		<?php echo $poster->description; ?>
		</div>

            <h2>Items:</h2>
        <ul class="poster-items">
        <?php foreach($poster->Items as $posterItem): ?>
<?php    echo "<li>";
echo "<h2>Title: ".metadata($posterItem, array('Dublin Core', 'Title'))."</h2>";
echo  '<h3>Url: http://'.$_SERVER['HTTP_HOST'].html_escape(url("items/show/{$posterItem->id}"))."</h3>";
            if(metadata($posterItem, 'has files')){
                foreach($posterItem->Files as $itemFile) {
                    if($itemFile->hasThumbnail()){
                        echo "<div class='item-file'>"
                            .link_to_item(file_image('square_thumbnail', array(),  $itemFile), array('class' =>'item-thumbnail'), 'show', $posterItem)
                            ."</div>";
                            //."<div class='poster-item-annotation'>"
                            //.$posterItem->annotation
                            //."</div>";
                        //break;
                    }
                }
                echo "<div class='poster-item-annotation'>"
                     .$posterItem->annotation
                     ."</div>";
            }
            echo "</li>"
?>
        <?php endforeach; ?>
         </ul>
        <div class="pagebreak"></div>
		<?php 
         $disclaimer = get_option('poster_disclaimer');
		 if (!empty($disclaimer)): 
		?>
		<div id="poster-disclaimer">
			<h2 id="poster-disclaimer-title">Disclaimer:</h2>
			<?php echo html_escape($disclaimer); ?>
		</div>
        <?php endif; ?>
       	</div>
</div> <!-- end primary div -->
</body>
<script> 
     window.print();
    window.history.back();         
 </script>


</html>
