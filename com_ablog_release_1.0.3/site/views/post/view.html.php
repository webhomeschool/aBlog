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
jimport('joomla.application.component.view');

class ABlogViewPost extends JView
{
    public function display($tpl =  null) {
         JHtml::stylesheet('post.css','components/com_ablog/assets/css/');
        //Get Data from PostModel and set into View        
        parent::display($tpl);
    }

    protected function getCommentAnswersForView($post_id, $comment_id) {
         $model_comments = $this->getModel('comments');
         return $model_comments->getCommentAnswersForView($post_id, $comment_id);
    }
    
    protected function cleanInput($text) {
        return strip_tags(htmlspecialchars($text));
    }

    protected function showHits() {
        $params = JComponentHelper::getParams('com_ablog');
        if($params->get('ablog_show_hits') == 1) {
            return ' | Hits: ' . $this->hits;
        }
    }
}