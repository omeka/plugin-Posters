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
    }
    public function indexAction()
    {
        $this->_helper->redirector('browse','index');
    }
    
    public function browseAction() {
        parent::browseAction();
    }
    
    public function editAction() {
        parent::editAction();
    }
    public function addAction() {
        parent::addAction();
        $this->view->form = $this->_getForm(array('poster' => 'poster-form'));
    }
    
    protected function _getForm($options)
    {
        $form = new Omeka_Form($options);
        $form->addElement('text','comment-title',
            array(
                'label' => __("Title of Poster"),
                'class' => 'textinput',
                'required' => true
            )
        );
        
        $form->addElement('textarea', 'comment',
            array(
                'label' => __('Comment'),
                'class' => 'textinput'
            )
         );
        
        
        return $form;
    }
}
