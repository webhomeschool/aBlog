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

class CpanelControllerComments extends JController
{
    function display($cachable = false, $urlparams = false) {
        $view = $this->getView('comments', 'html');
        $model = $this->getModel('comments');
        $view->setModel($model);
        $view->display();
    }
    
    function publish() {
        $model = $this->getModel('comments');
        $model->publish();
        $this->setRedirect('index.php?option=com_ablog&act=comments');
    }
    
    function unpublish() {
        $model = $this->getModel('comments');
        $model->unpublish();
        $this->setRedirect('index.php?option=com_ablog&act=comments');
    }
    
    function remove() {
        $model_comments =& $this->getModel('comments');
        $cids = JRequest::getVar('cid', '', 'post', 'array');
        $model_comments->delete($cids);
        $this->setRedirect('index.php?option=com_ablog&act=comments');
    }
    
    function edit() {        
            
                 $model = $this->getModel('comments');
                 $view = $this->getView('comment', 'html');
                 $id = JRequest::getVar('cid');
                 if(is_array($id)) $id = $id[0];
                 $results = $model->getComment($id);
                 $view->assignRef('results', $results);
                 $view->display();
    }
}
?>