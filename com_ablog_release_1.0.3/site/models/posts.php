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
defined('_JEXEC') or die('Restricted access');
// Load the base JModel class
jimport('joomla.application.component.model');
jimport( 'joomla.utilities.date' );

/**
 * Revue Model
 */
class ABlogModelPosts extends JModel {
    function getAllIdPosts($id) {
        $db =  $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $limitstarter = JRequest::getCmd('start', 0);
        $limitend = 3;
        $query = 'SELECT * FROM' . $table . ' WHERE categorie_id=' . $id . ' AND trashed=0 AND published=1 LIMIT ' . $limitstarter . ', ' . $limitend;
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    function getAllPosts() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $limitstarter = JRequest::getCmd('start', 0);
        $limitend = 3;
        $query = 'SELECT * FROM' . $table . 'WHERE trashed=0 AND published=1 LIMIT ' . $limitstarter . ', ' . $limitend;
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    function getPost($id) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $query = 'SELECT * FROM' . $table .
                ' WHERE id=' . $id . ' AND published=1 AND trashed=0';
        $db->setQuery($query);

        return $db->loadObject();
    }   
    //This value is for the Pagination
    function getTotalPosts() {
        $id = JRequest::getVar('id', 0);
            if($id != '') {
            $db = $this->getDBO();
            $table = $db->nameQuote('#__ablog_posts');
            $query = 'SELECT * FROM' . $table .
                     ' WHERE categorie_id=' . $id . ' AND trashed=0';
            $db->setQuery($query);
            $results = $db->loadObjectList();
            return count($results);
        }else {
             $db = $this->getDBO();
             $table = $db->nameQuote('#__ablog_posts');
             $query = 'SELECT * FROM' . $table . ' WHERE trashed=0';
             $db->setQuery($query);
             $results = $db->loadObjectList();
             return count($results);
        }
    }

    function updatePostHits() {
        $id = JRequest::getCmd('id');
        $db = $this->getDbo();
        $db->setQuery(
                        'UPDATE #__ablog_posts' .
                        ' SET hits = hits + 1' .
                        ' WHERE id = '. $id
              );
        $db->query();
    }
}