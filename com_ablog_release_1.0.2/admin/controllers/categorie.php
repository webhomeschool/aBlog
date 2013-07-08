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

class CpanelControllerCategorie extends JController
{
    //Get and set Data for CategorieView
    function display() {
	$model =& $this->getModel('blog_categories');
        $view =& $this->getView('categorie', 'html');
        $view->setModel($model);
        $view->display();
    }
    //Save FormData if exists
    function save() {
      $model =& $this->getModel('blog_categories');
      $data = JRequest::get('post');
      //storeCategorie if the input field is not empty
     
      if($data['name'] != '') {     
          if(!$model->storeCategorie()) {
              $this->setError('storeCategorie() failed');
          }
      }     
      $this->setRedirect('index.php?option=com_ablog&act=blog_categories');
    }
    //Invoke the Categorie View
 
    
    function saveEdit() {
             $model =& $this->getModel('blog_categories');
           
            //Get the $data from the form    
          
             $data = JRequest::get('post');
            //Get the $data from the Request
            
            //updateKategorie() if the input field is not empty
            if($data['name'] != '') {
               
                if(!$model->updateKategorie()) {
                    $this->setError('updateKategorie() failed');
                }
            }
            $this->setRedirect('index.php?option=com_ablog&act=blog_categories');
    }
    
    function cancel() {
        $this->setRedirect('index.php?option=com_ablog&act=blog_categories');
    }
}
?>