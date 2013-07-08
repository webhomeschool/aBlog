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
jimport('joomla.application.component.view');

class CpanelViewPost extends JView
{
    protected $canDo;
    
    function display($tpl = null) {
        
        $this->canDo = ablogHelper::getActions();
        
        JHTML::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');
        JHtml::script('posts.js', '/administrator/components/com_ablog/assets/js/');
        JToolBarHelper::title('ablog', 'blog');
        
        ablogHelper::addSubmenu(JRequest::getCmd('act'));  
        
        $user = JFactory::getUser();
       
        $user_name = $user->name;
        $user_username = $user->username;
   
        $this->assignRef('user_name', $user_name);
        $this->assignRef('user_username', $user_username);
        JHTML::stylesheet('post.css', 'components/com_ablog/assets/css/');
        //Get Data from PostModel and set into View
        $cid = JRequest::getVar('cid');
        if(is_array($cid)) { $cid = $cid[0];}
        $post_id = $cid;
        
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        
        $this->addToolBar();

        parent::display($tpl);
    }

    function getCommentAnswersById($post_id, $comment_id) {
         $model_comments =& $this->getModel('comments');
         return $model_comments->getCommentAnswersById($post_id, $comment_id);
    }

    function cleanInput($text) {
        return strip_tags(htmlspecialchars($text));
    }
    
    function addToolBar(){
        
        if($this->canDo->get('core.edit')){
            JToolBarHelper::save('post.saveEditReturn', 'Save&Close');
            JToolBarHelper::apply('post.apply', 'Save');
            JToolBarHelper::cancel();
        }
    }
}
?>
