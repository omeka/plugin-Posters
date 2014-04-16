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
            <p><?php echo __('There are no items to choose from.'); ?></p>
    <?php endif; ?>
    <?php foreach(loop('items') as $item): ?>
        <?php echo posterItemListing($item); ?>
    <?php endforeach; ?>
</div>

<?php 
function posterItemListing($item){
    $html = '<div class="item-listing" data-item-id="'. $item->id .'">';
    if (metadata($item, 'has files')) {
        foreach($item->Files as $displayFile) {
            if($displayFile->hasThumbnail()) {
                $html .= '<div class="item-file">'
                      . file_image('square_thumbnail', array(), $displayFile)
                      . '</div>';
                break;
            }
        }
    }

    $html .= '<h4 class="title">'
          . metadata($item, array('Dublin Core', 'Title'))
          . '</h4>'
          . '<button type="button" class="select-item" >' . __('Select Item').'</button>'
          . '</div>';

    return $html;
}
?>
