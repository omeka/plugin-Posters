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

    public function init()
    {
       $this->_helper->db->setDefaultModelName('Poster');
       $this->_currentUser = current_user();
    }
    public function indexAction()
    {
        $this->_helper->redirector('browse','index');
    }
    
    public function browseAction() {

        parent::browseAction();
    }
    public function deleteAction()
    {   
        $poster = $this->getRequest()->getParams();
        //var_dump($poster); exit;
        $posterOb = $this->_helper->db->findBy($poster, 'Poster');
    
        return parent::deleteAction();
        //echo "Index Controller, Delete Action"; exit;
    }
    
}
