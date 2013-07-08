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

class CpanelControllerComment extends JController
{
    //Get the CommentView set the CommentsModel
    function display($cachable = false, $urlparams = false) {
        $view =& $this->getView('comments', 'html');
        $model =& $this->getModel('comments');
        $view->setModel($model);
        $view->display();
    }
    
    function publish() {
        $model =& $this->getModel('comments');
        $model->publish();
        $this->setRedirect('index.php?option=com_ablog&act=comments');
    }
    
    function unpublish() {
        $model =& $this->getModel('comments');
        $model->unpublish();
        $this->setRedirect('index.php?option=com_ablog&act=comments');
    }

    //Get checked CommentId to Edit, get this comment and show
    
    //Update showed and changed comment
    function save() {
        $model =& $this->getModel('comments');
        $model->updateComments();
        $this->setRedirect('index.php?option=com_ablog&act=comments');
    }
    
    function cancel() {
        $this->setRedirect('index.php?option=com_ablog&act=comments');
    }
}
?>
