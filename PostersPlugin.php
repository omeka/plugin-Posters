<?php

/**
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Roy Rosenzweig Center for History and New Media, 2013-2015
 * @package Posters
 */
require_once dirname(__FILE__) . '/helpers/PosterFunctions.php';
define('POSTER_PAGE_PATH','posters');
define('POSTER_PAGE_TITLE', 'Posters');
define('POSTER_SHOW_OPTION', 'carousel');
define('POSTER_DEFAULT_FILE_TYPE', 'original');
define('POSTER_DEFAULT_FILE_TYPE_PRINT', 'original');
define('POSTER_DISCLAIMER','This page contains user generated content and does not necessarily reflect the opinions of this website. For more information please refer to our terms of service and conditions. If you would like to report the content of this as objectionable, Please contact us.');
define('POSTER_HELP','<h2>Your Posters</h2>'
    .'<p>To build a poster, you may use any public item in in this website and add a caption,</p>'
                    .'<p>Click the button that says &quot;New Poster&quot;. Assign a title to your poster,'
                    .'add a short description. Cick the tab that says &quot;Add an Item&quot; and select any item that you wish to include in your poster.'
    .'Continue adding items and captions.</p><p> Be sure to save your poster. You may return to edit your poster at any time.</p> <p>You may print this poster, or share it by email.</p>');
 /**
  * Posters plugin class
  *
  * @package Posters
  */
class PostersPlugin extends Omeka_Plugin_AbstractPlugin
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
        set_option('poster_default_file_type', POSTER_DEFAULT_FILE_TYPE);
        set_option('poster_default_file_type_print', POSTER_DEFAULT_FILE_TYPE_PRINT);
        set_option('poster_show_option', POSTER_SHOW_OPTION);
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
        delete_option('poster_default_file_type');
        delete_option('poster_show_option');
        delete_option('poster_default_file_type_print');
    }

    public function hookConfig($args)
    {
        $post = $args['post'];
        set_option('poster_page_path', preg_replace('/\/+/','',$post['poster_page_path']));
        set_option('poster_page_title',$post['poster_page_title']);
        set_option('poster_disclaimer', $post['poster_disclaimer']);
        
        if (get_option('html_purifier_is_enabled')) {
            $filter = new Omeka_Filter_HtmlPurifier;
            $helpText = $filter->filter($post['poster_help']);
        } else {
            $helpText = $post['poster_help'];
        }
        set_option('poster_help', $helpText);
        
        set_option('poster_default_file_type', $post['poster_default_file_type']);
        set_option('poster_default_file_type_print', $post['poster_default_file_type_print']);
        set_option('poster_show_option', $post['poster_show_option']);

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
        $bp = get_option('poster_page_path');
        $nav[] = array(
             'label' => __('Posters'),
             'uri'   => url($bp."/browse"),
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
            "$bp/:browse",
            array(
                'module'  => 'posters',
                'controller' => 'posters',
                'action'     => 'browse',
            )
          )
       );
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
