<?php
/**
 *
 */
class Table_Poster extends Omeka_Db_Table
{
    const POSTERS_PER_PAGE = 10;

    public function findByUserId($userId)
    {
        $select = $this->getSelect()->where('user_id = ?', $userId);
        return $this->fetchObjects($select);
    }
    
   }
