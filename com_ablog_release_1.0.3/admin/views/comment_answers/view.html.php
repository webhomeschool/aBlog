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

class CpanelViewComment_Answers extends JView {
    
    protected $canDo;

    function display($cachable = false, $urlparams = false) {
        
        $this->canDo = ablogHelper::getActions();
        
        JHTML::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');
        
        JToolBarHelper::title('ablog', 'blog');
       
        ablogHelper::addSubmenu(JRequest::getCmd('act'));
        
        $model = $this->getModel('comment_answers'); 
        $results = $model->getCommentAnswersTeaser();
        $this->assignRef('results', $results);
        
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        
        $this->addToolBar();
        
	parent::display();		
    }
    //Put the column names into the getDataForView()
    function getSelectFieldsValues($field_data) {
        
       $model = $this->getModel('comment_answers');
       
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
           
           if($field_data == 'published') {
               $result_list[]= $list->published;
           }
       }
       
       //results are all the data from the selected column in the result_list array
       return $result_list;
    }
    
    function addToolBar(){
        
        if($this->canDo->get('core.edit')) {
            JToolBarHelper::editList('comment_answers.edit', 'JTOOLBAR_EDIT', true);
        }
        
        if($this->canDo->get('core.edit.state')) {
            JToolBarHelper::publish('comment_answers.publish','JTOOLBAR_PUBLISH', true );
            JToolBarHelper::unpublish('comment_answers.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        }
        
        if($this->canDo->get('core.delete')){
            JToolBarHelper::deleteList(); 
        } 
    }
    
    function getFieldsValueFromRequest($type) {
        $app = JFactory::getApplication();
        if($type != '')
        $result = $app->getUserStateFromRequest($option.'filter_'.$type, 'filter_'.$type);
        return $result;
    }
}