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
JHTML::_('behavior.mootools');
?>
<form action="#" method="post">
    <table class="adminform">
        <tr>
            <td style="width:630px;">
                <?php
                $this->_quickButton('index.php?option=com_ablog&act=cpanel', 'cpanel/cpanel1.png', 'cpanel', $target = '', $path = '');
                $this->_quickButton('index.php?option=com_ablog&act=blog_categories', 'categories/categorie1.png', 'blog categories', $target = '', $path = '');
                $this->_quickButton('index.php?option=com_ablog&act=posts', 'posts/post1.png', 'posts', $target = '', $path = '');
                $this->_quickButton('index.php?option=com_ablog&act=comments', 'comments/comments.png', 'comments', $target = '', $path = '');
                $this->_quickButton('index.php?option=com_ablog&act=comment_answers', 'comment_answers/comment_answers.png', 'comment answers', $target = '', $path = '');
                ?>
            </td>
            <td>
                <div id="boxes">
                    <div class="infobox">
                        <h2>A short introduction:</h2>
                        <h3>The Frontend:</h3>
                        <ul>
                            <li>The first item you see in the front-end is the blog home-button.</li>
                            <li>All Posts are shown under the Home button, if there are any published.</li>
                            <li>You can determine how the kategorie menu looks like within the option button</li>
                            <li>If the plugin all_videos is installed you can use it to import videos into your blog messages.</li>
                            <li>The status bar shows you if the all_video plugin is installed an activated.</li>
                        </ul>
                    </div>
                    <div class="infobox">
                        <h3>Support:</h3>
                        <ul>
                            <li>This component was created by <a href="http://www.webhomeschool.de">www.webhomeschool.de</a></li>
                        </ul>

                        <?php echo JHtml::_('image', 'administrator/components/com_ablog/assets/images/webhomeschool_logo.png', 'webhomeschoollogo'); ?>
                    </div>
                    <div style="margin-top: 5px;">
                        <h3 style="margin-bottom: 5px;">If you like ABlog, then support it!</h3>
                    </div>
                    <div id="paypal_send" onclick="paysend()">                        
                        <img style="border: 1px solid #ccc; padding: 2px;" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" />
                    </div>
                </div>
            </td>
            <td style="width: 250px;">
                <?php
                echo JHTML::_('tabs.start', 'info_status');
                echo JHTML::_('tabs.panel', 'Status', 'status_tab_head', array('useCookie' => 1));
                ?>
                <table>
                    <tr>
                        <td>AllVideo Plugin</td>
                        <td><?php echo $this->showAllVideoPluginActivated(); ?></td>
                    </tr>
                </table>
                <?php
                echo JHTML::_('tabs.end');
                ?>
            </td>
        </tr>
    </table>
</form> 
 <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="E88BWYXHTRU5U">
 </form>
<script type="text/javascript" />
    function paysend() {
          document.forms[0].onsubmit = false;
          document.forms[1].action;
          document.forms[1].submit();
    }
</script>