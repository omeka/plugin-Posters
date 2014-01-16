<?php
/**
 * Poster Builder 
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * Poster index controller class
 *
 * @package Posters
 */
class Posters_IndexController extends Omeka_Controller_AbstractActionController
{
    const UNTITLED_POSTER = 'Untitled';

    public function init()
    {
       $this->_helper->db->setDefaultModelName('Poster');
       $this->_currentUser = Zend_Registry::get('bootstrap')->getResource('CurrentUser');
    }
    public function indexAction()
    {
        $this->_helper->redirector('browse','index');
    }
    
    public function browseAction() {
        //clear the new poster id for discard
        unset($_SESSION['new_poster_id']);
        $db = $this->_helper->db->getDb();
        $requestParams = $this->getRequest()->getParams();
        $requestParams['page'] = '1';
        
        //Make sure we're on the first page if 'page' isn't set.
        $requestParams['page'] = (int)$requestParams['page'] or $requestParams['page'] = 1;

        $posters = $db->getTable('Poster');//->findBy($requestParams);
        //var_dump($posters); 
        $posterCount = $this->_helper->db->getTable('Poster')->count($requestParams);
        $posterPerPage = 10;//Table_Poster::POSTER_PER_PAGE;
        
        /*$this->view->posters = $posters;
        $this->view->posterCount = $posterCount;
        $this->view->posterPerPage = 10;
        $this->view->page = $requestParams['page'];*/

        $this->view->assign(compact('posters','posterCount','posterPerPage','requestParams'));
    }
    
    public function editAction() {
       //get the poster object
        $poster = $this->_helper->db->findById(null, 'Poster');
       
        //retrieve public items 
        $items = "list of public items";
        $this->view->assign(compact('poster','items'));
    }
    public function addAction() {
         
    }
    public function newAction(){

        $poster = new Poster();
        $poster->title = self::UNTITLED_POSTER;
        $poster->user_id = 1;//$this->_currentUser->id;
        $poster->description = '';
        $poster->date_created = date('Y-m-d H:i:s', time());
        $poster->save();
        
        //Set the new poster id for discard
        $_SESSION['new_poster_id'] = $poster->id;
         

        return $this->_helper->redirector->gotoRoute(
            array(
                'module' => 'posters',
                'action' => 'edit',
                'id'     => $poster->id
            ),
            'default'
        );

    }
    public function saveAction()
    {
        // clear the new poster id for didscard
        unset($_SESSION['new_poster_id']);
        $poster = $this->_helper->db->findById(null, 'Poster');

        $params = $this->getRequest()->getParams();
        $poster->title = !empty($params['title']) ? $params['title'] : self::UNTITLED_POSTER;
        $poster->description = $params['description'];
        $poster->updateItems($params);
        $poster->save();

        //$this->flashSuccess("\"$poster->title\" was successfully saved.");

        /*if(is_admin_theme()) {*/
            $this->_helper->redirector->gotoRoute(
                array(
                    'module' => 'posters',
                    'action' => 'browse'
                ),
                'default'
            );
        /*} else {
            $this->_helper->redirector->gotoRoute(array(), $_SERVER['HTTP_REFERER']);
        }*/
    }
}
