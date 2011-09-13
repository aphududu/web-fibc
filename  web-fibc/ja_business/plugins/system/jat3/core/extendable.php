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

define ('_PHP_', intval (phpversion ()));

if (!function_exists('property_exists')) {
    function property_exists($oObject, $sProperty) {
        if (is_object($oObject)) {
            $oObject = get_class($oObject);
        }
        
        return array_key_exists($sProperty, get_class_vars($oObject));
    }
}

function method_callable($oObject, $sMethod)
{
    // must be object or string
    if (!is_object($oObject) && !is_string($oObject)) {
        return false;
    }
    
    // return
    return array_key_exists($sMethod, array_flip(get_class_methods($oObject)));
}

function make_object_extendable ($classname) {
	if (_PHP_ < 5) {
		overload ($classname);
	}	
}

if (_PHP_ >= 5) {
	require_once (dirname(__FILE__).DS.'object.5.php');
} else {
	require_once (dirname(__FILE__).DS.'object.4.php');
}