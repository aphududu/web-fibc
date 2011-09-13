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
$layouts = T3Common::get_layouts ();
$currlayouts = preg_split('/,/', $this->getParam('layouts'));
if (count ($layouts) < 2) return;
?>

<h3><?php echo JText::_('Layout')?></h3>

<div class="ja-box-usertools">
  <ul class="ja-usertools-layout clearfix">
  <?php foreach ($layouts as $layout) : 
	if (preg_match ('#-rtl$#', $layout)) continue;
  ?>
  	<li class="layout layout-<?php echo str_replace('.','-',$layout).(in_array($layout, $currlayouts)?'-active':'') ?>">
  	<input type="radio" id="user_layouts_<?php echo $layout ?>" name="user_layouts" value="<?php echo $layout ?>" <?php echo in_array($layout, $currlayouts)?'checked="checked"':'' ?> />
  	<label for="user_layouts_<?php echo $layout ?>" title="<?php echo $layout ?>"><span><?php echo $layout ?></span>
  	</label></li>	
  <?php endforeach; ?>
  </ul>
</div>