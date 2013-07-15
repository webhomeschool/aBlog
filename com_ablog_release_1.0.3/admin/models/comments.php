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

jimport('joomla.application.component.model');

class CpanelModelComments extends JModel
{
    function getComments() {        
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');        
        $query = 'SELECT * FROM'. $table;        
        $db->setQuery($query);       
        $this->_comments = $db->loadObjectList();        
        return $this->_comments;
    }

    function getCommentsTeaser() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');
        $query = $this->searchForComments();
        //listen for selected fields

        if(empty($query)) {
            $query = 'SELECT DISTINCT id,created_date,creator, SUBSTR(content,1,50) as content ,checked_out,checked_out_time,published,post_id FROM '. $table . 'ORDER BY id DESC';
        }
        $db->setQuery($query);
        return $db->loadObjectList();
    }
    
    function delete($cids) {

        $db =$this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');
        $id = $db->nameQuote('id');
         $query =     "DELETE FROM #__ablog_comments
                      WHERE #__ablog_comments.id " .
                      'IN(' . implode(',', $cids) . ')';
        $db->setQuery($query);        
        if(!$db->query()) {
            $errorMessage = $this->getDBO()->getErrorMsg();
            JError::raiseError(500, 'Error deleting comments '. $errorMessage);
            return false;
        }
        $table = $db->nameQuote('#__ablog_comment_answers');
        $comment_id = $db->nameQuote('comment_id');
        $query = 'DELETE FROM' . $table .
                 ' WHERE' . $comment_id .
                 'IN(' . implode(',', $cids) . ')';      
        $db->setQuery($query);
        if(!$db->query()) {
            $errorMessage = $this->getDBO()->getErrorMsg();
            JError::raiseError(500, 'Error deleting comment answers '. $errorMessage);
            return false;
        }
    }
    
     function publish() {
        $user = JFactory::getUser();
        $table = $this->getTable('comment');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $table->publish($cid, 1, $user->id );
     }
    
    function unpublish() {
        $user = JFactory::getUser();
        $table = $this->getTable('comment');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $table->publish($cid, 0, $user->id );
    }

    function setTheStateFields() {
        $app = JFactory::getApplication();
        $option = 'com_ablog';
        $search_word = $app->getUserStateFromRequest($option.'filter_search', 'filter_search');
        $this->setState('filter.search', $search_word);
        $published = $app->getUserStateFromRequest($option.'filter_published', 'filter_published');
        $this->setState('filter.published', $published);
        $author = $app->getUserStateFromRequest($option.'filter_author', 'filter_author');    
        $this->setState('filter.author', $author);
        $post_id = $app->getUserStateFromRequest($option.'filter_post_id', 'filter_post_id');
        $this->setState('filter.post_id', $post_id);
        $date = $app->getUserStateFromRequest($option.'filter_date', 'filter_date');
        $this->setState('filter.date', $date);
    }
    //started is the getCommentsTeaser Function, data is needed in the display()
    //return only the query from database for the view
    function searchForComments() {
        $this->setTheStateFields();
        $db = $this->getDbo();
        $table = $db->nameQuote('#__ablog_comments');
        //set the state fields      
        $search_word =  $this->getState('filter.search');     
        $search_published = $this->getState('filter.published');
        $search_author = $this->getState('filter.author');
        $search_post_id = $this->getState('filter.post_id');
        $search_date = $this->getState('filter.date');

        $query_columns = "SELECT DISTINCT id,created_date,creator, SUBSTR(content,1,50) as content ,checked_out,checked_out_time,published,comment_answer_id,post_id FROM " . $table;
        $query = null;
        //the search_(value) is the jrequested int value from the selected field        

        if($search_word != '') {
            JRequest::setVar('search_word', $search_word, 'post', true);
            $query = $query_columns . " WHERE content LIKE '%". $search_word ."%'";         
            return $query;
        }
   
        if($search_published != '') {
            $query = $query_columns . " WHERE published =" . $search_published;
            return $query;
        }
   
       
        if($search_author != '') {
            $data = $this->getDataForView('creator');
            if($data) {
                 $author = $data[$search_author]->creator;
                 $query = $query_columns . " WHERE creator='" . $author ."' ORDER BY id DESC";      
                 return $query;                 
            }                   
            
        }
        
        if($search_post_id != '') {
            $data = $this->getDataForView('post_id');
            $post_id = $data[$search_post_id]->post_id;       
            $query = $query_columns . " WHERE post_id =" . $post_id . " ORDER BY id DESC" ;          
            return $query;
        }
        
        if($search_date != '') {
            $data = $this->getDataForView('created_date');
        
            if($data){
                $date = $data[$search_date]->created_date;
            } 
            $query = $query_columns . " WHERE created_date ='" . $date . "'";
            return $query;
        }
        
        //Listen to the selected Fields Options
    }
    //get all values from the database
    //the data used for searchForComments() to output the query results in the layout
    
    //get Data by Column from table for the View
    function getDataForView($column) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');
        $query = "SELECT * FROM " . $table . ' GROUP BY ' . $column . ' ORDER BY id DESC';
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }

    function updateComments() {      
        $date = JFactory::getDate();
        $row = $this->getTable('comment');
        $data = ablogHelper::filterText(JRequest::get('post', JREQUEST_ALLOWHTML));
        
        $data['created_date'] = $date->toMysql();
        // Daten an die Tabelle binden
        $row->reset();
        $id = $data['id'];
        $row->set('id', $id);
        if (!$row->bind($data)) {
            $error = 'Data not bind';
            $this->setError($error);
            echo 'not bindet';
            return false;
        }
        if (!$row->store()) {
            $error = 'Data not stored';
            $this->setError($error);
            return false;
        }
        return true;
    }

    function getComment($id) {
        $db =  $this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');
        $query = 'SELECT * FROM' . $table . 'WHERE id=' . $id;
        $db->setQuery($query);
        $result = $db->loadObject();
        return $result;
    }
}
?>