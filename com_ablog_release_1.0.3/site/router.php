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
defined('_JEXEC') or die;

jimport('joomla.application.categories');

/**
 * Build the route for the com_content component
 *
 * @param	array	An array of URL arguments
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 * @since	1.5
 */
function ABlogBuildRoute(&$query) {

//route for the kategories of the blog

$segments = array();


    if (isset($query['view']) && $query['view'] == 'posts') {
        if (isset($query['kategorie'])) {
            $cat = $query['kategorie'];
        }

        if (isset($query['id'])) {
            $id = $query['id'];
        }

        if (isset($query['view'])) {
            $view = $query['view'];
        } else {
            $view = 'posts';
        }


        $db = JFactory::getDBO();
        $table = $db->nameQuote('#__ablog_categories');
        $db_query = 'SELECT * FROM ' . $table;
        $db->setQuery($db_query);
        $items_query = $db->loadObjectList();

        $segments[] = $view;

        if ($items_query):
            foreach ($items_query as $items_kategory) {
                if ($items_kategory->name == $query['kategorie']) {
                    $segments[] = $cat;
                }

                if ($items_kategory->id == $query['id']) {
                    $segments[] = $id;
                }
            }


            unset($query['id']);
            unset($query['view']);
            unset($query['kategorie']);

            //route for the post links in view posts
        endif;
    } 


    if (isset($query['view']) && $query['view'] == 'post') {


        $view = $query['view'];

        if (isset($query['id'])):
            $post_id = $query['id'];


            $db = JFactory::getDBO();
            $table = $db->nameQuote('#__ablog_posts');
            $db_query = 'SELECT * FROM ' . $table . ' WHERE id=' . $query['id'];
            $db->setQuery($db_query);
            $item_post = $db->loadResult();

            $segments[] = $query['view'];
            $segments[] = $query['task'];
            $segments[] = $query['id'];

            unset($query['view']);
            unset($query['task']);
            unset($query['id']);
            
        endif;
    }
    
    return $segments;
}
 

/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 * @since	1.5
 */
function ABlogParseRoute($segments) {

    if ($segments[0] == 'posts' && isset($segments)) {
        $vars = array();
        $vars['task'] = $segments[0];
        $vars['kategorie'] = $segments[1];
        $vars['id'] = $segments[2];
    }
    if ($segments[0] == 'post' && isset($segments)) {
        $vars = array();
        $vars['view'] = $segments[0];
        $vars['task'] = $segments[1];
        $vars['id'] = $segments[2];
    }
    return $vars;
}
