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
?>
<form action="index.php" method="post" name="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo JRequest::getVar('search_word'); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />

            <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
  
        <div class="filter-select fltrt">
            <select name="filter_author" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_AUTHOR'); ?></option>
                <?php echo JHtml::_('select.options', $this->getselectFieldsValues('creator'), 'value', 'text', $this->getFieldsValueFromRequest('author'), true);//the this->getselectFieldsValues are all values from the column ?>
            </select>
            <select name="filter_post_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo '-Select Post Id-'; ?></option>
                <?php echo JHtml::_('select.options',$this->getselectFieldsValues('post_id') , 'value', 'text', $this->getFieldsValueFromRequest('post_id'), true); ?>
            </select>
            <select name="filter_comment_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo '-Select Comment Id-'; ?></option>
                <?php echo JHtml::_('select.options', $this->getselectFieldsValues('comment_id'), 'value', 'text', $this->getFieldsValueFromRequest('comment_id'), true); ?>
            </select>
            <select name="filter_date" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo '-Select Date-'; ?></option>
                <?php echo JHtml::_('select.options', $this->getselectFieldsValues('created_date'), 'value', 'text', $this->getFieldsValueFromRequest('date'), true); ?>
            </select>
            <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>  
                <?php echo JHtml::_('select.options', array('unpublished', 'published'), 'value', 'text',$this->getFieldsValueFromRequest('published'), true); ?>
            </select>
        </div>
    </fieldset>
    <table class="adminlist">
        <thead>
            <tr>
                <th>#</th>
                <th width="10">
                    <input type="checkbox"
                           name="toggle"
                           value="" onclick="checkAll(
                           <?php echo count($this->results); ?>);" />
               
                </th>
                <th width="50%"><?php echo JText::_('COM_ABLOG_CONTENT'); ?></th>
                <th width="8%">
                    <?php echo JText::_('COM_ABLOG_CREATOR'); ?>
                </th>
                <th><?php echo JText::_('COM_ABLOG_DATE'); ?></th>
                <th width="5%" align="center">
                    <?php echo JText::_('COM_ABLOG_PUBLISHED'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ABLOG_POST_ID'); ?>
                </th>
                <th>
                    <?php echo JText::_('COM_ABLOG_COMMENT_ID'); ?>
                </th>
                <th width="10"><?php echo JText::_('ID'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                    if ($this->results) {
                        foreach ($this->results as $key => $row) {
                          
                            $checked = JHTML::_('grid.id', $key, $row->id);
                            $published = JHTML::_('grid.published', $row, $key);
            ?>
                            <tr>
                                <td> <?php echo $key + 1 ?> </td>
                                <td><?php echo $checked; ?></td>
                                <td>
                    <?php echo strip_tags($row->content); ?>
                        </td>
                        <td><?php echo $row->creator; ?></td>
                        <td>
                    <?php
                            echo JHTML::_('date', $row->created_date, $row->created_date);
                    ?>
                        </td>
                        <td align="center"><?php echo $published; ?></td>
                        <td><?php echo $row->post_id; ?></td>
                        <td><?php echo $row->comment_id; ?></td>

                        <td><?php echo $row->id; ?></td>
                    </tr>
            <?php
                        }
                    }
            ?>
        </tbody>
        <input type="hidden" name="option"
               value="com_ablog" />
        <input type="hidden" name="act"
               value="comment_answers" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="hidemainmenu" value="0" />
    </table>
</form>