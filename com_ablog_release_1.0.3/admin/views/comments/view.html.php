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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');


class CpanelViewComments extends JView {
    
    protected $canDo;

    function display($tpl = null) {
        
        $this->canDo = ablogHelper::getActions();
       
        JHTML::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');
        JToolBarHelper::title('ablog', 'blog');   
        
        ablogHelper::addSubmenu('comments');
        $model = $this->getModel('comments');
        $results = $model->getCommentsTeaser();
        $this->assignRef('results',$results);
        
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        
        $this->addToolBar();
        
        parent::display();
    }

       //This Function only shows the Select Parameter each is shown only once
       function getSelectFieldsValues($field_data) {
           
       
       $model = $this->getModel('comments');
       $results = $model->getDataForView($field_data);
   
      
       foreach($results as $list) {
           $result = null;
           if($field_data == 'post_id') {
               $result_list[] = $list->post_id;
           }
           if($field_data == 'created_date') {
               $result_list[] = $list->created_date;
           }
           if($field_data == 'creator') {
               $result_list[] = $list->creator;               
           }
            if($field_data == 'comment_id') {
               $result_list[] = $list->comment_id;
           }
       }
       return $result_list;
    }
    
     function addToolBar() {
        
         JToolBarHelper::title('ablog', 'blog');
        
        if ($this->canDo->get('core.edit')) {
            JToolBarHelper::editList('comments.edit', 'JTOOLBAR_EDIT', true);
        }
        
        if($this->canDo->get('core.edit.state')) {
            JToolBarHelper::publish('comments.publish', 'JTOOLBAR_PUBLISH', true);
            JToolBarHelper::unpublish('comments.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        }
        
        if($this->canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'comments.remove', 'JTOOLBAR_DELETE');
        }
    }
    
    function selectedFieldValue($type) {
        if($type) {
            $app = JFactory::getApplication();
            $field = $app->getUserStateFromRequest($option. 'filter_'.$type, 'filter_' . $type);
            return $field;
        }
        
    }
}
