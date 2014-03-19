<?php

function poster_icon_html($item)
{
    $html = file_image('square_thumbnail', array(), $item);

    if(!$html) {
        $html = "<img alt='no image available' src='".html_escape(img('noThumbnail.png'))."'/>";
    }
    return $html;
}
