<?php
/*
# ------------------------------------------------------------------------
# JA Retweet plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

$config = new JConfig();
$sef = (int) $config->sef;
$sefRewrite = (int) $config->sef_rewrite;
if(!$sef && !$sefRewrite) {
	JError::raiseNotice(100, JText::_("TWEET PLUGIN WARNING"));
}

include ("japaramhelper.php");
/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementJaparamhelper2 extends JElementJaparamhelper
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Japaramhelper2';
}
?>