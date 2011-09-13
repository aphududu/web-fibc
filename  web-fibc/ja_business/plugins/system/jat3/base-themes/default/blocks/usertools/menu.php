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
$menus = Array (
	'mega'=>JText::_('Mega Menu'),
	'css'=>JText::_('CSS Menu'),
	'dropline'=>JText::_('Dropline Menu'),
	'split'=>JText::_('Split Menu')	
);
?>

<h3><?php echo JText::_('Menu Style')?></h3>

<div class="ja-box-usertools">
  <ul class="ja-usertools-menu clearfix">
  <?php foreach ($menus as $menu=>$title) : ?>
  
  	<li class="menu-<?php echo $menu.($this->getParam('menu')==$menu?'-active':'') ?>">
  	<input type="radio" id="user_menu_<?php echo $menu ?>" name="user_menu" value="<?php echo $menu ?>" <?php echo $this->getParam('menu')==$menu?'checked="checked"':'' ?> />
  	<label for="user_menu_<?php echo $menu ?>" title="<?php echo $title ?>"><span><?php echo $title ?></span>
  	</label></li>
  <?php endforeach; ?>
  </ul>
</div>
