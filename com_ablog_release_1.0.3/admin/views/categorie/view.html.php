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

class CpanelViewCategorie extends JView {

    protected $canDo;

    function display($tpl = null) {
    
        $this->canDo = ablogHelper::getActions();
        ablogHelper::addSubmenu(JRequest::getCmd('act'));

        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        $this->addToolBar();

        JHTML::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');

        JHTML::stylesheet('toolbar.css', 'administrator/components/com_ablog/assets/css/');

        parent::display($tpl);
    }

    function addToolBar() {
        JToolBarHelper::title('ablog', 'blog');
        if ($this->canDo->get('core.create')) {
            
            if (JRequest::getVar('cid')) {
                    JToolBarHelper::save('categorie.saveEdit');
            } else{
                JToolBarHelper::save('categorie.save');
            }
            
            JToolBarHelper::cancel('categorie.cancel');
        }
    }

}