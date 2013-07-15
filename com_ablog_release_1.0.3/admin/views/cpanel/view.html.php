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
 
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class  CpanelViewCpanel  extends JView {
    
    public function display($tpl = null) {
        
        if (JFactory::getUser()->authorise('core.admin', 'com_ablog')){
            JToolBarHelper::preferences('com_ablog');
        }
        
        JHTML::stylesheet('admin.css', 'administrator/components/com_ablog/assets/css/');
        JToolBarHelper::title('ablog', 'blog.png');
        ablogHelper::addSubmenu('cpanel');
        
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        
        $this->showAllVideoPluginActivated();

        parent::display($tpl);
    }

    protected function _quickButton($link, $image, $text, $target, $path) {
        if (empty($path)) {
            $path = 'components/com_ablog/assets/images/';
        }

        if ($target != '') {
            $target = 'target="' . $target . '"';
        }
        ?>        
        <div class="cpanel">
            <div class="icon">
                <a style="padding-bottom: 25px;" href="<?php echo $link; ?>" <?php echo $target; ?>>
                    <?php echo JHTML::_('image.administrator', $image, $path, NULL, NULL, $text); ?>
                    <p><?php echo $text ?></p>
                </a>
            </div>
        </div>
        <?php
    }

    protected function showAllVideoPluginActivated() {
        $allvideo_plugin = JPluginHelper::importPlugin('content', 'jw_allvideos');
        if($allvideo_plugin) {
            return JHtml::_('image', 'administrator/components/com_ablog/assets/images/ok-icon.png', 'accept_icon');
        } else {
           return JHtml::_('image', 'administrator/components/com_ablog/assets/images/no-icon.png', 'all_video_not_installed_image');
        }
    }
}
