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

class CpanelControllerComment_answer extends JController
{
    //Get only one checked CommentAnswer and show it
    /*function edit() {
         $cids = JRequest::getVar('cid', '', 'post', 'array');
         if(count($cids) == 1) {
             $model =& $this->getModel('comment_answers');
             $view =& $this->getView('comment_answer', 'html');
             $id = JRequest::getVar('cid');

             if(is_array($id)) $id = $id[0];

             $results = $model->getCommentAnswer($id);
             $view->assignRef('results', $results);
             $view->display();
         } else {
               $this->setRedirect('index.php?option=com_ablog&act=comment_answers');
           }
    }*/
    //Update the showed and changed CommentAnswer
    function save() {
        $model =& $this->getModel('comment_answers');
        $model->updateCommentAnswer();
        $this->setRedirect('index.php?option=com_ablog&act=comment_answers');
    }
}
?>
