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
    public $description = '';
    public $user_id;
    public $date_created;
    public $date_modified;

    protected $_related = array(
        'Items' => 'getItems', 
        'user' => 'getUser'
    );
    
    public function getItems()
    {
        return $this->getPosterItems($this->id);
    }

    public function getUser()
    {
        return $this->_helper->db->getTable('User')->find($this->user_id);
    }

    public function updateItems(&$params)
    { 
        if(is_numeric($params['itemCount'])) {
            $this->deletePosterItems();
            if($params['itemCount'] > 0) {
                foreach(range(1, $params['itemCount']) as $ordernum) {
                    $item = new PosterItems();
                    $item->caption = $params['annotation-' . $ordernum];
                    $item->poster_id = $this->id;
                    $item->item_id = $params['itemID-'. $ordernum];
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
        $poster_items = $db->getTable('PosterItems')
            ->fetchObjects("SELECT * FROM {$db->prefix}poster_items p WHERE p.poster_id = $this->id");

        foreach($poster_items as $poster_item) {
            $poster_item->delete();
        }
    }

    public function _delete()
    {
        $this->deletePosterItems();
    }
    public function getPosterItems($posterId)
    {
        if (is_numeric($posterId)){
            $db = get_db();
            $items = $db->getTable('Item')->fetchObjects(" select i.*, pi.caption, p.user_id
                FROM {$db->prefix}poster_items pi
                JOIN {$db->prefix}items i on i.id = pi.item_id
                JOIN {$db->prefix}posters p on pi.poster_id = p.id
                WHERE pi.poster_id = $posterId
                ORDER BY ordernum");

            return $items;
        }
    }
}
