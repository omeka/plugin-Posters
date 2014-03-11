<?php
/**
 *
 */
class Table_PosterItems extends Omeka_Db_Table
{
	public function findByUserId($userId)
	{
		$select = $this->getSelect()
			->joinInner(
				array('posters' => $this->getDb()->Posters), 
				'posters.id = posters_items.poster_id',
				array()
				)
		->where('poster.user_id = ?', $userId);

		return $this->fetchObjects($select);
	}
}
