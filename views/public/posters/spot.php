<?php $item = get_record('Item',$posterItem); ?>
<div class="poster-spot">

	<div class="poster-item-header">
    	<h3 class="poster--item-title"><?php echo metadata('Item', array('Dublin Core', 'Title')); ?></h3>
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
        <?php echo my_omeka_poster_icon_html(); ?>
    </div>

    <div class="poster-item-annotation">
        <h4>My Annotation:</h4>
        <?php echo $this->get_view()->formTextarea('annotation-' . $posterItem->ordernum, $posterItem->annotation,
            array(  'id'=>'poster-annotation-' . mt_rand(0, 999999999),
                    'rows'=>'6',
                    'cols'=>'10')); ?>
    </div>
    <?php if ($noteText): ?>
        <div class="poster-notes">
            <h4>My Notes</h4>
            <?php echo html_escape($noteText); ?>
        </div>
    <?php endif; ?>
    
    <input type="hidden" name="itemID-<?php echo html_escape($posterItem->ordernum); ?>" value="<?php echo html_escape($posterItem->id); ?>" class="poster-hidden-item-id" />
</div>
