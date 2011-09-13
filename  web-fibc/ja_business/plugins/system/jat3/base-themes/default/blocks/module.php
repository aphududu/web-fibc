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
?>
<?php
$modules = preg_split ('/,/', T3Common::node_data($block));
$parent = T3Common::node_attributes ($block, 'parent', 'middle');
$style = $this->getBlockStyle ($block, $parent);
if (!$this->countModules (T3Common::node_data($block))) return;
?>
<?php foreach ($modules as $module) : 
	if ($this->countModules($module)) : 
	?>
		<jdoc:include type="module" name="<?php echo $module ?>" style="<?php echo $style ?>" />		
<?php endif; 
endforeach ?>
