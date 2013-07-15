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


$params = JComponentHelper::getParams('com_ablog');
$menu_color = $params->get('ablog_menu_color');
$menu_textcolor = $params->get('ablog_menu_text_color');
$menu_text_size = $params->get('ablog_menu_fontsize');
$menu_text_weight = $params->get('ablog_menu_text_weight');
$menu_height = $params->get('ablog_menu_height');
$menu_border_weight = $params->get('ablog_menu_border_weight');
$menu_border_color = $params->get('ablog_menu_border_color');
$menu_border_style = $params->get('ablog_menu_border_style');
$menu_border_radius = $params->get('ablog_menu_border_radius');
$menu_buttons_margin = $params->get('ablog_menu_li_margin');
$menu_buttons_padding = $params->get('ablog_menu_li_padding');
$menu_fontsize = $params->get('ablog_menu_fontsize');
$menu_width = $params->get('ablog_menu_width');
$menu_active_button_color = $params->get('ablog_menu_active_color');
$media_image = $params->get('ablog_menu_image');
$menu_image_width = $params->get('ablog_menu_image_width');

$posts_text_color = $params->get('ablog_text_color');
$posts_ablog_border_weight = $params->get('ablog_posts_border_weight');
$posts_ablog_border_style = $params->get('ablog_posts_border_style');
$posts_ablog_border_color = $params->get('ablog_posts_border_color');
$posts_ablog_background = $params->get('ablog_posts_background');
$posts_ablog_padding = $params->get('ablog_posts_padding');
$posts_ablog_border_radius = $params->get('ablog_posts_border_radius');
$posts_ablog_width = $params->get('ablog_posts_width');
//$posts_ablog_social_border_radius = $params->get('ablog_social_border_radius');
$posts_ablog_social_background_color = $params->get('ablog_social_background_color');
$posts_ablog_social_border_weight = $params->get('ablog_social_border_weight');
$posts_ablog_social_border_style = $params->get('ablog_social_border_style');
$posts_ablog_social_border_color = $params->get('ablog_social_border_color');
$posts_ablog_social_padding = $params->get('ablog_social_padding');
$posts_ablog_social_border_radius = $params->get('ablog_social_border_radius');
$posts_ablog_created_date = $params->get('ablog_posts_created_date');

if ($menu_text_weight == '1') {
    $text_weight = 'bold';
} else {
    $text_weight = 'normal';
}

if ($media_image != '') {
    if (JRequest::getVar('id')) {
        $image_path = '../../../../';
    } else {
        $image_path = '../';
    }
    $image_path =
            $media_image = '#main_ablog #ablog_menu a#menu_image{
                       background: url(' . $image_path . $media_image . ') no-repeat center;
                       height:' . $menu_height . ';' .
            'width:' . $menu_image_width . ';' .
            '}';
} else {
    $media_image = '';
}

$content_background = $params->get('ablog_content_background');
$content_color = $params->get('ablog_text_color');
$content_h2_color_link = $params->get('ablog_h2_color_link');
$content_h2_color_hover = $params->get('ablog_h2_color_hover');
$content_h2_hover_background = $params->get('ablog_h2_hover_background_color');
$document = JFactory::getDocument();

$styles_menu = '#main_ablog ul#ablog_menu li a{                
                    width:' . $menu_width . ';' .
        'color:' . $menu_textcolor . ';' .
        'font-weight:' . $text_weight . ';' .
        'text-decoration: none;' .
        'background-color:' . $menu_color . ';' .
        'padding: 0 ' . $menu_buttons_padding . ';' .
        'margin-right: ' . $menu_buttons_margin . ';' .
        'font-size:' . $menu_fontsize . ';' .
        'height:' . $menu_height . ';' .
        'line-height: ' . $menu_height . ';' .
        'text-align: center' . ';' .
        '}' . $posts_ablog_border_color . ';' .
        '#main_ablog ul#ablog_menu li a{
                      border-left-width: 0px;
                      border-top-width:' . $menu_border_weight . ';' .
        'border-bottom-width:' . $menu_border_weight . ';' .
        'border-right-width:' . $menu_border_weight . ';' .
        'border-style:' . $menu_border_style . ';' .
        'border-color:' . $menu_border_color . ';' .
        '}' .
        '#main_ablog ul#ablog_menu #menu_image{
                     border-left-width:' . $menu_border_weight . ';' .
        'border-style:' . $menu_border_style . ';' .
        'border-color:' . $menu_border_color . ';' .
        '}' .
        '#main_ablog ul#ablog_menu li {
                    height:' . $menu_height .
        '}' .
        '#main_ablog ul#ablog_menu li a#active_menu{
                     background-color:' . $menu_active_button_color . ';' .
        '}';

$styles_content = '#main_ablog .ablog_content_container .main {' .
        'background:' . $posts_ablog_background . ';' .
        'border-width:' . $posts_ablog_border_weight . ';' .
        'border-style:' . $posts_ablog_border_style . ';' .
        'border-color:' . $posts_ablog_border_color . ';' .
        'border-radius:' . $posts_ablog_border_radius . ';' .
        'padding:' . $posts_ablog_padding . ';' .
        'width:' . $posts_ablog_width . ';' .
        '}' .
        '#main_ablog div.main a {' .
        'color:' . $posts_text_color . ';' .
        '}' .
        '#main_ablog div.main h2 a
                   {
                        color:' . $content_h2_color_link . ';' .
        '}' .
        '#main_ablog div.main h2 a:link,
                   #main_container_ablog .main_ablog .main h2 a:visited {
                        color:' . $content_h2_color_link . ';' .
        '}' .
        '#main_ablog div.main h2 a:hover,
                    #main_ablog .main_ablog .main h2 a:active {
                        background: ' . $content_h2_hover_background . ';' .
        'color:' . $content_h2_color_hover . ';' .
        '}';
$styles_social_media = '#main_ablog .ablog_content_container .social_media {' .
        'border-width:' . $posts_ablog_social_border_weight . ';' .
        'border-style:' . $posts_ablog_social_border_style . ';' .
        'border-color:' . $posts_ablog_social_border_color . ';' .
        'padding:' . $posts_ablog_social_padding . ';' .
        'background:' . $posts_ablog_social_background_color . ';' .
        'border-radius:' . $posts_ablog_social_border_radius . ';' .
        '}';
$styles = $styles_menu . ' ' . $styles_content . ' ' . $styles_social_media . ' ' . $media_image;
$document->addStyleDeclaration($styles);
?>
<div id="main_ablog">    
    <ul id="ablog_menu">
        <li class="menu_image">
            <a id="menu_image" class="no_border" href="<?php echo JRoute::_('index.php?option=com_ablog'); ?>"></a>
        </li>
        <?php
//Check if ActiveId is there

        
        if(isset($this->categories)):
        ?>  
        <?php foreach ($this->categories as $categories) {
            ?>
            <li>                   
                <?php echo $this->createMenuLink(JRequest::getCmd('id'), $categories) ?>
            </li>
        <?php } 
        endif;
        ?>
    </ul>
    <br style="clear: both; height: 0;" />
    <input type="hidden" name="cat_id" value="" />


    <?php 
    if(isset($this->posts)):
      foreach ($this->posts as $post): ?>
        <div class="ablog_content_container">

            <div class="social_media">
                <div class="fb-root"> 
                    <div class="fb-like" data-href="http://www.webhomeschool.de" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
                </div>
           
                <div class="twitter">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-text="webhomeschool.de" data-lang="de"></a>                  
                </div>
               
                <div class="google">                
                    <div class="g-plusone" data-annotation="bubble" align="right" data-width="300"></div>                                   
                </div>
             
            </div>

            <div class="main">
                <h2><a href="<?php echo JRoute::_('index.php?option=com_ablog&amp;view=post&amp;task=post&amp;id=' . $post->id); ?>"><?php echo $post->title; ?></a></h2>
                <p class="first_main_p"><?php if($posts_ablog_created_date == '1')  { echo JText::_('COM_ABLOG_POSTS_FROM') . ': ' . $post->creator_username . ' ' . JText::_('COM_ABLOG_POSTS_ON') . ': ' . $post->created_date;}?></p>
                <div><?php echo $post->content; ?></div>
            </div>
            <br style='clear: both; height: 0;' />
            
        </div><!--ablog content container-->
    <?php endforeach; 
        endif;
    ?>
    <script type="text/javascript">
        if(!document.getElementById('player')){
            $video_prozess_image = '<div><img src=""></div>';
        }
        function facebook() {
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        }
        window.setTimeout("facebook()", 100);


        function google() {
            window.___gcfg = {lang: 'de'};

            (function() {
                var po = document.createElement('script');
                po.type = 'text/javascript';
                po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(po, s);
            })();
        }
        window.setTimeout("google()", 2500);


        function twitter() {
            !function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");
        }
        window.setTimeout("twitter()", 1500);
    </script>

    <div id="ablog_pagination">
        <?php echo $this->getPagination(); ?>
    </div><!--end pagination-->
    <noscript>Javascript should be on for the full functionality</noscript>
</div><!--end mainblog-->