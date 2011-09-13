<?php
/*
# ------------------------------------------------------------------------
# JA Top Panel module
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
require_once (dirname ( __FILE__ ) . DS . 'helper.php');

$helper = new modJaToppanelHelper ();

$module_content = $helper->_load ($params);

$show_button_close = $params->get('close', 1);
$show_dontshowagain = $params->get('dontshowagain', 0);
$transparent = $params->get('transparent', 1);
$auto_open = $params->get('auto', 0);
$overlay = $params->get('overlay', 0);
$duration = $params->get('duration', 0);
$delay = $params->get('delay', 0);
$howmanytimes = $params->get('howmanytimes', -1);
$cookie_suffix = $params->get('cookie_suffix', 'jatoppanel_');

if(isset($_COOKIE[$cookie_suffix.'dontshowagain'.$module->id]) && $_COOKIE[$cookie_suffix.'dontshowagain'.$module->id]){
	return;
}
if($howmanytimes>=0 && $auto_open){	
	$manytimes = 0;
	if(isset($_COOKIE[$cookie_suffix.'howmanytimes'.$module->id])){
		$manytimes = (int) $_COOKIE[$cookie_suffix.'howmanytimes'.$module->id];
	}
	if($manytimes>=$howmanytimes){
		$auto_open = 0;
	}
	setcookie($cookie_suffix.'howmanytimes'.$module->id, $manytimes+1);
}

if (!defined ('_MODE_JATOPPANEL_ASSETS_')) {
	define ('_MODE_JATOPPANEL_ASSETS_', 1);
	
	JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/');
	JHTML::script("script.js",'modules/'.$module->module.'/assets/');
	
	if (is_file(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'css'.DS.$module->module.".css"))
		JHTML::stylesheet($module->module.".css",'templates/'.$mainframe->getTemplate().'/css/');
}

$path = JModuleHelper::getLayoutPath ( $module->module, 'default' );
if (file_exists ( $path )) {
	require ($path);
}

?>