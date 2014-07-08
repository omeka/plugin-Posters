<?php

$pageTitle = 'Poster: &quot;' . html_escape($poster->title) . '&quot;';
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

    <?php //set_items_for_loop($poster->Items); ?>
    <ul class="poster-items">
    <?php foreach($poster->Items as $posterItem): ?>
    <li>
        <?php if(metadata($posterItem, 'has files')): ?>
            <?php 
                foreach($posterItem->Files as $itemFile) {
                    if($itemFile->hasThumbnail()){
                        echo link_to_item(
                            item_image(
                                get_option('poster_default_file_type'), 
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
        <?php else: ?>
            <div class="text-only">
                <h3 style="height: 9em;"><?php echo link_to_item(metadata($posterItem, array('Dublin Core', 'Title')), array(), 'show', $posterItem); ?></h3>
                <div class='bx-caption'>
                    <?php echo $posterItem->caption; ?>
                </div>
            </div>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
     </ul>

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
<?php echo "var showOption = ".get_option('poster_show_option').";"; ?>
<?php echo "var fileSize = '".get_option('poster_default_file_type')."';"; ?>
    if (n > 1 && showOption) {
       jQuery('.poster-items').bxSlider({
          auto: false,
          adaptiveHeight: true,
          mode: 'fade',
          captions: true
       });
       if(fileSize ==='thumbnail' || fileSize === 'square_thumbnail'){
           fitImage = jQuery('.bx-wrapper .bx-caption');
           fitImage.css('height','100%');
           fitImage.css('margin-left','203px');
           fitImage.css('width','82%');
       }
    } else {
        jQuery('.poster-items').addClass('poster-items-grid');
        jQuery('.bx-caption').addClass('bx-caption-grid');

     if( fileSize === 'original' || fileSize === 'fulsize') {
         jQuery('.poster-items').addClass('poster-items-max');
     } 
    
    }
</script>
<?php echo foot(); ?>
