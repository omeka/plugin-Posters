<div class="poster-spot">

	<div class="poster-item-header">
    	<h3 class="poster-item-title"><?php echo metadata($posterItem , array('Dublin Core', 'Title')); ?></h3>
    	<div class="poster-controls">
            <a href="#" class="poster-move-top poster-control">
                <img src="<?php echo html_escape(img('arrow_up_up.png')); ?>"  title="Move to the top" alt="Move to the top"/></a>
            <a href="#" class="poster-move-up poster-control">
                <img src="<?php echo html_escape(img('arrow_up.png')); ?>"  title="Move up" alt="Move up"/></a>
            <a href="#" class="poster-move-down poster-control">
                <img src="<?php echo html_escape(img('arrow_down.png')); ?>"  title="Move down" alt="Move down"/></a>
            <a href="#" class="poster-move-bottom poster-control">
                <img src="<?php echo html_escape(img('arrow_down_down.png')); ?>"  title="Move to the bottom" alt="Move to the bottom" /></a>
        	<a href="#" class="poster-delete poster-control">
        		    <img src="<?php echo html_escape(img('delete.gif')); ?>" title="Remove this item" alt="Remove this item"/>Delete</a>
        </div>    	
    </div>
    
    <div class="poster-item-thumbnail">
        <?php if (metadata($posterItem, 'has files')){
             foreach ($posterItem->Files as $displayFile){
                 if($displayFile->hasThumbnail()){
                    echo "<div class='item-file'>"
                        .file_image('square_thumbnail', array(), $displayFile)
                        .'</div>';
                    break;
                 }
             }
            } ?>
    </div>

    <div class="poster-item-annotation">
        <h4>Caption:</h4>
        <?php $caption = (poster_get_caption_for_item($posterItem, $posterItem->posterId))? poster_get_caption_for_item($posterItem, $posterItem->posterId)[0]:$posterItem;?>
        <?php echo get_view()->formTextarea('annotation-' . $caption->ordernum, $caption->caption,
            array(  'id'=>'poster-form poster-annotation-' . mt_rand(0, 999999999),
                   'rows'=>'6',
                    'cols'=>'10')); ?>
    </div>

    <input type="hidden" name="itemID-<?php echo html_escape($caption->ordernum); ?>" value="<?php echo html_escape($posterItem->id); ?>" class="hidden-item-id" />
    
</div>
<script type="text/javascript" charset="utf-8">
    Omeka.Poster.wysiwyg();
</script>

