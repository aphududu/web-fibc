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
$imgext = 'gif';
?>

<h3><?php echo JText::_('Change Colors')?></h3>

<div class="ja-box-usertools">
  <ul class="ja-usertools-color clearfix">
  <?php
  foreach ($this->_ja_color_themes as $ja_color_theme) {
  	echo "
  	<li><img style=\"cursor: pointer;\" src=\"".$this->templateurl()."/images/".strtolower($ja_color_theme).( ($this->getParam(T3_TOOL_COLOR)==$ja_color_theme) ? "-hilite" : "" ).".".$imgext."\" title=\"".$ja_color_theme." color\" alt=\"".$ja_color_theme." color\" id=\"ja-tool-".$ja_color_theme."color\" onclick=\"switchTool('".$this->template."_".T3_TOOL_COLOR."','$ja_color_theme');return false;\" /></li>
  	";
  } ?>
  </ul>
</div>