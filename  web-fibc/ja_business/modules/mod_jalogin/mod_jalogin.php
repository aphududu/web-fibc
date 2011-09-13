<?php
/**
* @version		$Id: mod_login.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$params->def('greeting', 1);

$type 	= modJALoginHelper::getType();
$return	= modJALoginHelper::getReturnURL($params, $type);

$user =& JFactory::getUser();

//Add css
JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/');
if ( is_file(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'css'.DS.$module->module.".css") )
JHTML::stylesheet($module->module.".css",'templates/'.$mainframe->getTemplate().'/css/');
//Add js
JHTML::script( 'script.js','modules/'.$module->module.'/assets/');

require(JModuleHelper::getLayoutPath('mod_jalogin'));