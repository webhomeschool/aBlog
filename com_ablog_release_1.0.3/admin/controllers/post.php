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

class CpanelControllerPost extends JController
{    
    //If categories for PostView are loaded, show post
    //else create any
    function add() {
        $model_categories = $this->getModel('blog_categories');
        $kategories = $model_categories->getKategories();

        if($kategories) {
            $view = $this->getView('post', 'html');        
            $view->assignRef('kategories', $kategories);
            $view->display();
        } else {
            $this->setRedirect('index.php?option=com_ablog&act=posts');
            JError::raiseNotice( 100, JText::_('Please create a Categorie'));
            return false;
        }
    }
    
    function remove() {
        $model = $this->getModel('posts');
        $cids = JRequest::getVar('cid', '', 'post', 'array');
        $model->delete($cids);
        $this->setRedirect('index.php?option=com_ablog&act=posts');
    }


    function edit() {        
        $view = $this->getView('post', 'html');
        $model_posts = $this->getModel('posts');
        $model_comments = $this->getModel('comments');
        $view->setModel($model_posts);
        $model_kategories = $this->getModel('blog_categories');
        $cid = JRequest::getVar('cid');
        if(is_array($cid)) { $cid = $cid[0];}
        $post = $model_posts->getPost($cid);
        $id = $post->categorie_id;
        //Get Data from CommentsModel ordered to PostId and set into View
        $kategories = $model_kategories->getKategorie($id);
        $view->assignRef('kategories', $kategories);
        $view->assignRef('post', $post);
        $view->display();
    }
	
    function saveEditReturn() {
        $model = $this->getModel('posts');
        $model->storeEdit();
        $this->setRedirect('index.php?option=com_ablog&act=posts');
}

    function apply() {
        $model = $this->getModel('posts');
        $model->storeEdit();
        $post_id = JRequest::get('post');
        if($post_id['post_id']){
            $this->setRedirect('index.php?option=com_ablog&act=post&task=edit&cid=' . $post_id['post_id']);
        } else {
            $post_id = $model->getLastInsertedPostId();
            $this->setRedirect('index.php?option=com_ablog&act=post&task=edit&cid=' . $post_id);
        }
}
    
    function cancel() {
        $this->setRedirect('index.php?option=com_ablog&act=posts');
    }
}
?>