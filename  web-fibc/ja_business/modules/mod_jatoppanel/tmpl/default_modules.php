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
?>
<?php $i=0 ?>
<ul class="<?php echo $class?>">
	<?php foreach ($list as $module){?>
		<li <?php echo $i++==0?'class="first-item"':(($i==count($list))?'class="last-item"':'') ?>>
			<?php echo $module->content?>
		</li>
	<?php }?>
</ul>