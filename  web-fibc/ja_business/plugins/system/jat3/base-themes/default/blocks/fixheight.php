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
<script type="text/javascript">
	/*fix height for middle area columns*/
	function fixColsHeight () {
		equalHeight (['ja-left', 'ja-main', 'ja-right']);
		fixHeight (['ja-right1', 'ja-right2'], ['ja-right'], ['ja-right-mass-top', 'ja-right-mass-bottom']);
		fixHeight (['ja-left1', 'ja-left2'], ['ja-left'], ['ja-left-mass-top', 'ja-left-mass-bottom']);
		fixHeight (['ja-current-content', 'ja-inset1', 'ja-inset2'],['ja-main'], ['ja-content-mass-top','ja-content-mass-bottom']);
		fixHeight (['ja-content-main'], ['ja-current-content'], ['ja-content-top', 'ja-content-bottom']);
	}
	window.addEvent ('load', function () {
		fixColsHeight.delay (100, this);
	});
</script>