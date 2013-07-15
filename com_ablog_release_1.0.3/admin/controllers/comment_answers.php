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

class CpanelControllerComment_answers extends JController
{
    //Get CommentAnswers View and set the Model
    function display($cachable = false, $urlparams = false) {
        $view = $this->getView('comment_answers', 'html');
        $model = $this->getModel('comment_answers');       
        $view->setModel($model);
        $view->display();
    }
    
    function publish() {
        $model = $this->getModel('comment_answers');
        $model->publish();
        $this->setRedirect('index.php?option=com_ablog&act=comment_answers');
    }
    
    function unpublish() {
        $model = $this->getModel('comment_answers');
        $model->unpublish();
        $this->setRedirect('index.php?option=com_ablog&act=comment_answers');
    }
    
    function remove() {
        $model = $this->getModel('comment_answers');
        $cids = JRequest::getVar('cid', '', 'post', 'array');
        $model->delete($cids);        
        $this->setRedirect('index.php?option=com_ablog&act=comment_answers');
    }
    
    //Get the CommentAnswers that belong to the defined post and comment
    function getCommentAnswers($post_id, $comment_id) {
        $db = JFactory::getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = 'SELECT * FROM' . $table . 
                 'WHERE post_id=' . $post_id . ' AND comment_id=' . $comment_id;
        $db->setQuery($query);
        return $db->loadObjectList();
    }
    
    function edit() {     
            
                 $model = $this->getModel('comment_answers');
                 $view = $this->getView('comment_answer', 'html');
                 $id = JRequest::getVar('cid');
                 if(is_array($id)) $id = $id[0];
                 $results = $model->getCommentAnswer($id);
                 $view->assignRef('results', $results);
                 $view->display();
    }
}
?>
