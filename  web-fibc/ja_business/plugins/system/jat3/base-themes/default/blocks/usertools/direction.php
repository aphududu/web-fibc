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
$directions = Array ('ltr'=>JText::_('LTR'),'rtl'=>JText::_('RTL'));
?>

<h3><?php echo JText::_('Direction')?></h3>

<div class="ja-box-usertools">
  <ul class="ja-usertools-direction clearfix">
  <?php foreach ($directions as $direction=>$title) : ?>
  
  	<li class="direction-<?php echo $direction.($this->getParam('direction')==$direction?'-active':'') ?>">
  	<input type="radio" id="user_direction_<?php echo $direction ?>" name="user_direction" value="<?php echo $direction ?>" <?php echo $this->getParam('direction')==$direction?'checked="checked"':'' ?> />
  	<label for="user_direction_<?php echo $direction ?>" title="<?php echo $title ?>"><span><?php echo $title ?></span>
  	</label></li>
  <?php endforeach; ?>
  </ul>
</div>
