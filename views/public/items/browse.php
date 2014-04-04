<?php
echo pagination_links(
    array(
        'url' => url(
            array(
                'controller' => 'Item', 
                'action' => 'items', 
                'page' => null
            )
        )
    )
);
?>

<div id="item-list">
    <?php echo item_search_filters(); ?>
    <?php if (!has_loop_records('items')): ?>
        <p><?php echo __('There are no items to choose from. Please refine your search'); ?></p>
    <?php endif; ?>
    <?php foreach (loop('items') as $item): ?>
        <div class="item-listing" data-item-id="<?php echo $item->id; ?>">
            <?php if (metadata($item, 'has files')): ?>
                <?php foreach ($item->Files as $iFile): ?>
                    <?php if ($iFile->hasThumbnail()): ?>
                        <div class="item-file">
                            <?php echo file_image('square_thumbnail', array(), $iFile); ?>
                        </div>
                    <?php break; endif; ?>
                <?php endforeach; ?>
            <?php endif; ?> 
            <h4 class="title">
                <?php echo metadata($item, array('Dublin Core', 'Title')); ?>
            </h4>
            <button type="button" class="select-item">Select Item</button>
        </div>
    <?php endforeach; ?>
</div>
