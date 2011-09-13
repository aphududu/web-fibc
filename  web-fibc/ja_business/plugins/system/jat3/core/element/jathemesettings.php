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

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementJAthemesettings extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Modules';

	function fetchElement( $name, $value, &$node, $control_name ) {
		t3_import('core/admin/util');
		
		if (!defined ('_JA_THEME')) {
			define ('_JA_THEME', 1);			
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
			$uri = str_replace("/administrator", "", $uri);
			JHTML::stylesheet('jathemesettings.css', $uri."/assets/css/");
			JHTML::script('jathemesettings.js', $uri."/assets/js/");			
		}
		
		$objutil = new JAT3_AdminUtil();
		$template  = $objutil->get_active_template();
		$themes = $objutil->getThemes($template);
		
		if($value && $themes){
			if( ( !isset($themes['core']) || (isset($themes['core']) && !in_array($value, $themes['core']))) && ( !isset($themes['local']) || ( isset($themes['local']) && !in_array($value, $themes['local']))) ){ 			
				$value = isset($themes['local'])?$themes['local'][0]:$themes['core'][0];
			}
		}
		
		$layout = dirname(__FILE__).DS.'tmpl'.DS.'jathemesettings.php';
		if (file_exists($layout)) {
			ob_start();
			require $layout;
			$content = ob_get_clean();
			return $content;
		}
		return '';
	}
			
} 