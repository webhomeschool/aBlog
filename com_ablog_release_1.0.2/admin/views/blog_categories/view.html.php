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

class CpanelViewBlog_Categories extends JView {

    protected $canDo;

    function display($tpl = null) {
        $this->canDo = ablogHelper::getActions();

        JHTML::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');
        JToolBarHelper::title('ablog', 'blog.png');
       
        ablogHelper::addSubmenu(JRequest::getCmd('act'));
        
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);

        // Set the document
        $this->setDocument();
    }

    protected function addToolBar() {
        if ($this->canDo->get('core.create')) {
            JToolBarHelper::addNew('blog_categories.add');
            
        }
        if ($this->canDo->get('core.edit')) {
            JToolBarHelper::editList('blog_categories.edit');
        }
        
        if($this->canDo->get('core.edit.state')) {
            JToolBarHelper::publish('blog_categories.publish', 'JTOOLBAR_PUBLISH', true);
            JToolBarHelper::unpublish('blog_categories.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        }        
        
        if ($this->canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'blog_categories.remove', 'JTOOLBAR_DELETE');
        }
        if ($this->canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_ablog');
        }
    }

    protected function setDocument() {
        JToolBarHelper::title('A Blog', 'blog.png');
    }

}