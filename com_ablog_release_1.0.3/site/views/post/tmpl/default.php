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
jimport('joomla.utilities.date');
//Params for Styles
$params = JComponentHelper::getParams('com_ablog');
//post container
$container_padding = $params->get("ablog_post_container_padding");
$container_border = $params->get("ablog_post_container_border");
$container_corners = $params->get("ablog_post_container_corners");
$title_color = $params->get("ablog_post_title_color");
$title_size = $params->get("ablog_post_title_size");
$text_color = $params->get("ablog_post_text_color");
$text_size = $params->get("ablog_post_text_size");
$text_weight = $params->get("ablog_post_text_weight");
//comment container
$comment_text_color = $params->get("ablog_post_comment_text_color");
$comment_text_size = $params->get("ablog_post_comment_text_size");
$comment_line_color = $params->get("ablog_post_comment_line_color");

//form styles
$form_background_color = $params->get('ablog_form_background');
$form_message1_color = $params->get('ablog_form_message1_color');
$form_message1_font_size = $params->get('ablog_form_message1_font_size');
$form_message2_color = $params->get('ablog_form_message2_color');
$form_message2_font_size = $params->get('ablog_form_message2_font_size');
$form_color_label = $params->get('ablog_form_color_label');
$form_label_font_size = $params->get('ablog_form_font_size_label');
$form_input_focus = $params->get('ablog_form_input_focus');
$form_button_color = $params->get('ablog_form_button_color');
$form_button_color_font_size = $params->get('ablog_form_button_font_size');
$form_button_background_color = $params->get('ablog_form_button_background_color');

$post_styles = "div#post{
                    padding:" . $container_padding . ";" .
        "color:" . $text_color . ";" .
        "border:" . $container_border . " solid black;" .
        "border-radius:" . $container_corners . ";" .
        "font-size:" . $text_size . ";" .
        "font-weight:" . $text_weight .
        "}" .
        "div#post h2{
                    color:" . $title_color . ";" .
        "font-size:" . $title_size . ";" .
        ";}" .
        $comment_styles = "div.comments{
                       color:" . $comment_text_color . ";" .
        "font-size:" . $comment_text_size . ";" .
        "}" .
        "p.answer a{
                       color:" . $comment_text_color . ";" .
        "}" .
        ".content, .comments_inner{
                       border-color:" . $comment_line_color . ";" .
        "}";
$form_styles = "#ablog_content_post #form{
                    background:" . $form_background_color . ";" .
        "}" .
        "#form strong{
                    color:" . $form_message1_color . ";" .
        "font-size:" . $form_message1_font_size . ";" .
        "}" .
        "#form em{
                    color:" . $form_message2_color . ";" .
        "font_size:" . $form_message2_font_size . ";" .
        "}" .
        "#form label{
                    color:" . $form_color_label . ";" .
        "font-size:" . $form_label_font_size . ";" .
        "}" .
        "#form input:focus, #form textarea:focus{
                    border:" . $form_input_focus . ";" .
        "}" .
        "#form button{
                    color:" . $form_button_color . ";" .
        "font-size:" . $form_button_color_font_size . ";" .
        "background:" . $form_button_background_color . ";" .
        "}";

$styles = $post_styles . ' ' . $comment_styles . ' ' . $form_styles;
$date = new JDate();
$document = JFactory::getDocument();
$document->addStyleDeclaration($styles);
$params = JComponentHelper::getParams('com_ablog');
$posts_ablog_created_date = $params->get('ablog_posts_created_date');
?>
<div id="ablog_content_post">
    <div class="social_media">
        <div class="my_comments">
<?php echo '<a href="index.php?option=com_ablog&view=post&task=post&id=' . JRequest::getCmd('id') . '#form_position">' . JHtml::_('image', 'components/com_ablog/assets/images/icon-16-speaker.png', 'comment_image', 'class=comment_image') . "</a>"; ?>
        </div>
        <div class="fb-root">
            <script>
                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id))
                        return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>

            <div class="fb-like" data-href="http://www.webhomeschool.de" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
        </div>
        <div class="twitter">
            <a href="https://twitter.com/share" class="twitter-share-button" data-text="webhomeschool.de" data-lang="de">Twittern</a>
            <script>!function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");</script>
        </div>
        <div class="google">
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-annotation="inline" data-width="300"></div>

            <!-- Place this tag after the last +1 button tag. -->
            <script type="text/javascript">
                window.___gcfg = {lang: 'de'};

                (function() {
                    var po = document.createElement('script');
                    po.type = 'text/javascript';
                    po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(po, s);
                })();
            </script>
        </div>
    </div>


    <div id="post">    
        <h2><?php echo $this->result_post->title; ?></h2>
        <p><?php if($posts_ablog_created_date) {echo JText::_('COM_ABLOG_POST_FROM') . ': ' . $this->result_post->creator . JText::_('COM_ABLOG_POST_ON') . ': ' . $this->result_post->created_date . $this->showHits();} ?></p>
        <div><?php echo $this->result_post->content; ?></div>
        <form method="post" action="<?php echo JRoute::_('index.php'); ?>">
            <button style="background: <?php echo $form_button_background_color ?>" >Back</button>
        </form>
    </div>



<?php
$i = 1;
if ($this->result_comments) {
    ?>
        <?php foreach ($this->result_comments as $comment) {
            ?>
            <div class="comments">
                <h3><?php echo $i++ . ' ' . JText::_('COM_ABLOG_POST_COMMENTS') . ' ' . JText::_('COM_ABLOG_POST_FOR') . ' ' . $this->result_post->title; ?></h3>
                <div class="comments_inner">
                    <div class="personal_data">
                        <p><?php echo $this->cleanInput($comment->creator); ?></p>
                        <p><?php echo $comment->created_date; ?></p>
                    </div>
                    <div>
                        <div><?php echo $comment->content; ?></div>
                        <p class="answer"><a href="index.php?option=com_ablog&task=post&id=<?php echo JRequest::getCmd('id') . '&cat=' . $comment->id . '#form_position'; ?>" >Answer</a></p>
                    </div>
                </div>
        <?php if ($this->getCommentAnswersForView($this->result_post->id, $comment->id)) { ?>
            <?php foreach ($this->getCommentAnswersForView($this->result_post->id, $comment->id) as $comment_answer) { ?>    
                        <div class="comment_answers">
                            <div class="personal_data">
                                <p><?php echo $this->cleanInput($comment_answer->creator); ?></p>
                                <p><?php echo $this->cleanInput($comment_answer->created_date); ?></p>
                            </div>                   
                            <p><?php echo $comment_answer->content; ?></p>
                            <br class="clearfloat" />
                        </div>    
            <?php } ?>
        <?php } ?>
            </div>
        <?php
    }
}
?>

    <div id="form">
    <?php
    if (JRequest::getCmd('cat')) {
        $link_form = JRoute::_('index.php?option=com_ablog&amp;task=save_comment_answers&amp;id=' . JRequest::getCmd('id') . '&amp;cat=' . $comment->id);
    } else {
        $link_form = JRoute::_('index.php?option=com_ablog&amp;task=save_comment&amp;id=' . JRequest::getCmd('id'));
    }
    ?>
        <form method="post" action="<?php echo $link_form ?>" name="adminForm">  

            <table id="form_table">
                <tr>
                    <td>
                        <strong id="form_position"><?php echo JText::_('COM_ABLOG_POST_LEAVE_A_MESSAGE'); ?></strong>
                        <p><em><?php echo JText::_('COM_ABLOG_EMAIL_NOT_PUBLISHED'); ?></em></p>
                    </td>
                </tr>
                <tr>
                    <td class="td_class">
                        <label for="creator">Creator</label>
                    </td>
                </tr>
                <tr>
                    <td class="td_class">
                        <input type="text" id="creator" name="creator" />
                    </td>
                </tr>
                <tr>
                    <td class="td_class">
                        <label for="email_adress">EmailAdress</label>
                    </td>
                </tr>
                <tr>
                    <td class="td_class">
                        <input type="text" id="email_adress" name="email_adress" />
                    </td>
                </tr>
                <tr>
                    <td class="td_class">
                        <label for="content">Content</label>
                    </td>
                </tr>
                <tr>
                    <td class="td_class">
                        <textarea cols="30" rows="7" id="content" name="content"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="td_class">
                        <button type="submit">Post Comment</button>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="created_date" value="<?php echo $date->toMysql(); ?>" />
            <input type="hidden" name="post_id" value="<?php echo $this->result_post->id; ?>" />
            <input type="hidden" name="comment_id" value="<?php echo JRequest::getCmd('cat'); ?>" />
            <input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
        </form>
    </div>
    <noscript>
    Javascript should be on for the full functionality
    </noscript>
</div>