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
    <table class="adminlist">
        <thead>
            <tr>
                <th width="25">#</th>
                <th width="25">
                    <input type="checkbox"
                           name="checkall-toggle"
                           value="" onclick="Joomla.checkAll(this)" />
                </th>
                <th><?php echo JText::_('COM_ABLOG_BLOGCATEGORIES_CATEGORY'); ?></th>
                <th width="60">
                    <?php echo JText::_('COM_ABLOG_PUBLISHED'); ?>
                </th>
                <th width="25"><?php echo JText::_('ID'); ?></th>
            </tr>
        </thead>
        <tbody>
           
            <?php
            if($this->results) {
                foreach ($this->results as $i => $row) {
                   
                    $checked = JHTML::_('grid.id', $i + 1, $row->id);
                
                    $published = JHtml::_('jgrid.published', $row->published, $i + 1);
                    $link_id = $row->id;
                    $link = JRoute::_('index.php?option=com_ablog&act=blog_categories&task=edit&cid=' . $link_id);
                    ?>
                    <tr>
                        <td> <?php echo $i + 1 ?> </td>
                        <td><?php echo $checked; ?></td>
                        <td>
                            <a href="<?php echo $link; ?>">
                                <?php echo $row->name; ?>
                            </a>
                        </td>
                        <td style="text-align: center;"><?php echo $published; ?></td>
                        <td><?php echo $row->id; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
        <input type="hidden" name="option" value="com_ablog" />
        <input type="hidden" name="act" value="blog_categories" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="hidemainmenu" value="0" />
        <input type="hidden" name="hidemainmenu" value="0" />
    </table>
</form>
