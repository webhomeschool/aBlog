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
 
 
// Don't allow direct linking
defined('_JEXEC') or die('Restricted access');

class CategorieTableCategorie extends JTable {
    /*     * @var int Primary key */

    public function __construct(&$_db) {
        parent::__construct('#__ablog_categories', 'id', $_db);
    }

    public function bind($array, $ignore = '') {
 
        if (isset($array) && is_array($array)) {
            $this->data = $array;
            return parent::bind($array, $ignore);
        } else {
            $this->setError('categorie not bind');
            return false;
        }
    }

    public function store($updateNulls = false) {  
        
        $table = JTable::getInstance('Categorie', 'CategorieTable');
        if ($table->load(array('name' => $this->name, 'post_id' => $this->post_id, 'published' => $this->published)) && ($table->id != $this->id || $this->id == 0)) {
            $this->setError(JText::_('COM_CATEGORIE_ERROR_UNIQUE_ALIAS'));
            return false;
        }
        // Attempt to store the data.
        return parent::store($updateNulls);
    }

    function check() {

        if (!$this->name == '') {
            return true;
        }

        if(!$this->post_id == '') {
            return true;
        }
        if(!$this->published == '') {
            return true;
        }
        $this->setError('The categorie input is empty');
        return false;
    }
}

?>