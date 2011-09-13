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
	<?php $this->genBlockBegin ($block) ?>
	<?php
	$app = & JFactory::getApplication();
	$siteName = $app->getCfg('sitename');
	if ($this->getParam('logoType', 'image')=='image'): ?>
	<h1 class="logo">
		<a href="index.php" title="<?php echo $siteName; ?>"><span><?php echo $siteName; ?></span></a>
	</h1>
	<?php else:
	$logoText = (trim($this->getParam('logoText'))=='') ? $siteName : JText::_(trim($this->getParam('logoText')));
	$sloganText = JText::_(trim($this->getParam('sloganText'))); ?>
	<div class="logo-text">
		<h1><a href="index.php" title="<?php echo $siteName; ?>"><span><?php echo $logoText; ?></span></a></h1>
		<p class="site-slogan"><?php echo $sloganText;?></p>
	</div>
	<?php endif; ?>
	<?php if($this->countModules('header')) : ?>
	<div id="ja-topheader" class="clearfix">
		<jdoc:include type="modules" name="header" />
	</div>
	<?php endif; ?>			
	<?php $this->genBlockEnd ($block) ?>