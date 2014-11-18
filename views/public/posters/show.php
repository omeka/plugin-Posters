<?php

$pageTitle = 'Poster: &quot;' . html_escape($poster->title) . '&quot;';
$pageLayout = get_option('poster_show_option');
$defaultType = get_option('poster_default_file_type');
echo queue_css_file('jquery.bxslider');
echo queue_css_file('poster');
echo queue_js_file('jquery.bxslider');
echo head(array('title'=>$pageTitle));

?>

<h1><?php echo $pageTitle; ?></h1>
<div id="poster">
    <div id="poster-info">
    <?php echo $poster->description; ?>
    </div>

    <div class="<?php echo $pageLayout . ' ' . $defaultType; ?>">
    <?php //set_items_for_loop($poster->Items); ?>
    <?php if ($pageLayout == 'carousel'): ?>
    <ul class="poster-items">
    <?php endif; ?>
    <?php foreach($poster->Items as $posterItem): ?>
    <?php $hasFiles = metadata($posterItem, 'has thumbnail'); ?>
    <?php if ($pageLayout == 'carousel'): ?>
    <li <?php if ($hasFiles) { echo 'class="has-image"'; } ?>>
    <?php else: ?>
    <div class="poster-item">
    <?php endif; ?>
        <?php if($hasFiles): ?>
            <?php 
                foreach($posterItem->Files as $itemFile) {
                    if($itemFile->hasThumbnail()){
                        echo link_to_item(
                            item_image(
                                $defaultType,
                                array(
                                    'title' => metadata($posterItem, 
                                    array(
                                        'Dublin Core', 
                                        'Title'
                                    )
                                ), 
                                'alt' => strip_formatting($posterItem->caption)), 
                                0, 
                                $posterItem
                            ), 
                            array(), 
                            'show', 
                            $posterItem
                        );
                        if(!get_option('poster_show_option')){
                            echo "<div class='bx-caption'>"
                                . $posterItem->caption
                                . "</div>";
                        }
                        break;
                    }
                }
            ?>
            <?php if ($pageLayout == 'static'): ?>
                <div class="poster-item">
                    <h3><?php echo link_to_item(metadata($posterItem, array('Dublin Core', 'Title')), array(), 'show', $posterItem); ?></h3>
                    <div class='grid-caption'>
                        <?php echo $posterItem->caption; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if ($pageLayout == 'carousel'): ?>
                <div class="text-only">
                    <h3><?php echo link_to_item(metadata($posterItem, array('Dublin Core', 'Title')), array(), 'show', $posterItem); ?></h3>
                    <div class='bx-caption'>
                        <?php echo $posterItem->caption; ?>
                    </div>
                </div>
            <?php else: ?>
                <h3><?php echo link_to_item(metadata($posterItem, array('Dublin Core', 'Title')), array(), 'show', $posterItem); ?></h3>
                <div class='grid-caption'>
                    <?php echo $posterItem->caption; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php if ($pageLayout == 'carousel'): ?>
    </li>
    <?php else: ?>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($pageLayout == 'carousel'): ?>
     </ul>
     <?php endif; ?>
    </div>

    <?php 
     $disclaimer = get_option('poster_disclaimer');
     if (!empty($disclaimer)): 
    ?>
    <div id="poster-disclaimer">
        <h2 id="poster-disclaimer-title">Disclaimer</h2>
        <?php echo html_escape($disclaimer); ?>
    </div>
    <?php endif; ?>
    <?php if ($this->currentUser): ?>
        <div class="edit-link">
            <a href="<?php echo html_escape(url(array('action' => 'edit','id' => $poster->id), get_option('poster_page_path'))); ?>" class="edit-poster-link">Edit</a>
            <a href="<?php echo html_escape(url(array('action'=>'print','id' => $poster->id), get_option('poster_page_path'))); ?>" class="print" media="print" >Print</a>
        </div>
    <?php endif; ?>
</div>
<script type="text/javascript"> 
    var n = jQuery('.poster-items li').length;
    var showOption = '<?php echo ($showOption = get_option('poster_show_option')) ? $showOption : 'carousel'; ?>';
    var fileSize = '<?php echo ($fileSize = get_option('poster_default_file_type')) ? $fileSize : 'fullsize'; ?>';
    if (n > 0 && showOption == 'carousel') {
       jQuery('.poster-items').bxSlider({
          auto: false,
          adaptiveHeight: true,
          mode: 'fade',
          captions: true,
          pager: n > 1,
       });
       <?php if ($defaultType == 'thumbnail'): ?>
       jQuery(window).load(function() {
           jQuery('.thumbnail .bx-caption').each(function() {
              var imageWidth = jQuery(this).prev().find('img').prop('width');
              var caption = jQuery(this);
              caption.css('left', imageWidth);
           });
        });
       <?php endif; ?>
    } else {
        jQuery('.poster-items').addClass('poster-items-grid');
        jQuery('.bx-caption').addClass('bx-caption-grid');
    }
</script>
<?php echo foot(); ?>
