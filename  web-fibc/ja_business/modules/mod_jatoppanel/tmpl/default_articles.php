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
	<?php foreach ($list as $row){?>
		
		<?php $row->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));?>
		
		<li <?php echo $i++==0?'class="first-item"':(($i==count($list))?'class="last-item"':'') ?>>
			<div class="ja-toppanel-article">
				<h3><span><a href="<?php echo $row->link?>" title="<?php echo $row->title?>"><?php echo $row->title?></a></span></h3>
				<?php echo $row->introtext?>
			</div>			
		</li>
	<?php }?>
</ul>