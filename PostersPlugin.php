<?php

/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package Posters
 */

 /**
  * Posters plugin class
  *
  * @copyright Center for History and New Media, 2013
  * @package Posters
  */
class PostersPlugin extends Omeka_Plugin_AbstractPlugin //Omeka_Plugin_AbstractPlubin
{   
    // Define Hooks
    protected $_hooks = array(
        'install',
        'uninstall',
        'config',
        'config_form',
    );
    // Define Filters
    protected $_filters = array(
        'admin_navigation_main',
    );

    /**
     * Install this plugin.
     */
    public function hookInstall()
    {
        $db = get_db();
        $db->query("CREATE TABLE IF NOT EXISTS {$db->prefix}posters (
                `id` BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY, 
                `title` VARCHAR(255) NOT NULL,
                `description` TEXT,
                `user_id` BIGINT UNSIGNED NOT NULL,
                `date_created` TIMESTAMP NOT NULL default '0000-00-00 00:00:00',
                `date_modified` TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
            ) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );

        $db->query("CREATE TABLE IF NOT EXISTS {$db->prefix}posters_items (
                `id` BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY,
                `annotation` TEXT,
                `poster_id` BIGINT UNSIGNED NOT NULL,
                `item_id` BIGINT UNSIGNED NOT NULL,
                `ordernum` INT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;"
        );
    } 

    /**
     * Uninstall this plugin
     */
    public function hookUninstall()
    {
        $db = get_db();
        $db->query("DROP TABLE IF EXISTS `{P$db->prefix}posters`");
        $db->query("DROP TABLE IF EXISTS `{$db->prefix}posters_items`");        
    }

    public function hookConfig()
    {

    }
    public function hookConfigForm()
    {
        echo "<div='form'>admin config form</div>";
    }
    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label'    => __('Posters'),
            'uri'      => url('posters'),
            //'resource' => 'browse',
        );
        return $nav;
    }
}
