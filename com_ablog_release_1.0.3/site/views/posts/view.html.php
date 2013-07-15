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
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
jimport('joomla.application.menu');
jimport('joomla.document.html.html');
jimport('joomla.html.pagination');
jimport('joomla.html.parameter');

class ABlogViewPosts extends JView {

    function display($tpl = null) {
     
        JHtml::stylesheet('posts.css','./components/com_ablog/assets/css/');
     
        $model_posts = $this->getModel('posts');
       
        $id = JRequest::getCmd('id');
        
        if(!empty($id)) {
            
            $this->getPostsDataForMenu($model_posts, $id);
        
        }
        
       parent::display($tpl);
    }

    function getPagination(){
  
        $model = $this->getModel('posts');
       
        $total = $model->getTotalPosts();
        $limitstarter = JRequest::getCmd('limitstart', 1);
        $limitend = 3;
        $pagination = new JPagination($total, $limitstarter, $limitend);
        return $pagination->getPagesLinks();
     }

     function getPostsData($model_posts) {
            $results = $model_posts->getAllPosts();
            return $results;
     }

     function getPostsDataForMenu($model_posts, $id) {
         if(!empty($id)) {
             $results = $model_posts->getAllIdPosts($id);
             return $results;
         }
     }

     function createMenuLink($id, $categories) {         
          if($id == $categories->id) {
              $class_active = 'active_menu';
              return '<a id="active_menu" href="' . JRoute::_('index.php?option=com_ablog&amp;view=posts&amp;kategorie=' . $categories->name . '&amp;id=' . $categories->id) . '">' . $categories->name . '</a>';
          } else {
               $class_active = '';
               return '<a ' . $class_active . ' href="' . JRoute::_('index.php?option=com_ablog&amp;view=posts&amp;kategorie=' . $categories->name . '&amp;id=' . $categories->id) . '">' . $categories->name . '</a>';
            }          
     }
}
?>