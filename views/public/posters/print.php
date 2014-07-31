<?php $pageTitle = 'Poster: &quot;' . html_escape($poster->title). '&quot;'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $pageTitle; ?></title>
    <link href="<?php echo css_src('print'); ?>" media="all" rel="stylesheet" type="text/css" />
</head>
</body>
<div id="primary">
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
        <li>
            <?php
            if(metadata($posterItem, 'has files')){
                foreach($posterItem->Files as $itemFile) {
                    if($itemFile->hasThumbnail()){
                        echo "<div class='item-file'>"
                            .link_to_item(file_image(get_option('poster_default_file_type_print'), array(),  $itemFile), array('class' =>'item-thumbnail'), 'show', $posterItem)
                            ."</div>";
                    }
                }
            } 
            ?>
            <h2>Title: "<?php echo metadata($posterItem, array('Dublin Core', 'Title')); ?>"</h2>
            <h3>Url: <?php echo 'http://'.$_SERVER['HTTP_HOST'].html_escape(url("items/show/{$posterItem->id}")); ?>"</h3>
            <div class='poster-item-annotation'>
                <?php echo $posterItem->caption; ?>
            </div>
        </li>
        <?php endforeach; ?>
         </ul>
        <div class="pagebreak"></div>
        <?php 
         $disclaimer = get_option('poster_disclaimer');
         if (!empty($disclaimer)): 
        ?>
        <div id="poster-disclaimer">
            <h3 id="poster-disclaimer-title">Disclaimer:</h3>
            <p id="disclaimer-text">
            <?php echo html_escape($disclaimer); ?>
            </p>
        </div>
        <?php endif; ?>
           </div>
</div> <!-- end primary div -->
</body>
</html>
