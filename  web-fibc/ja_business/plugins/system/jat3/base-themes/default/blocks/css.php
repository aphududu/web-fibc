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
if (T3Common::mobile_device_detect()) return; /* don't apply custom css for handheld device */

/*Load google font and style for special font*/
$elements = array('global', 'logo', 'slogan', 'moduletitle','pageheading', 'contentheading', 'mainnav', 'subnav');
$fonts = array();
$_fonts = array();
foreach ($elements as $element) {
	$fontsetting = $this->getParam ('gfont_'.$element);
	$fontsetting = preg_split('/\|/', $fontsetting);
	$fonts[$element] = '';
	if (count ($fontsetting) > 2 && $fontsetting[1]) {
		$fonts[$element] = $fontsetting[0];		
		if ($fonts[$element]) {
			$_fonts [] = $fontsetting[0]; //add font to load
			$fonts[$element] = "font-family: '{$fonts[$element]}';";
		}
		$custom = '';
		$custom = trim ($fontsetting[2]);
		if ($custom && substr($custom, -1) != ';') $custom .= ';';
		$fonts[$element] .= $custom;
	}
}
if (count ($_fonts)) :
$gfonts = str_replace (' ', '+', implode ('|', $_fonts));
?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $gfonts ?>" />
<?php endif ?>

<style type="text/css">

<?php if ($fonts['global']): ?>
	body#bd 
	{<?php echo $fonts['global'] ?>}
<?php endif; ?>
<?php if ($fonts['logo']): ?>
	div.logo-text h1 
	{<?php echo $fonts['logo'] ?>}
<?php endif; ?>
<?php if ($fonts['slogan']): ?>
	p.site-slogan 
	{<?php echo $fonts['slogan'] ?>}
<?php endif; ?>
<?php if ($fonts['mainnav']): ?>
	#ja-splitmenu,
	#jasdl-mainnav,
	#ja-cssmenu li,
	#ja-megamenu ul.level0
	{<?php echo $fonts['mainnav'] ?>}
<?php endif; ?>
<?php if ($fonts['subnav']): ?>
	#ja-subnav,
	#jasdl-subnav,
	#ja-cssmenu li li,
	#ja-megamenu ul.level1
	{<?php echo $fonts['subnav'] ?>}
<?php endif; ?>
<?php if ($fonts['pageheading']): ?>
	.componentheading 
	{<?php echo $fonts['pageheading'] ?>}
<?php endif; ?>
<?php if ($fonts['contentheading']): ?>
	.contentheading,
	.article-content h1,
	.article-content h2,
	.article-content h3,
	.article-content h4,
	.article-content h5,
	.article-content h6 
	{<?php echo $fonts['contentheading'] ?> }
<?php endif; ?>
<?php if ($fonts['moduletitle']): ?>
	div.ja-moduletable h3, div.moduletable h3,
	div.ja-module h3, div.module h3
	{<?php echo $fonts['moduletitle'] ?>}
<?php endif; ?>
<?php
$mainwidth = $this->getMainWidth();
if ($mainwidth) :
?>

/*dynamic css*/
	body.bd .main {width: <?php echo $mainwidth ?>;}
	body.bd #ja-wrapper {min-width: <?php echo $mainwidth ?>;}
</style>
<?php endif; ?>
