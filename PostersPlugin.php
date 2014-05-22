<?php

/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package Posters
 */
require_once dirname(__FILE__) . '/helpers/PosterFunctions.php';
define('POSTER_PAGE_PATH','posters');
define('POSTER_PAGE_TITLE', 'Posters');
define('POSTER_DISCLAIMER','This page contains user generated content and does not necessarily reflect the opinions of this website. For more information please refer to our terms of service and conditions. If you would like to report the content of this as objectionable, Please contact us.');
define('POSTER_HELP','<h2>Your Posters</h2>'
    .'<p>To build a poster, you may use any public item in in this website and add a caption,</p>'
                    .'<p>Click the button that says &quot;New Poster&quot;. Assign a title to your poster,'
                    .'add a short description. Cick the tab that says &quot;Add an Item&quot; and select any item that you wish to include in your poster.'
    .'Continue adding items and captions.</p><p> Be sure to save your poster. You may return to edit your poster at any time.</p> <p>You may print this poster, or share it by email.</p>');
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
        'define_acl',
        'define_routes',
    );
    // Define Filters
    protected $_filters = array(
        'admin_navigation_main',
        'guest_user_widgets',
        'public_navigation_main',  
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

        $db->query("CREATE TABLE IF NOT EXISTS {$db->prefix}poster_items (
                `id` BIGINT UNSIGNED NOT NULL auto_increment PRIMARY KEY,
                `caption` TEXT,
                `poster_id` BIGINT UNSIGNED NOT NULL,
                `item_id` BIGINT UNSIGNED NOT NULL,
                `ordernum` INT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;"
        );
        
        set_option('poster_page_path', POSTER_PAGE_PATH);
        set_option('poster_page_title',POSTER_PAGE_TITLE);
        set_option('poster_disclaimer', POSTER_DISCLAIMER);
        set_option('poster_help', POSTER_HELP);
    } 

    /**
     * Uninstall this plugin
     */
    public function hookUninstall()
    {
        $db = get_db();
        $db->query("DROP TABLE IF EXISTS `{$db->prefix}posters`");
        $db->query("DROP TABLE IF EXISTS `{$db->prefix}poster_items`"); 
        
        delete_option('poster_page_path');
        delete_option('poster_page_title');
        delete_option('poster_disclaimer');
        delete_option('poster_help');
    }

    public function hookConfig($args)
    {
        $post = $args['post'];
        set_option('poster_page_path', preg_replace('/\/+/','',$post['poster_page_path']));
        set_option('poster_page_title',$post['poster_page_title']);
        set_option('poster_disclaimer', $post['poster_disclaimer']);
        set_option('poster_help', $post['poster_help']);
    }
    public function hookConfigForm()
    {
        include 'forms/config_form.php';
       
    }
    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label'    => __('Posters'),
            'uri'      => url('posters'),
           // 'resource' => 'edit',
        );
        return $nav;
    }
    
    public function filterGuestUserWidgets($widgets)
    { 
        $bp = get_option('poster_page_path');
        $widget = array('label' => __('Posters'));
        $browse = url("{$bp}/browse");
        $create = url("{$bp}/new");
        $html = "<ul>"
              . "<li><a href='{$browse}'>".__("Browse Posters")."</a></li>"
              . "<li><a href='{$create}'>".__("New Poster")."</li>"            
              . "</ul>";
        $widget['content'] = $html;
        $widgets[] = $widget;
        return $widgets;
    }
    
    public function hookDefineAcl($args)
    {
        $acl = $args['acl'];
        
        $acl->addResource('Posters_Poster');
        $acl->allow(null, 'Posters_Poster', array('show','browse'));
        $acl->allow('guest', 'Posters_Poster', array('browse','show','edit', 'add', 'delete'), new Omeka_Acl_Assert_Ownership);
        $acl->allow('guest','Posters_Poster', array('browse','show'));
        
    }
    public function filterPublicNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Browse Posters'),
            'uri'   => url(array('action'=>'browse'),get_option('poster_page_path')),
            'visible' => true,
        );
        return $nav;
    }
    public function hookDefineRoutes($args)
    {
        if (is_admin_theme()) {
            return;
        }

       $bp = get_option('poster_page_path');
       $router = $args['router'];
       //browse
       $router->addRoute(
           $bp,
           new Zend_Controller_Router_Route(
               "$bp/:action/:id/*",
               array(
                   'module'     => 'posters',
                   'controller' => 'posters',
                   'action'     => 'index',
                   'id'         => '\d+'
               )));
       $router->addRoute(
            'items',
            new Zend_Controller_Router_Route(
                "$bp/items/browse",
                array(
                    'module'    => 'posters',
                    'controller' => 'items',
                    'action'     => 'browse'
                )
            )
       );

    }
}
