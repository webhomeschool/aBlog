<?php
/**
 * Webhomeschool Component
 * @package ABlog
 * @subpackage Controllers
 *
 * @copyright (C) 2013 Webhomeschool. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.webhomeschool.de
 **/
 
defined('_JEXEC') or die ('Restricted access');
jimport('joomla.application.component.controller');

class CpanelControllerBlog_categories extends JController
{
    // Get and set the Data for the BlogKategories View
    function display($cachable = false, $urlparams = false) {

	$model = $this->getModel('blog_categories');
        $view = $this->getView('blog_categories', 'html');
        $results = $model->getKategories();
        $view->assignRef('results', $results);
        $view->display();      
    }

    function publish() {
        $model = $this->getModel('blog_categories');
        $model->publish();
        $this->setRedirect('index.php?option=com_ablog&act=blog_categories');
    }
    
    function unpublish() {
        $model = $this->getModel('blog_categories');
        $model->unpublish();
        $this->setRedirect('index.php?option=com_ablog&act=blog_categories');
    }
    
    function remove() {        
        $cids = JRequest::getVar('cid', '', 'post', 'array');
        $model = $this->getModel('blog_categories');
        if(!$model->checkAssignmentToPost($cids)) {
            $model->delete($cids);
            $this->setRedirect('index.php?option=com_ablog&act=blog_categories'); 
        } else {
            $view = $this->getView('blog_categories', 'html');
            $results = $model->getKategories();
            $view->assignRef('results', $results);
            $view->display();
            JError::raiseNotice(100, 'Please delete the assignment with the Post before deleting this Kategorie');
        }
    }
    //Get the CategorieView with SaveButton for storeKategorie()
    function add() {
        $view = $this->getView('categorie', 'html');       
        $view->display();        
    }
    //Get the CategorieView with SaveButton for updateKategorie() 
    function edit() {
             $model = $this->getModel('blog_categories');
             $view = $this->getView('categorie', 'html');
          
             $id = JRequest::getVar('cid');
             //Get the checked id Array
             if(is_array($id)) $id = $id[0];
             //Take the Kategorie with the checked id
             $results = $model->getKategorie($id);
           
             $view->assignRef('results', $results);
             $view->display();
             //Save the Edit Categorie in the Database
    }
}
?>