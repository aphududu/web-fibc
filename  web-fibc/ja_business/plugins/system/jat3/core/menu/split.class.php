<?php
/*
# ------------------------------------------------------------------------
# JA T3v2 Plugin - Template framework for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - GNU/GPL V2, http://www.gnu.org/licenses/gpl2.html. For details 
# on licensing, Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

defined( '_VALID_MOS' ) or defined('_JEXEC') or die('Restricted access');
if (!defined ('_JA_SPLIT_MENU_CLASS')) {
	define ('_JA_SPLIT_MENU_CLASS', 1);
	require_once (dirname(__FILE__).DS."base.class.php");

	class JAMenuSplit extends JAMenuBase{

		function __construct (&$params) {
			parent::__construct($params);

			//To show sub menu on a separated place
			$this->showSeparatedSub = true;
		}

		function beginMenu($startlevel=0, $endlevel = 10){
			if ($startlevel == 0) {
				echo "<div id=\"ja-splitmenu\" class=\"mainlevel clearfix\">\n";
			} else {
				echo "<div class=\"sublevel\">\n";
			}
		}
		function endMenu($startlevel=0, $endlevel = 10){
			echo "\n</div>";
		}
		function beginMenuItems($pid=0, $level=0){
			if ($level == 1)
				echo "<ul class=\"active\">";
			else
				echo "<ul>";
		}
		function genMenu($startlevel=0, $endlevel = 10){
			if ($startlevel == 0) parent::genMenu(0,0);
			else parent::genMenu($startlevel, $endlevel);
		}

	}
}
?>
