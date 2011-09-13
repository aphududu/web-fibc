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
define ('T3_ACTIVE_TEMPLATE', T3Common::get_active_template());
define ('T3_BASE', 'plugins/system/jat3');
define ('T3_CORE', T3_BASE.'/core');
define ('T3_BASETHEME', T3_BASE.'/base-themes/default');
define ('T3_TEMPLATE', 'templates/'.T3_ACTIVE_TEMPLATE);
define ('T3_TEMPLATE_CORE', 'templates/'.T3_ACTIVE_TEMPLATE.'/core');
define ('T3_TEMPLATE_LOCAL', 'templates/'.T3_ACTIVE_TEMPLATE.'/local');

define ('T3_TOOL_COLOR', 'color');
define ('T3_TOOL_SCREEN', 'screen');
define ('T3_TOOL_FONT', 'font');
define ('T3_TOOL_MENU', 'menu');
define ('T3_TOOL_THEMES', 'themes');
define ('T3_TOOL_LAYOUTS', 'layouts');
?>