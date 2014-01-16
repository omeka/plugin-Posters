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
    
    public function findBy($params, $limit = null, $page = null)
    {
        $select = $this->getSelectForFindBy($params);

        $resultsPage = $params['page'];
        $select->limitPage($resultsPage, self::POSTERS_PER_PAGE);

        $select->order('id ASC');

        return $this->fetchObject($select); 
    }
}
