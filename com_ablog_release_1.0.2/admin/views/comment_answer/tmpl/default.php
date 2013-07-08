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
?>

<form action="index.php" method="post" name="adminForm">
        <table>
        <tr>
            <td>
                <label for="creator"><?php echo JText::_('COM_ABLOG_CREATOR'); ?></label>
            </td>
            <td>
                <input type="text" id="creator" name="creator" id="creator" size="25" value="<?php echo $this->results->creator;  ?>" />
            </td>

        </tr>
        <tr>
            <td cols="2">
                <input type="hidden" id="created_date" name="created_date" id="created_date" size="25" value="<?php echo $this->results->created_date; ?>" />
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                <label for="content"><?php echo JText::_('COM_ABLOG_CONTENT'); ?></label>
            </td>
            <td>
                <?php echo $editor->display('content', $this->results->content, '', 50, 50, 50, 50, 'ablog_comment_answer'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="published"><?php echo JText::_('COM_ABLOG_PUBLISHED'); ?></label>
            </td>
            <td><?php echo JHTML::_('select.booleanlist', 'published', 'class="inputbox"', ''); ?>
            </td>
        </tr>
        <tr>
            <td cols="2">
                <input type="hidden" name="option" value="com_ablog" />
                <input type="hidden" name="act" value="comment_answer" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="hidemainmenu" value="0" />
                <input type="hidden" name="post_id" value="<?php echo $this->results->post_id; ?>"/>
                <input type="hidden" name="comment_id" value="<?php echo $this->results->comment_id; ?>" />
                <input type="hidden" name="id" value="<?php echo $this->results->id; ?>" />                
            </td>
        </tr>
    </table>
</form>