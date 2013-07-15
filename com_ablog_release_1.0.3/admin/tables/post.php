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
// Don't allow direct linking
defined( '_JEXEC' ) or die( 'Restricted access' );

class TablePost extends JTable  {
	/** @var int Primary key*/
	public $id = '';        
        /** @var string */
        public $title = '';
        /** @var text*/
        public $content = '';
        /** @var int */
        public $checked_out = 1;
        /** @var datetime */
        public $checked_out_time = '';
        /** @var int */
        public $published = 0;
        /** @var int */
        public $ordering = 0;
        /** @var datetime */
        public $created_date = '';
        /** @var int */
        public $hits = 0;
        /** @var varchar */
        public $creator = '';
        /** @var int */
        public $categorie_id = 0;
        /** @var string */
        public $creator_username = '';
       
                
	public function __construct( &$_db ) {
		parent::__construct( '#__ablog_posts', 'id', $_db );
                $date = JFactory::getDate();
		$this->created_date = $date->toSql();
	}

        public function check() {
            if($this->title != '') {
                return true;
            }
            if($this->ablog_post_content != '') {
                $this->content = $this->ablog_post_content;
                return true;
            }
            return false;
        }
}
?>
