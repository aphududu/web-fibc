<?php
/*
# ------------------------------------------------------------------------
# JA Top Panel module
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/
$modulename = 'ja-toppanel-mainwrap'.rand();
?>
<script type="text/javascript">
	window.addEvent('load', function(){
		new JAToppanel('<?php echo $modulename?>', {modulenid:'<?php echo $module->id?>', duration: <?php echo $duration?>, auto: <?php echo $auto_open?>, delay: <?php echo (int)$delay?>, dontshowagain: <?php echo (int)$show_dontshowagain?>, overlay: <?php echo $overlay?>, $cookie_suffix:'<?php echo $cookie_suffix?>'});		
	})
</script>
<div class="ja-toppanel-mainwrap">
	<div class="ja-toppanel-container" id="<?php echo $modulename?>">
		<div class="ja-toppanel-panels">
			<div class="ja-toppanel-wraper <?php if($transparent) echo 'bg-transparent'?>">
				<div class="ja-toppanel-content">																			
					<?php echo $module_content?>
					
				</div>
			</div>
			<div class="ja-toppanel-button-wraper <?php if($overlay) echo 'button-transparent';?>" id="ja-toppanel-button-wraper-<?php echo $module->id?>">
				<div class="ja-toppanel-button-subwap btn-left">
					<div class="ja-toppanel-button-l"></div>
					<div class="ja-toppanel-button"><?php echo JText::_('Top Panel')?></div>
					<div class="ja-toppanel-button-r"></div>
				</div>
				<?php if($show_dontshowagain){?>
				<div class="ja-toppanel-button-subwap btn-right" id="ja-toppanel-button-subwap-<?php echo $module->id?>">
					<div class="ja-toppanel-button-l"></div>
					<div class="ja-toppanel-button">
						<input type="checkbox" value="<?php echo $module->id; ?>" name="dontshowagain" id="dontshowagain<?php echo $module->id; ?>"/>
						<label for="dontshowagain<?php echo $module->id; ?>"><?php echo JText::_("Don't show again")?></label>
					</div>
					<div class="ja-toppanel-button-r"></div>
				</div>
				<?php }?>
			</div>
			
			
		</div>
	</div>
</div>