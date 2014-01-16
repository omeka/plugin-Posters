<?php
/**
 * Posters
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * The Poster record class
 *
 * @package Posters
 */
class Poster extends Omeka_Record_AbstractRecord
{
    public $title;
    public $description;
    public $user_id;
    public $date_created;
    public $date_modified;

    public function updateItems(&$params)
    {
        if(is_numeric($params['itemCount'])) {
            $this->deletePosterItems();
            if($params['itemCount'] > 0) {
                foreach(range(1, $params['itemCount']) as $ordernum) {
                    $item = new PosterItem();
                    $item->annotation = $params['annotation-' . $ordernum];
                    $item->poster_id = $this->id;
                    $item->ordernum = $ordernum;
                    $item->save();
                }
            }
        }
    }

    public function deletePosterItems()
    {
        //delete entries from the poster_items table
        $db = get_db();
        $poster_items = $db->getTable('PosterItem')
            ->fetchObjects("SELECT * FROM {$db->prefix}posters_items p WHERE p.poster_id = $this->id");

        foreach($poster_items as $poster_item) {
            $poster_item->delete();
        }
    }

    public function _delete()
    {
        $this->deletePosterItems();
    }
}
