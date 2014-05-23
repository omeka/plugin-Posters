<?php

function poster_icon_html($item)
{
    $html = file_image('square_thumbnail', array(), $item);

    if(!$html) {
        $html = "<img alt='no image available' src='".html_escape(img('noThumbnail.png'))."'/>";
    }
    return $html;
}

function poster_get_caption_for_item($item, $posterId) 
{
  // return get_db()->getTable('PosterItems')->findBySql(array('item_id' => $item->id, 'poster_id' => $posterId)); 
    return get_db()->getTable('PosterItems')->findBySql('item_id = ? AND poster_id = ?', array($item->id, $posterId), true); 
}
