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
	<div class="ja-navhelper clearfix">
		<div class="ja-breadcrums clearfix">
			<strong>You are here:</strong> <jdoc:include type="module" name="breadcrumbs" /> 
		</div>
		<div class="ja-links clearfix">
			<?php $this->showBlock('usertools/layout-switcher') ?>
			<a href="<?php echo $this->getCurrentURL();?>#Top" title="Back to Top"><strong>Top</strong></a>
		</div>
	</div>

	<div class="ja-copyright">
		<jdoc:include type="modules" name="footer" />
	</div>