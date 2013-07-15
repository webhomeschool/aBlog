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

    <table>
        <tr>
            <td>
                <label for="categorie"><?php echo JText::_('COM_ABLOG_BLOGCATEGORIES_CATEGORY'); ?></label>  
            </td>
            <td>
                <input type="text" id="categorie" name="name" id="categorie" size="25" value="<?php if(isset($this->results)) echo $this->results[0]->name; ?>" />
            </td>
        </tr>   
        <tr>
            <td>
                <label for="published"><?php echo JText::_('COM_ABLOG_PUBLISHED'); ?></label>
            </td>
            <td><?php echo JHTML::_('select.booleanlist', 'published', 'class="inputbox"'); ?>
            </td>
        </tr>
    </table>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="option" value="com_ablog" />
    <input type="hidden" name="act" value="categorie" />
    <input type="hidden" name="hidemainmenu" value="0" />
    <input type="hidden" name="hits" value="0" />
    <input type="hidden" name="post_id" value="0" />
    <input type="hidden" name="id" value="<?php if(isset($this->results)) echo $this->results[0]->id; ?>" />
</form>
