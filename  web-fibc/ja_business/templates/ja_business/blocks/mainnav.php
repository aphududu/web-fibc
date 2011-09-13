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
<?php if ($this->hasSubmenu() && ($jamenu = $this->loadMenu())) : ?>
<div class="ja-mainnav-haschild">
<?php endif; ?>

<?php $this->genBlockBegin ($block) ?>
	<?php if (($jamenu = $this->loadMenu())) $jamenu->genMenu (); ?>
	<?php if($this->countModules('search')) : ?>
	<div id="ja-search"><a href="http://joomfans.com" style="display:none;">joomla templates</a>
		<jdoc:include type="modules" name="search" />
	</div>
	<?php endif; ?>
<?php $this->genBlockEnd ($block) ?>

<!-- jdoc:include type="menu" level="0" / -->
<?php if ($this->hasSubmenu() && ($jamenu = $this->loadMenu())) : ?>
<div id="ja-subnav" class="wrap">
<div class="main clearfix">
<?php $jamenu->genMenu (1); ?>
<!-- jdoc:include type="menu" level="1" / -->
</div>
</div>
<?php endif;?>

<?php if ($this->hasSubmenu() && ($jamenu = $this->loadMenu())) : ?>
</div>
<?php endif; ?>

<ul class="no-display">
    <li><a href="<?php echo $this->getCurrentURL();?>#ja-content" title="<?php echo JText::_("Skip to content");?>"><?php echo JText::_("Skip to content");?></a></li>
</ul>
