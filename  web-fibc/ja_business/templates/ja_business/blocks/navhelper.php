<?php
/*
# ------------------------------------------------------------------------
# JA Business Template
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
?>
<?php
//detect view on mobile - show switch to mobile tools
$layout_switcher = $this->loadBlock('usertools/layout-switcher');
if ($layout_switcher) {
	$layout_switcher = '<li class="layout-switcher">'.$layout_switcher.'</li>';
}
?>

<?php if($this->countModules('breadcrumb')) : ?>
	<jdoc:include type="modules" name="breadcrumb" />
<?php endif; ?> 

<ul class="ja-links">
	<?php echo $layout_switcher ?>
	<li class="top"><a href="<?php echo $this->getCurrentURL();?>#Top" title="Back to Top"><?php echo JText::_('Top') ?></a></li>
</ul>

<?php if($this->countModules('bottombar')) : ?>
<div id="ja-bottombar">
	<jdoc:include type="modules" name="bottombar" />
</div>
<?php endif; ?>