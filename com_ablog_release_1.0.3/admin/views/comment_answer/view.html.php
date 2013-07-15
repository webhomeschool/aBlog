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

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class CpanelViewComment_Answer extends JView {

    function display($tpl = null) {
        JHTML::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');
        
        $this->canDo = ablogHelper::getActions();
        
        JToolBarHelper::title('ablog', 'blog');
        
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        
        $this->addToolBar();
        
	parent::display($tpl);		
    }
    
    function addToolBar() {
        
         JToolBarHelper::title('ablog', 'blog');
        
        if ($this->canDo->get('core.create')) {
           JToolBarHelper::save('comment_answer.save', 'JTOOLBAR_SAVE', true);
           JToolBarHelper::cancel();
        }
    }
}
