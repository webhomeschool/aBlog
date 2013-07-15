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
 
defined('_JEXEC') or die ('Restricted acess');
jimport('joomla.application.component.controller');

class CpanelControllerPosts extends JController
{
    function display($cachable = false, $urlparams = false) {
        $view = $this->getView('posts', 'html');
        $model = $this->getModel('posts');
        $results = $model->getPostsTeaser();
        $view->assignRef('results', $results);
        $view->display();
    }	
    
    function cancel() {
        $this->setRedirect('index.php?option=com_ablog&act=posts');
    }
    
    function publish() {
        $model = $this->getModel('posts');
        $model->publish();
        $this->setRedirect('index.php?option=com_ablog&act=posts');
    }
    
    function unpublish() {
        $model = $this->getModel('posts');
        $model->unpublish();
        $this->setRedirect('index.php?option=com_ablog&act=posts');
    }

    function trashed() {
        $model = $this->getModel('posts');
        $model->setTrash();
        $this->setRedirect('index.php?option=com_ablog&act=posts');
    }
    //Delete the Trashed Posts
    function trashedpublished() {
        $model = $this->getModel('posts');
        $cids = JRequest::getVar('cid', '', 'post', 'array');
        $model->delete($cids);
        $this->setRedirect('index.php?option=com_ablog&act=posts');
    }
}
?>
