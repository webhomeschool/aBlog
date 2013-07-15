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
require_once(JPATH_COMPONENT.DS.'controller.php');
// Create the controller
$controller = new ABlogController();
//Perform the requested task
$controller->execute(JRequest::getCmd('task'));
//Redirect if set by the controller
$controller->redirect();
?>