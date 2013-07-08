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
class ABlogModelComments extends JModel
{
    
    function getComments($post_id) {
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');
        $query = 'SELECT * FROM' . $table . 'WHERE post_id=' . $post_id . ' AND published=1 ORDER BY id';
        $db->setQuery($query);
        return $db->loadObjectList();
    }
    
    function store($data) {
        $date = JFactory::getDate();
        $created_date = $date->toSql();
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');

        $query = "INSERT INTO" . $table . 
                "(id, creator, content, post_id, created_date, email_adress) VALUES('', '".
                $data['creator']. "', '" . $data['content'] . "','" . $data['post_id'] .
                "','" . $date . "','" . $data['email_adress'] . "')";
        $db->setQuery($query);
        return $db->query();
    }
    
     function storeAndPost($data) {
        $date = JFactory::getDate();
        $created_date = $date->toSql();
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comments');

        $query = "INSERT INTO" . $table . 
                "(id, creator, content, post_id, created_date, email_adress, published) VALUES('', '".
                $data['creator']. "', '" . $data['content'] . "','" . $data['post_id'] .
                "','" . $date . "','" . $data['email_adress'] ."','1'" . ")";
        $db->setQuery($query);
        return $db->query();
    }
    
    function storeCommentAnswer() {
        $data = JRequest::get('post');
        $date = JFactory::getDate();
	$date = $date->toSql();
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = "INSERT INTO" . $table . 
                "(id, comment_id, post_id, creator, content, published, created_date) VALUES ('', '". 
                $data['comment_id']. "', '" . $data['post_id'] . "', '" . $data['creator'] . "','" . $data['content'] . 
                "','" . $data['published']. "','" . $date . "')";
        $db->setQuery($query);
        return $db->query();
    }
    
    function storePublishCommentAnswer() {
        $data = JRequest::get('post');
        $date = JFactory::getDate();
        $date = $date->toSql();
        $data['published'] = 1;
        $db = $this->getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = "INSERT INTO" . $table . 
                "(id, comment_id, post_id, creator, content, published, created_date) VALUES ('', '". 
                $data['comment_id']. "', '" . $data['post_id'] . "', '" . $data['creator'] . "','" . $data['content'] . 
                "','" . $data['published']. "','" . $date . "')";
        $db->setQuery($query);
        return $db->query();
    }
    
    function getCommentAnswersForView($post_id, $comment_id) {
        $db = JFactory::getDBO();
        $table = $db->nameQuote('#__ablog_comment_answers');
        $query = 'SELECT * FROM' . $table .
                 ' WHERE post_id=' . $post_id . ' AND comment_id=' . $comment_id . ' AND published=1';
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    function getCommentByPostId($post_id, $comment_id) {
        $db = JFactory::getDBO();
        $table = $db->nameQuote('#__ablog_comments');
        $query = 'SELECT * FROM' . $table .
                 ' WHERE post_id=' . $post_id . ' ANDid=' . $comment_id;
        $db->setQuery($query);
        return $db->loadObjectList();
    }
}