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
defined( '_JEXEC' ) or die( 'Restricted access' );
// Load the base JModel class
jimport( 'joomla.application.component.model' );
/**
* Revue Model
*/
class ABlogModelCategories extends JModel
{    
    public function getKategories() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_categories');
        $query = "SELECT * FROM" . $table . 'WHERE published=1';
        $db->setQuery($query);
        return $db->loadObjectList();
    }

}