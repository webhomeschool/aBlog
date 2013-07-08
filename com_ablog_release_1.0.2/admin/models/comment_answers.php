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

class CpanelModelComment_Answers extends JModel
{
    function getCommentAnswers() {        
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');        
        $query = 'SELECT * FROM'. $table;        
        $db->setQuery($query);       
        $this->_comment_answers = $db->loadObjectList();        
        return $this->_comment_answers;
    }

    function getCommentAnswer($id) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = 'SELECT * FROM' . $table . 'WHERE id=' . $id;
        $db->setQuery($query);
        $result = $db->loadObject();
        return $result;
    }

    function getCommentAnswersTeaser() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = $this->searchForCommentAnswers($table);
       
        if(empty($query)) {
            $query = 'SELECT id, SUBSTR(content,1,50) AS content, creator, created_date, published, comment_id, post_id FROM '. $table . ' ORDER BY id DESC';
        }
        $db->setQuery($query);
        $this->results = $db->loadObjectList();
        return $this->results;
    }
    
    function delete($cids) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $id = $db->nameQuote('id');
       $query =     "DELETE FROM #__ablog_comment_answers
                      WHERE #__ablog_comment_answers.id " .
                      'IN(' . implode(',', $cids) . ')';
        $db->setQuery($query);        
        if(!$db->query()) {
            $errorMessage = $this->getDBO()->getErrorMsg();
            JError::raiseError(500, 'Error deleting comment answers '. $errorMessage);
        }
    }
    
     function publish() {
        $user = JFactory::getUser();
        $table = $this->getTable('comment_answer');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $table->publish($cid, 1, $user->id );
    }
    
    function unpublish() {
        $user = JFactory::getUser();
        $table = $this->getTable('comment_answer');
        $cid = JRequest::getVar('cid', '', 'post', 'array');
        $table->publish($cid, 0, $user->id );
      
    }

     function setTheStateFields() {
     
        $app = JFactory::getApplication();
        $option = 'com_ablog';
        $search = $app->getUserStateFromRequest($option .'filter_search', 'filter_search');  
        $this->setState('filter.search', $search);
        $published = $app->getUserStateFromRequest($option.'filter_published', 'filter_published');  
        $this->setState('filter.published', $published);
        $author = $app->getUserStateFromRequest($option.'filter_author', 'filter_author');
        $this->setState('filter.author', $author);
        $date = $app->getUserStateFromRequest('filter_date', 'filter_date');
        $this->setState('filter.date', $date);
        $post_id = $app->getUserStateFromRequest('filter_post_id', 'filter_post_id');
        $this->setState('filter.post_id', $post_id);
        $comment_id = $app->getUserStateFromRequest('filter_comment_id', 'filter_comment_id');
        $this->setState('filter.comment_id', $comment_id);
    }
    //triggered in getCommentAnswersTeaser above
    function searchForCommentAnswers($table) {
        $db = $this->getDbo();
        $table = $db->nameQuote('#__ablog_comment_answers');
        //set the StateFields
        $this->setTheStateFields();
        $search_word = $this->getState('filter.search');
        $search_published = $this->getState('filter.published'); 
        $search_comment_id = $this->getState('filter.comment_id');
        $search_author = $this->getState('filter.author');
      
        $search_post_id = $this->getState('filter.post_id');
        $search_date = $this->getState('filter.date');
     
             
        //Get the only the unique results
        $query_columns = "SELECT DISTINCT id,created_date,creator, SUBSTR(content,1,50) as content ,checked_out,checked_out_time,published,post_id, comment_id FROM " . $table;
        //Get the query related to the selected fields values
        //create all the queries for selected fields
        
        if($search_word != '') {
            JRequest::setVar('search_word', $search_word, 'post', true);
            $query = $query_columns . " WHERE content LIKE '%". $search_word ."%'";         
            return $query;
        }
      
        if($search_published != '') {           
            $query = $query_columns . " WHERE published = " . $search_published . " ORDER BY id DESC";
            return $query;
        }
       
        if($search_author != '') {         
            $data = $this->getDataForView('creator');
            $author = $data[$search_author]->creator;
            //clean the input from the select fields           
            $query = $query_columns . " WHERE creator='" . $author . "'";
            //output all entries within the selected author
            return $query;
        }

        if($search_post_id != '') {
            $data = $this->getDataForView('post_id');
           
            $post_id = $data[$search_post_id]->post_id;
            $query = $query_columns . " WHERE post_id =" . $post_id . " ORDER BY id DESC";
            //output all entries within the selected post_id
            return $query;
        }
        
        if($search_comment_id != '') {
          $data = $this->getDataForView('comment_id');

          $comment_id = $data[$search_comment_id]->comment_id;
  
          $query = $query_columns . " WHERE comment_id =" . $comment_id . " ORDER BY id DESC";
          //output all entries within the selected post_id
          return $query;
       }
        if($search_date != '') {
            $data = $this->getDataForView('created_date');
            $date = $data[$search_date]->created_date;
        
            $query = $query_columns . " WHERE created_date ='" . $date . "'";
        
            return $query;
        } else {
            if($search_date == '') {
                  $query = $query_columns . " WHERE created_date";
            }
        }
    }
    //get the Data from the Database for the select fields
    function getDataForSelectFields() {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = "SELECT * FROM" . $table;
        $db->setQuery($query);
        $results = $db->loadAssocList();
   
        return $results;
    }
    //this function takes the data from the selected column in the select fields ordered for the view
    function getDataForView($column) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = "SELECT * FROM " . $table . ' GROUP BY ' . $column . ' ORDER BY id';
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }

    function updateCommentAnswer() {
        // Get the table
        $date = JFactory::getDate();
        $row = $this->getTable('comment_answer');
        $data = ablogHelper::filterText(JRequest::get('post', JREQUEST_ALLOWHTML));
        $data['created_date'] = $date->toMysql();
        // Daten an die Tabelle binden
        $row->reset();
        $id = $data['id'];
        $row->set('id', $id);
        if (!$row->bind($data)) {
           $error = 'Data not bind';
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
}
?>
