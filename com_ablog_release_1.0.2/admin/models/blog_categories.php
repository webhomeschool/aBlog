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

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
jimport('joomla.utilities.date');
jimport('joomla.error.error');

class CpanelModelBlog_Categories extends JModel {

    function getKategories() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_categories');
        $query = 'SELECT * FROM' . $table;
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    function getKategorie($id) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_categories');
        $query = 'SELECT * FROM' . $table . 'WHERE id=' . $db->quote($id);
        $db->setQuery($query);
        $result = $db->loadObjectList();
        return $result;
    }

    protected function getPostId($id) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $query = 'SELECT * FROM' . $table . 'WHERE id=' . $db->quote($id);
        $db->setQuery($query);
        $result = $db->loadObject();
        return $result;
    }

    function delete($cids) {
        $db = $this->getDBO();

        $query = "DELETE b FROM #__ablog_categories b 
                      LEFT JOIN #__ablog_posts p ON p.categorie_id = b.id 
                      WHERE p.categorie_id IS NULL AND b.id " .
                "IN(" . implode(',', $cids) . ")";
        $db->setQuery($query);

        if (!$db->query()) {
            $errorMessage = $this->getDBO()->getErrorMsg();
            JError::raiseError(500, 'Error deleting categories ' . $errorMessage);
        }
    }

    function publish() {
        $user =  JFactory::getUser();
        $table =  $this->getTable('Categorie', 'CategorieTable');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $table->publish($cid, 1, $user->id);
    }

    function unpublish() {
        $user =  JFactory::getUser();
        $table =  $this->getTable('Categorie', 'CategorieTable');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $table->publish($cid, 0, $user->id);
    }

    function storeCategorie() {
        // Get the table        

        $row = $this->getTable('Categorie', 'CategorieTable');

        $data = JRequest::get('post');

        // Daten an die Tabelle binden		
        $row->reset();

        if (!$row->bind($data)) {
            $error = 'Data was not binded';
            $this->setError($error);
            return false;
        }

        if (!$row->check()) {
            $error = 'Datacheck has failed';
            $this->setError($error);
            return false;
        }

        if (!$row->store()) {
            echo 'test';
            $error = 'Datawas not stored';
            $this->setError($error);
            return false;
        }

        return true;
    }

    function updateKategorie() {

        // Get the table
        $date = JFactory::getDate();

        $row = $this->getTable('Categorie', 'CategorieTable');
        $data = JRequest::get('post');
        $data['created_date'] = $date->toMysql();
        // Daten an die Tabelle binden
        $row->reset();
        $id = $data['id'];
        $row->set('id', $id);
        if (!$row->bind($data)) {
            $error = 'Data was not binded';
            $this->setError($error);
            return false;
        }
        // Datensatz auf Gueltigkeit ueberpruefen
        // Die gebundenen Daten endgueltig speichern
        if (!$row->store()) {
            $error = 'Data was not stored';
            $this->setError($error);
            return false;
        }
        return true;
    }

    function checkAssignmentToPost($cids) {
        $db = $this->getDBO();
        $query = "SELECT * FROM #__ablog_posts p
                   WHERE p.categorie_id=" . $cids[0];

        $db->setQuery($query);
        $result = $db->loadColumn();
        return $result;
    }

}

?>
