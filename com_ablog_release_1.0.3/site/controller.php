<?php

/**
 * Webhomeschool Component
 * @package ABlog
 * @subpackage Controllers
 *
 * @copyright (C) 2013 Webhomeschool. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.webhomeschool.de
 * */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class ABlogController extends JController {

    /**
     * Method to display the view
     *
     * @access public
     * 
     */
    //Cotroller Section Tasks with complement functions
    function display($cachable = false, $urlparams = false) {
        JHTML::stylesheet('posts.css', 'components/com_ablog/assets/css/');
        $id = JRequest::getCmd('id');

        if (JRequest::getCmd('view') == 'posts' && !$id) {
            $this->posts();
           
        }
    }

    function post() {
        $post_id = JRequest::getCmd('id');
        $model_posts = $this->getModel('posts');
        $row = $model_posts->getPost($post_id);
        if ($row) {
            $model_categories = $this->getModel('categories');
            $model_comments = $this->getModel('comments');
            $allvideo_plugin = JPluginHelper::importPlugin('content', 'jw_allvideos');
            $view = $this->getView('post', 'html');
            $view->setModel($model_comments);
            $params = JComponentHelper::getParams('com_ablog');
            $this->countHits();
            $this->displayHits($row, $params, $view);
            //Get the AllVideoPlugin       
            if ($allvideo_plugin && $this->getTask('post')) {

                $row->text = $row->content;
                //cut the reference
                unset($row->content);
                $app = JFactory::getApplication();
                $params = '';
                $offset = 0;
                $dispatcher = JDispatcher::getInstance();

                $results = $dispatcher->trigger('onContentPrepare', array('com_content.article', &$row, &$this->params, $offset));
            }
            if (isset($row->text)) {
                $row->content = $row->text;
                $result_post = $row;
            }
            $result_post = $row;
            //Get Data from CommentsModel ordered to PostId and set into View
            $result_comments = $model_comments->getComments($post_id);
            $view->assignRef('result_post', $result_post);
            $view->assignRef('result_comments', $result_comments);
            $view->display();
        }
    }

    function posts() {
        //get the models 
        $model_posts = $this->getModel('posts');
        $model_categories = $this->getModel('categories');
        $categories = $model_categories->getKategories();

        //get the view
        $view = $this->getView('posts', 'html');

        //assign the categories
        $view->assignRef('categories', $categories);

        //set the model to view
        $view->setModel($model_posts);
        $view->setModel($model_categories);

        $id = JRequest::getCmd('id');
        //row data
        if ($id) {
            $row = $model_posts->getAllIdPosts($id);
        } else {
            $row = $model_posts->getAllPosts();
        }

        if ($row) {
            $allvideo_plugin = JPluginHelper::importPlugin('content', 'jw_allvideos');
            if ($allvideo_plugin) {
                $allvideo_data = JPluginHelper::getPlugin('content', 'jw_allvideos');
                $allvideo_params = $allvideo_data->params;
                $allvideo_params_array = explode(',', $allvideo_params);
                $view = $this->getView('posts', 'html');
                foreach ($allvideo_params_array as $video_params):
                    $pos_colon = strpos($video_params, ':');

                    $words_before_colon = substr($video_params, 0, $pos_colon);

                    if ($words_before_colon == '"vwidth"') {
                        $end_pos = $pos_colon + 1;
                        $all_video_width = substr($video_params, $end_pos);
                        

                        $first_quote = strpos($all_video_width, '"') + 1;
                        $last_quote = strrpos($all_video_width, '"') + -1;
                        $video_width = $all_video_width;
                        $all_video_width = substr($video_width, $first_quote, $last_quote);
                        
                        $view->assignRef('all_video_width', $all_video_width);
                    }

                    if ($words_before_colon == '"vheight"') {
                        //assign the all_video_height to the view
                        $all_video_height = substr($video_params, $pos_colon);
                        $first_quote = strpos($all_video_height, '"');
                        $last_quote = strrpos($all_video_height, '"');
                        $allvideo_height = substr($all_video_height, $first_quote, $last_quote);
                        $view->assignRef('all_video_height', $all_video_height);
                    }
                endforeach;
                //assign the all_video_width to the view
                $view->assignRef('all_video_width', $all_video_width);
                $view->assignRef('all_video_height', $all_video_height);
                //assign the all_video_height to the view
                $params = JComponentHelper::getParams('com_ablog');


                //Get the AllVideoPlugin              
                if ($allvideo_plugin && $this->getTask('posts') || $this->getTask() == '') {
                    $row = $row[0];
                 
                    $row->text = $row->content;
                    //cut the referenze
                    unset($row->content);
                    $app = JFactory::getApplication();
                    $params = '';
                    $offset = 0;
                    $dispatcher = JDispatcher::getInstance();

                    $results = $dispatcher->trigger('onContentPrepare', array('com_content.article', &$row, &$this->params, $offset));
                }
                if (isset($row->text)) {
                    $text = $row->text;
                    unset($row->text);
                    $row->content = $text;
                }


                if (is_object($row)) {
                    $posts[] = $row;
                } else {
                    $posts = $row;
                }
            } else {
                if ($id) {
                    $posts = $model_posts->getAllIdPosts($id);
                   
                } else {
                    $posts = $model_posts->getAllPosts();
                }
            }

            $view->assignRef('posts', $posts);
        }
        $view->display();
    }

    protected function displayHits($row, $params, $view) {
        $show_hits = $params->get('ablog_show_hits');
        $hits = $row->hits;
        $view->assignRef('hits', $hits);
    }

    function save_comment() {
        JRequest::checkToken() or jexit('Invalid Token');
        $model_comments = & $this->getModel('comments');
        $data = JRequest::get('post');
        $email_field = $data['email_adress'];

        $is_mail = JMailHelper::isEmailAddress($email_field);

        if ($is_mail) {
            $email_cleaned = JMailHelper::cleanAddress($email_field);
        }

        if ($data['creator'] != '' && $data['content'] != '') {
            $data['creator'] = trim(strip_tags(htmlspecialchars($data['creator'])));
            $data['content'] = trim(strip_tags(htmlspecialchars($data['content'])));
            $data['email_adress'] = $email_cleaned;
            //show Comments without Administrator
            $params = JComponentHelper::getParams('com_ablog');
            $params_publishing = $params->get('publishing_comments');


            if ($params_publishing == 1) {
                $model_comments->storeAndPost($data);
            } else {
                $model_comments->store($data);
            }
            $this->setRedirect(JRoute::_('index.php?option=com_ablog&task=post&id=' . JRequest::getCmd('id')));
        } else {
            $this->setRedirect(JRoute::_('index.php?option=com_ablog&task=post&id=' . JRequest::getCmd('id')));
        }
    }

    function save_comment_answers() {

        JRequest::checkToken() or jexit('Invalid Token');
        $view = $this->getView('post', 'html');
        $model_comments = $this->getModel('comments');
        $post_id = JRequest::getCmd('id');
        $post = JRequest::get('post');
        $params = JComponentHelper::getParams('com_ablog');
        $params_publish = $params->get('publishing_comments');
        //From the PostField comment_id
        $comment_id = $post['comment_id'];
        $comments = $model_comments->getCommentByPostId($post_id, $comment_id);

        if (!$comments) {
            $this->setRedirect(JRoute::_('index.php?option=com_ablog&task=post&id=' . JRequest::getCmd('id')));
        }
        $data = JRequest::get('post');
        $model_posts = $this->getModel('posts');

        if ($data['creator'] || $data['content'] != '') {
            if ($params_publish != 0) {
                $model_comments->storePublishCommentAnswer();
            } else {
                $model_comments->storeCommentAnswer();
            }
        }

        $post = JRequest::get('post');
        $view->setModel($model_comments);
        $view->setModel($model_posts);
        $this->setRedirect(JRoute::_('index.php?option=com_ablog&task=post&id=' . JRequest::getCmd('id')));
    }

    function countHits() {
        $model = $this->getModel('posts');
        $model->updatePostHits();
    }

    private function getCommentAnswersById($post_id, $comment_id) {
        $model_comments = $this->getModel('comments');
        return $model_comments->getCommentAnswersById($post_id, $comment_id);
    }

    private function getKategories() {
        $model_categories = $this->getModel('categories');
        return $model_categories->getKategories();
    }

    private function getPostsById($id) {
        $model_posts = $this->getModel('posts');
        return $model_posts->getPost($id);
    }

}