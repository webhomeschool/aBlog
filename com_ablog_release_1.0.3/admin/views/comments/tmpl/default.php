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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
?>
<form action="index.php" method="post" name="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo JRequest::getVar('search_word', ''); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />

            <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
               <select name="filter_post_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo '-SelectPostId-'; ?></option>
                <?php echo JHtml::_('select.options', $this->getSelectFieldsValues('post_id'), 'value', 'text', $this->selectedFieldValue('post_id'), true); ?>
               </select>
             <select name="filter_date" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo '-Select Date-'; ?></option>
                <?php echo JHtml::_('select.options', $this->getSelectFieldsValues('created_date'), 'value', 'text', $this->selectedFieldValue('date'), true); ?>
             </select>
             <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
                <?php echo JHtml::_('select.options', array('unpublished','published'), 'value', 'text', $this->selectedFieldValue('published'), true); ?>
            </select>
            <select name="filter_author" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_AUTHOR'); ?></option>
                 <?php echo JHtml::_('select.options', $this->getSelectFieldsValues('creator'),'value', 'text', $this->selectedFieldValue('author'));?>
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
                       <th width="10"><?php echo JText::_('ID'); ?></th>
                   </tr>
               </thead>
               <tbody>
            <?php
            
                           foreach ($this->results as $key => $row) {
                               $checked = JHTML::_('grid.id', $key, $row->id);
                               $published = JHTML::_('grid.published', $row, $key);
                               $link = JRoute::_('index.php?option='
                                               . JRequest::getVar('option')
                                               . '&task=edit&cid[]=' . $key
                                               . '&hidemainmenu=1');
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


                           <td><?php echo $row->id; ?></td>
                       </tr>
            <?php
                           }
            ?>
        </tbody>

        <input type="hidden" name="option" value="com_ablog" />
        <input type="hidden" name="act" value="comments" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="hidemainmenu" value="0" />
    </table>
</form>
