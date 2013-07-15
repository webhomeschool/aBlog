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
$editor = JFactory::getEditor();

$task = JRequest::getCmd('task');
if($task === 'add') {
	$post_title = '';
	$kategories = $this->kategories;
	$post_content = '';
	$post_id = '';
}
else {
    $post_title = $this->post->title;
	$kategories = $this->kategories;
	$post_content = $this->post->content;
	$post_id = $this->post->id;	
}

?>

<form action="index.php" method="post" name="adminForm">
    
    <table border="0">
      
        <tr>
            <td>
                <label for="title"><?php echo JText::_('COM_ABLOG_TITLE'); ?></label>  
            </td>
            <td>
                <input type="text" id="title" name="title" id="title" size="25" value="<?php echo $post_title; ?>" />
            </td>
			
        </tr>
        <tr>
            <td>
                <label for="categories"><?php echo JText::_('COM_ABLOG_POST_CATEGORIES'); ?></label>  
            </td>
            <td>
                <select id="categories" name="categorie_id">
                
                           <?php							
                                foreach($kategories as $kategories) {
                                    echo '<option value=' . $kategories->id . '>' .
                                            $kategories->name .
                                         '</option>';
                                }
			  ?>
              
                </select>
            </td>
        </tr>
         <tr>
            <td cols="2">
                <label for="video_hoster"><?php //echo JText::_('Video_Hoster'); ?></label>
            </td>
        </tr>
        <tr>
            <td cols="2">
                <input type="hidden" id="creator_username" name="creator_username" value="<?php echo $this->user_username; ?>"
            </td>
        </tr>
        <tr>
            <td cols="2">
                <input type="hidden" id="creator" name="creator" id="creator" size="25" value="<?php echo $this->user_name; ?>" />
            </td>
        </tr>
        <tr>
            <td cols="2">
                <input type="hidden" id="created_date" name="created_date" id="created_date" size="25" value="<?php ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="content"><?php echo JText::_('COM_ABLOG_CONTENT'); ?></label>
            </td>
            <td style="height: 100%;">
                
                <?php echo $editor->display('content', $post_content, '', 50, 50, 50, 50, 'ablog_content'); ?>
              
            </td>
        </tr>
        <tr>
            <td>
                <label for="published"><?php echo JText::_('COM_ABLOG_PUBLISHED'); ?></label>
            </td>
            <td><?php echo JHTML::_('select.booleanlist', 'published', 'class="inputbox"', ''); ?>
            </td>
        </tr>
    </table>

    <input type="hidden" name="task" value="" />
    <input type="hidden" name="option" value="com_ablog" />
    <input type="hidden" name="act" value="posts" />
    <input type="hidden" name="hidemainmenu" value="0" />
    <input type="hidden" name="hits" value="0" />
    <input type="hidden" name="ordering" value="0" />
    <input type="hidden" name="checked_out" value="0" />
    <input type="hidden" name="checked_out_time" value="0" />
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
    
</form>