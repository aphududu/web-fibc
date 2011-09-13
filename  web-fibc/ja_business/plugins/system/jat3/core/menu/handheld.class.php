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
if (!defined ('_JA_HANDHELD_MENU_CLASS')) {
	define ('_JA_HANDHELD_MENU_CLASS', 1);
	require_once (dirname(__FILE__).DS."base.class.php");

	class JAMenuHandheld extends JAMenuBase{

		function __construct (&$params) {
			parent::__construct($params);

			//To show sub menu on a separated place
			$this->showSeparatedSub = true;
		}

		function beginMenu($startlevel=0, $endlevel = 10){
			echo "<select id=\"handheld-nav\" onchange=\"window.location.href=this.value;\">";
		}
		function endMenu($startlevel=0, $endlevel = 10){
			echo "</select>";
		}

		function beginMenuItem($mitem=null, $level = 0, $pos = ''){
		}
		function endMenuItem($mitem=null, $level = 0, $pos = ''){
		}
		function beginMenuItems($pid=0, $level=0){
		}
		function endMenuItems($pid=0, $level=0){
		}		

		function genMenuItem($item, $level = 0, $pos = '', $ret = 0)
		{
			$tmp = $item;
			
			$space = '---';
			$prespace = '';
			for ($i=0;$i<$level; $i++) $prespace .= $space;
			
			$txt = $prespace . $tmp->name;
			
			if ($tmp->type == 'menulink')
			{
				$menu = &JSite::getMenu();
				$alias_item = clone($menu->getItem($tmp->query['Itemid']));
				if ($alias_item) {
					$tmp->url = $alias_item->link;
				}
			}
			
			$active = in_array($tmp->id, $this->open);
			$selected = $active?"selected=\"selected\"":"";
			$data = "<option ".$selected." value=\"$tmp->url\">$txt</option>";
			
			if ($ret) return $data; else echo $data;
		}
	}
}
?>
