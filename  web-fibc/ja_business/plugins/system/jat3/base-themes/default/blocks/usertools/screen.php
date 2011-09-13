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
$screens = Array ('wide'=>JText::_('Wide Screen'),'auto'=>JText::_('Full Screen'),'narrow'=>JText::_('Narrow Screen'));
?>

<h3><?php echo JText::_('Screen')?></h3>

<div class="ja-box-usertools">
  <ul class="ja-usertools-screen clearfix">
  <?php foreach ($screens as $screen=>$title) : ?>
  
  	<li class="screen-<?php echo $screen.($this->getParam('screen')==$screen?'-active':'') ?>">
  	<input type="radio" id="user_screen_<?php echo $screen ?>" name="user_screen" value="<?php echo $screen ?>" <?php echo $this->getParam('screen')==$screen?'checked="checked"':'' ?> />
  	<label for="user_screen_<?php echo $screen ?>" title="<?php echo $title ?>"><span><?php echo $title ?></span>
  	</label></li>
  <?php endforeach; ?>
  </ul>
</div>
