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

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Banners master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */


class CpanelController extends JController
{  
    
        public function display($cachable = false, $urlparams = false)
	{       
            
            $act = JRequest::getCmd('act', '');
            if(!$act) {
                $task = JRequest::getCmd('task', 'cpanel');
            } else {
                $task = $act;
            }
            $test = JPATH_COMPONENT . DS . 'controllers' . DS . $task . '.php';
            JPath::check($test);
            $file = JFile::exists(JPATH_COMPONENT . DS . 'controllers' . DS . $task . '.php');
            if(!$file) {
                JError::raiseError('500', JText::_('COM_ABLOG_ERROR_MESSAGE'));
                return false;
            }
                require_once JPATH_COMPONENT . DS . 'controllers' . DS . $task . '.php';
                $controller = 'CPanelController' . ucfirst($task);
                $controller = new $controller();
                $controller->execute(JRequest::getCmd('task'));
                $controller->redirect();            
        }
}
