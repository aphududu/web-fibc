<?php
/*
# ------------------------------------------------------------------------
# Module JA Facebook Activity for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted accessd');

global $mainframe;


// using setting params
$aParams['site'] 					= 	$params->get( 'site', 'joomlart.com' );
$aParams['width'] 					= 	$params->get( 'width', 300 );
$aParams['height'] 					= 	$params->get( 'height', 400 );
$aParams['header'] 					= 	($params->get( 'header', 1 )) ? 'true' : 'false';
$aParams['colorscheme'] 			= 	$params->get( 'colorscheme', 'light' );
$aParams['font'] 					= 	$params->get( 'font', '' );
$aParams['border_color'] 			= 	$params->get( 'border_color', '' );
$aParams['recommendations'] 		= 	($params->get( 'recommendations', 0 )) ? 'true' : 'false';

$sFacebookQuery = '';
foreach ($aParams as $key => $value) {
	$sFacebookQuery .= "{$key}={$value}&amp;";
}

require( JModuleHelper::getLayoutPath('mod_jafacebookactivity') );
?>