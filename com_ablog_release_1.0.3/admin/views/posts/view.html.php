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

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');


class CpanelViewPosts extends JView {
    
    protected $canDo;


    public function display($tpl = null) {
        
        $this->canDo = ablogHelper::getActions();
        
        $layout = JRequest::getVar('layout');
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('ABLOG_TITLE') . ' :: ' .JText::_('POSTS'));
        //Input the Css-Styles and JS-Scripts
        JHtml::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');
        JHtml::script('jquery.js', '/administrator/components/com_ablog/assets/js/');
        JHtml::script('posts.js', '/administrator/components/com_ablog/assets/js/');
        //Input the Bar Icons
        JToolBarHelper::title('ablog', 'blog.png');
        
        $this->addToolBar();
       
        //Get the filterstate from state fields
        $app = JFactory::getApplication();
        $state = $app->getUserStateFromRequest('filter_state', 'filter_state', '');
        $this->assignRef('state', $state);
      
      //switch the Deleted and Trash Button with defined state
        if($state == -2) {
            JToolBarHelper::deleteList('', 'posts.trashedpublished', 'JTOOLBAR_EMPTY_TRASH');
        }else {
            JToolBarHelper::trash('posts.trashed');
        }
        ablogHelper::addSubmenu(JRequest::getCmd('act'));
        
        parent::display($tpl);
    }

    protected function buildTeaser($text) {
        return strip_tags($text) . '...';
    }

    protected function createUntrashItem($key) {
        return '<a class="untrash_item" title="untrash_item" onclick="return listItemTask(\'cb'.$key . '\', \'posts.untrash\')" href="javascript:void(0)"><span>Untrash</span></a>';
    }
    
    public function addToolBar() {
        
       if($this->canDo->get('core.create')) {
            JToolBarHelper::addNewX('post.add', 'Add');
       }
       
       if($this->canDo->get('core.edit')) {
           JToolBarHelper::editList('post.edit', 'Edit');
       }
       
       if($this->canDo->get('core.edit.state')) {
           JToolBarHelper::publish('posts.publish', 'JTOOLBAR_PUBLISH', true);
           JToolBarHelper::unpublish('posts.unpublish', 'JTOOLBAR_UNPUBLISH', true);
       }        
    }
}

