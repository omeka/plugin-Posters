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
}
