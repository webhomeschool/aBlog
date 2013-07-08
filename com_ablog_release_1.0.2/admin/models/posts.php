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

class CpanelModelPosts extends JModel {

    function getPosts() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $query = 'SELECT * FROM' . $table . ' ORDER BY';
        $db->setQuery($query);
        $this->_posts = $db->loadObjectList();
        return $this->_posts;
    }

    function getPostsTeaser() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $query = $this->searchForPosts($table);

        if ($query == '') {
            $query = 'SELECT id, created_date, title, checked_out, checked_out_time, ordering, published, hits, creator, trashed, categorie_id, SUBSTR(content,1, 60) AS content FROM ' . $table;
        }
        $db->setQuery($query);
        $this->_posts = $db->loadObjectList();
        if (!$this->_posts) {
            $this->setError('post query failed');
            return false;
        }
        return $this->_posts;
    }

    function getPost($cid) {
        $db =  $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $query = 'SELECT * FROM' . $table . 'WHERE id=' . $cid;
        $db->setQuery($query);
        $this->_post = $db->loadObject();
        return $this->_post;
    }

    function delete($cids) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $id = $db->nameQuote('id');
        $query = 'DELETE FROM' . $table .
                'WHERE' . $id .
                'IN(' . implode(',', $cids) . ')';
        $db->setQuery($query);
        if (!$db->query()) {
            $errorMessage = $this->getDBO()->getErrorMsg();
            JError::raiseError(500, 'Error deleting Revues ' . $errorMessage);
            return false;
        }
    }

    function storeEdit() {
        $row = $this->getTable('post');
        //editEditor
        $text = ablogHelper::filterText(JRequest::get('post', JREQUEST_ALLOWHTML));

        $data = $text;
        $date = JFactory::getDate();
        $data['created_date'] = $date->toSql();
        $row->reset();
        $row->set('id', $data['post_id']);
        if (!$row->bind($data)) {
            $error = 'Data not bind';
            $this->setError($error);
            return false;
        }

        if (!$row->check()) {
            $error = 'Data not checked';
            $this->setError($error);
            return false;
        }

        if (!$row->store()) {
            $error = 'Data not stored';
            $this->setError($error);
            return false;
        }
        return true;
    }

    function publish() {
        $user = JFactory::getUser();
        $row = $this->getTable('post');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $row->publish($cid, 1, $user->id);
        //Call the untrash method
        $this->untrash();
    }

    function unpublish() {
        $user =  JFactory::getUser();
        $row = $this->getTable('post');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $row->publish($cid, 0, $user->id);
    }

    function setTheStateFields() {
        $app =  JFactory::getApplication();
        $option = 'com_ablog';
        $search_word = $app->getUserStateFromRequest($option . 'filter_search', 'filter_search');
        $this->setState('filter.search', $search_word);
        $state = $app->getUserStateFromRequest($option . 'filter_state', 'filter_state', '');
        $this->setState('filter.state', $state);
    }

    function searchForPosts($table) {
        //set the state fields for further operations
        $this->setTheStateFields();
        //get the input fields values to decide which query to use
        $search_word = $this->getState('filter.search');
        $search_state = $this->getState('filter.state');

        $query = null;

        if ($search_word != '') {
            JRequest::setVar('search_word', $search_word, 'post', true);
            $query = "SELECT id,created_date ,title ,SUBSTR(content,1,50) as content ,checked_out Ascending ,checked_out_time,published ,hits ,creator, categorie_id, trashed  FROM " . $table . " WHERE title LIKE '%" . $search_word . "%'";
            return $query;
        }
        if ($search_state == '') {
            JRequest::setVar('filter_published');
            $query = "SELECT id,created_date ,title ,SUBSTR(content,1,50) as content ,checked_out Ascending ,checked_out_time , published ,hits ,creator, categorie_id, trashed  FROM " . $table . " WHERE trashed=0";
            return $query;
        }
        if ($search_state == 1) {
            $query = "SELECT id,created_date ,title ,SUBSTR(content,1,50) as content ,checked_out Ascending ,checked_out_time , published ,hits ,creator, categorie_id, trashed  FROM " . $table . " WHERE published =1 AND trashed=0";
            return $query;
        }
        if ($search_state == 0) {
            $query = "SELECT id,created_date ,title ,SUBSTR(content,1,50) as content ,checked_out Ascending ,checked_out_time,published ,hits ,creator, categorie_id, trashed  FROM " . $table . " WHERE published=0";
            return $query;
        }

        if ($search_state == -2) {
            $query = "SELECT id,created_date ,title ,SUBSTR(content,1,50) as content ,checked_out Ascending ,checked_out_time,published ,hits ,creator, categorie_id, trashed  FROM " . $table . " WHERE trashed=1";
            return $query;
        }
    }

    function setTrash() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $cids = JRequest::getVar('cid');
        $db->setQuery(
                'UPDATE' . $table .
                ' SET trashed = 1 ' .
                ' WHERE id IN (' . implode(',', $cids) . ')'
        );
        $db->query();
    }

    function untrash() {

        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_posts');
        $cids = JRequest::getVar('cid');
        $db->setQuery(
                'UPDATE' . $table .
                ' SET trashed = 0 ' .
                ' WHERE id IN (' . implode(',', $cids) . ')'
        );
        $db->query();
    }

    function getLastInsertedPostId() {
        $db = $this->getDBO();
        $db->nameQuote('#__ablog_posts');
        return $db->insertid();
    }

}

?>
