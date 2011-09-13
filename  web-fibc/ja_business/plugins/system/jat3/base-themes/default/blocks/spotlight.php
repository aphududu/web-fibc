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
//$spotlight = array ('user1','user2','user3','user4','user5');
$spotlight = preg_split ('/,/', T3Common::node_data($block));
$name = T3Common::node_attributes($block, 'name');
$special = T3Common::node_attributes($block, 'special');
$specialwidth = T3Common::node_attributes($block, 'specialwidth');
$totalwidth = T3Common::node_attributes($block, 'totalwidth', 100);
$style = $this->getBlockStyle ($block);
$botsl = $this->calSpotlight ($spotlight,$totalwidth, $specialwidth, $special);
if( $botsl ) :
?>

<!-- SPOTLIGHT -->
<?php foreach ($spotlight as $pos): ?>
<?php if( $this->countModules($pos) ): ?>
<div class="ja-box column ja-box<?php echo $botsl[$pos]['class']; ?>" style="width: <?php echo $botsl[$pos]['width']; ?>;">
	<jdoc:include type="modules" name="<?php echo $pos ?>" style="<?php echo $style ?>" />
</div>
<?php endif; ?>
<?php endforeach ?>
<!-- SPOTLIGHT -->

<script type="text/javascript">
	window.addEvent('load', function (){ equalHeight ('#ja-<?php echo $name ?> .ja-box') });
</script>
<?php endif; ?>