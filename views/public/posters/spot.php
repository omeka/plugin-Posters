<tr class="poster-spot">

    <td class="poster-item-header">
        <?php if (metadata($posterItem, 'has files')){
             foreach ($posterItem->Files as $displayFile){
                 if($displayFile->hasThumbnail()){
                    echo "<div class='image'>"
                        .file_image('square_thumbnail', array(), $displayFile)
                        .'</div>';
                    break;
                 }
             }
            } ?>
        <h3 class="poster-item-title"><?php echo metadata($posterItem , array('Dublin Core', 'Title')); ?></h3>
        <ul class="poster-actions">
            <li class="poster-move-top poster-control">
                <a href="#"><span class="screen-reader-text"><?php echo __('Move to top'); ?></span></a>
            </li>
            <li class="poster-move-up poster-control">
                <a href="#"><span class="screen-reader-text"><?php echo __('Move up'); ?></span></a>
            </li>
            <li class="poster-move-down poster-control">
                <a href="#"><span class="screen-reader-text"><?php echo __('Move down'); ?></span></a>
            </li>
            <li class="poster-move-bottom poster-control">
                <a href="#"><span class="screen-reader-text"><?php echo __('Move to bottom'); ?></span></a>
            </li>
            <li class="poster-delete poster-control">
                <a href="#"><span class="screen-reader-text"><?php echo __('Delete'); ?></span></a>
            </li>
        </ul>
    </td>
    
    <td class="poster-item-annotation">
        <?php $caption = (poster_get_caption_for_item($posterItem, $posterItem->posterId))? poster_get_caption_for_item($posterItem, $posterItem->posterId):$posterItem?>
        <?php echo get_view()->formTextarea('annotation-' . $caption->ordernum, $caption->caption,
            array(  'id'=>'poster-form poster-annotation-' . mt_rand(0, 999999999),
                   'rows'=>'6',
                    'cols'=>'10')); ?>
    </td>

    <input type="hidden" name="itemID-<?php echo html_escape($caption->ordernum); ?>" value="<?php echo html_escape($posterItem->id); ?>" class="hidden-item-id" />
    
</tr>