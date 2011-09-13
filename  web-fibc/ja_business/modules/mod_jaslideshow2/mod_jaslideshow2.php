<?php
/*
# ------------------------------------------------------------------------
# JA Slideshow II module for Joomla 15
# ------------------------------------------------------------------------
# Copyright (C) 2004-2009 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# This file may not be redistributed in whole or significant part.
# ------------------------------------------------------------------------
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (dirname(__FILE__).DS.'helper.php');
require_once (dirname(__FILE__).DS.'jaimage.php');
$helper = ModJASlideshow3::getInstance();
//global $mosConfig_absolute_path,$database,$mosConfig_live_site;
$folder 			= 	$params->get('folder','');
$startItem 			= 	$params->get('source-images-startItem',0);
$skin 				=	$params->get('skin','');

//$params->set("moduleclass_sfx",$skin);
//Main image
$mainWidth 		= 	$params->get('mainWidth',360);
$mainHeight 		= 	$params->get('mainHeight',240);

//Navigation
$navigation	= 	$params->get('navigation', '');
$orderby	= 	$params->get('orderby', '');
$sort	= 	$params->get('source-images-sort', '');

//Thumbnail info
$showItem 			= 	$params->get('showItem',0);
$thumbWidth 		= 	$params->get('thumbWidth',60);
$thumbHeight 		= 	$params->get('thumbHeight',60);

$thumbSpace 		= 	$params->get('thumbSpace','3:3');
$thumbSpaces = preg_split('/:/', $thumbSpace);
$thumbSpaces[0] = isset ($thumbSpaces[0])?intval ($thumbSpaces[0]):3;
$thumbSpaces[1] = isset ($thumbSpaces[1])?intval ($thumbSpaces[1]):3;
if($navigation != 'thumbs' )
{
	$thumbWidth  = $params->get('item-navwidth',20);
	$thumbHeight = $params->get('item-navheight',20);
	$thumbSpaces[0]  = 0;
	$thumbSpaces[1]  = 0;
}


$thumbOpacity 		=	$params->get('thumbOpacity','0.8');

//Animation
$duration 		= 	$params->get('duration',400);
$autoplay 		= 	$params->get('autoplay',1);
$autoplay = $autoplay == 1?"true":"false";

$interval 		= 	$params->get('interval',5000);
$effect 		= 	$params->get( 'effect', 'Fx.Transitions.Quad.easeInOut');
$animation		= 	$params->get( 'animation', 'move');
$animationRepeat= 	$params->get( 'animationRepeat', "yes");
$animationRepeat= 	($animationRepeat == "yes")?"true":"false";
// die($animationRepeat);

if( !strpos($effect, "Transitions") ){
	$effect = 'Fx.Transitions.'.$effect;
}
//Description
$showDescription	= 	$params->get('showdesc', '');
$showdescwhen		= 	$params->get('showdescwhen', 'always');
$showReadmore		= 	$params->get('show_readmore','1');
$readmoretext		= 	$params->get('readmoretext', 'Readmore');
$descOpacity		= 	$params->get('descOpacity',0.8);
if($showReadmore == '0' && $showDescription == 'desc-readmore')
{
	$readmoretext	= "";
}
//Overlapping items
$container		= 	$params->get('container', 0);
$overlapOpacity	= 	$params->get('overlapOpacity', 0.4);

//Control buttons
$control	= 	$params->get('control', 0);



$navDescmaxlength =  $params->get('source-articles-nav_descmaxlength', '80');

$navShowdesc      =  $params->get('source-articles-nav_showdesc', '80');
$navShowDate      =  $params->get('source-articles-nav_showdate', '0');
$maskWidth	      =  $params->get( 'masker-width', 'auto' );
$maskWidth 	      =  $maskWidth == 'auto' || $maskWidth=='100%' ? $mainWidth : $maskWidth; 
$maskHeigth       =  $params->get( 'masker-height', 'auto' );
$maskHeigth       =  $maskHeigth == 'auto' || $maskHeigth=='100%' ? $mainHeight : $maskHeigth;
$maskAlignment =  $params->get( 'masker-alignment', 'bottom' ); 
$includeTags	= $params->get( 'includeTags','');
$skin_name = "";
if(!empty($skin))
{
	$skin_name 	  = "_".$skin;
}
if(empty($skin_name))
{
	$skin_name	=	$params->get("moduleclass_sfx","");
}
//if exists skin , load skin resouce files
if (!defined ('_MODE_JASLIDESHOW2_ASSETS_')) {
	define ('_MODE_JASLIDESHOW2_ASSETS_', 1);
	//JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/themes/default/');
	if(empty($skin))
	{
		JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/themes/default/');
	}
	elseif(!empty($skin)){
		JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/themes/'.$skin.'/');
		JHTML::stylesheet($module->module.".css",'modules/'.$module->module.'/assets/themes/'.$skin.'/');
	}
	if ( is_file(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'css'.DS.$module->module.".css") )
	JHTML::stylesheet($module->module.".css",'templates/'.$mainframe->getTemplate().'/css/');
	
	JHTML::script( 'script.js','modules/'.$module->module.'/assets/');	
}
elseif(!empty($skin))
{
	JHTML::stylesheet('style.css','modules/'.$module->module.'/assets/themes/'.$skin.'/');
	JHTML::stylesheet($module->module.".css",'modules/'.$module->module.'/assets/themes/'.$skin.'/');
}

$titleMaxChars 	= (int) $params->get( 'title_max_chars', 60 );
$descMaxChars 	= (int) $params->get( 'maxchars', 60 );
$showPreNext 	= $params->get( 'show_btnprenext', '0' );
$navShowthumb 	= $params->get( 'nav_showthumb', '1' );
$navAlignment = $params->get( 'navigation-alignment', 'horizontal' ); 
$classNav = ' ja-'.$navAlignment;
// get instance.
$source = $params->get( 'source', 'images' );

// call and execute 
$list = $helper->callMethod( "getList".ucfirst($source), $params );

// echo '<pre>'.print_r( $list ,1 ); die;


$folder= null;
$navWidth = $params->get( 'source-articles-navwidth', '240' );
$navHeight = $params->get( 'source-articles-navheight', '240' );
$target = 'target="_'. $params->get( 'open_target','parent' ).'"';

$app = & JFactory::getApplication();
$template_name = $app->getTemplate();
//echo '<pre>'.print_r( $list, 1); die;
if(  $source  == 'images' ){
	$images		   = $list['mainImageArray'];
	$captionsArray = $list['captionsArray'];
	$urls		   = $list['urls'];
	$targets 	   = $list['targets'];
	$thumbArray	   = $list['thumbArray'];
	require( JModuleHelper::getLayoutPath( $module->module ) );
	unset($list);
?>
<script type="text/javascript">
  var Ja_direction = '';
  var cookie_path = '/';
  var cur_template_name = '<?php echo $template_name; ?>';
  var Ja_maskAlignment = '<?php echo $maskAlignment; ?>';
  window.addEvent('load', function(){
	 
	   if(typeof(tmpl_name) =='undefined')
	   {
		  cookie_path = "<?php echo $template_name."_direction"; ?>";
	   }
	   else
	   {
		  cookie_path = tmpl_name+"_direction";
	   }
	   Ja_direction = Cookie.get(cookie_path);
	   var style_l_value = 'auto';
	   if(cur_template_name == 'ja_norite')
	   {
			style_l_value = '0';
	   }
	   if(Ja_direction == 'rtl')
		{
			setStyleLinkWithRTLDirection();
			$('ja-slide-<?php echo $module->id;?>').getElement(".ja-slide-main").setStyle('left',style_l_value);
			$('ja-slide-<?php echo $module->id;?>').getElement(".ja-slide-main").setStyle('right','auto');
			if(Ja_maskAlignment == 'right')
			{
				Ja_maskAlignment == 'left';
			}
			else if(Ja_maskAlignment == 'left')
			{
				Ja_maskAlignment == 'right';
			}
		}
    new JASlideshow2('ja-slide-<?php echo $module->id;?>', {	
                startItem: <?php echo $startItem; ?>,
                showItem: <?php echo $showItem; ?>,
                itemWidth: <?php echo $thumbWidth+$thumbSpaces[0]; ?>,
                itemHeight: <?php echo $thumbHeight+$thumbSpaces[1]; ?>,
                mainWidth: <?php echo $mainWidth; ?>,
                mainHeight: <?php echo $mainHeight; ?>,
				maskWidth: <?php echo  $maskWidth; ?>,
				maskHeigth:<?php echo  $maskHeigth; ?>,
                duration: <?php echo $duration; ?>,
                transition: <?php echo $effect; ?>,
                animation: '<?php echo $animation; ?>',
				animationRepeat: '<?php echo $animationRepeat; ?>',
                thumbOpacity:<?php echo $thumbOpacity; ?>,			
                maskOpacity: <?php echo $descOpacity; ?>,
                buttonOpacity: <?php echo $overlapOpacity; ?>,
                showDesc: '<?php echo $showDescription; ?>',
                descMode: '<?php echo $showdescwhen; ?>',
                readmoretext: '<?php echo $readmoretext; ?>',
                overlap: <?php echo $container; ?>,
                navigation:'<?php echo $navigation; ?>',
                urls:['<?php echo implode('\',\'', $urls); ?>'],
				targets:['<?php echo implode('\',\'', $targets); ?>'],
				autoPlay: <?php echo $autoplay; ?>,
				interval: <?php echo $interval; ?>,
				maskAlignment: Ja_maskAlignment,
				languageDirection:( typeof Ja_direction == 'string') ? Ja_direction : '',
				maskerTransStyle:'<?php echo $params->get('masker-transition-style', 'opacity'); ?>',
				maskerTrans:<?php echo $params->get('marker-transition', 'Fx.Transitions.linear'); ?>,
				navePos:'<?php echo $navAlignment; ?>'	
              });
  });
</script>	

<?php	 
} else {
	require( JModuleHelper::getLayoutPath( $module->module, 'default_articles' ) );
	 unset($list);
?>

<script type="text/javascript">
   var Ja_direction = '';
   var cookie_path = '/';
   var cur_template_name = '<?php echo $template_name; ?>';
   var Ja_maskAlignment = '<?php echo $maskAlignment; ?>';
   window.addEvent('load', function(){
   if(typeof(tmpl_name) =='undefined')
   {
	  cookie_path = "<?php echo $template_name."_direction"; ?>";
   }
   else
   {
	  cookie_path = tmpl_name+"_direction";
   }
   Ja_direction = Cookie.get(cookie_path);
   var style_l_value = 'auto';
   if(cur_template_name == 'ja_norite')
   {
		style_l_value = '0';
   }
   if(Ja_direction == 'rtl')
	{
		setStyleLinkWithRTLDirection();
		$('ja-slide-articles-<?php echo $module->id;?>').getElement(".ja-slide-main").setStyle('left',style_l_value);
		$('ja-slide-articles-<?php echo $module->id;?>').getElement(".ja-slide-main").setStyle('right','auto');
		if(Ja_maskAlignment == 'right')
		{
			Ja_maskAlignment == 'left';
		}
		else if(Ja_maskAlignment == 'left')
		{
			Ja_maskAlignment == 'right';
		}
	}
     new JASlideshow2('ja-slide-articles-<?php echo $module->id;?>', {	
                startItem: <?php echo $startItem; ?>,
                showItem: <?php echo $showItem; ?>,
                itemWidth: <?php echo $navWidth; ?>,
                itemHeight: <?php echo $navHeight; ?>,
                mainWidth: <?php echo $mainWidth; ?>,
                mainHeight: <?php echo $mainHeight; ?>,
				maskWidth: <?php echo  $maskWidth; ?>,
				maskHeigth:<?php echo  $maskHeigth; ?>,
                duration: <?php echo $duration; ?>,
                transition: <?php echo $effect; ?>,
                animation: '<?php echo $animation; ?>',
				animationRepeat: '<?php echo $animationRepeat; ?>',
                thumbOpacity:<?php echo $thumbOpacity; ?>,			
                maskOpacity: <?php echo $descOpacity; ?>,
                buttonOpacity: <?php echo $overlapOpacity; ?>,
                showDesc: '<?php echo $showDescription; ?>',
                descMode: '<?php echo $showdescwhen; ?>',
                readmoretext: '<?php echo $readmoretext; ?>',
                overlap: <?php echo $container; ?>,
                navigation:'<?php echo $navigation; ?>',
				autoPlay: <?php echo $autoplay; ?>,
				interval: <?php echo $interval; ?>,
				showbtncontrol:<?php echo $control; ?>,
				maskAlignment: Ja_maskAlignment,
				languageDirection:( typeof Ja_direction == 'string') ? Ja_direction : '',
				maskerTransStyle:'<?php echo $params->get('masker-transition-style', 'opacity'); ?>',
				maskerTrans:<?php echo $params->get('marker-transition', 'Fx.Transitions.linear'); ?>,
				navePos:'<?php echo $navAlignment; ?>'
     });
	/* fix navigator on ie 6,7*/
	$E('.ja-articles .ja-slide-thumbs-handles').setStyles( {'opacity':'0.001', 'background':'#FFF'} );
	});
</script>	
<?php } ?>
<script type="text/javascript" language="javascript">
 function setStyleLinkWithRTLDirection()
 {
    var links = document.getElementsByTagName ('link');
	<?php 
		$filename = "mod_jaslideshow2_rtl.css";
		$tplpath = DS . 'templates' . DS . $mainframe->getTemplate () . DS . 'css' . DS;
		$tplurl = '/templates/' . $mainframe->getTemplate () . '/css/';
		$modurl = 'modules/'.$module->module.'/assets/themes/default/';
		$cssurl = $tplurl;
		if (! file_exists ( JPATH_SITE . $tplpath . $filename )) {
			$cssurl = $modurl;
		}
		$cssurl = JURI::base () . $cssurl;
		?>
	var script = document.createElement('link');
	script.setAttribute('type', 'text/css');
	script.setAttribute('rel', 'stylesheet');
	script.setAttribute('href', '<?php
echo $cssurl . $filename;
?>');
	document.getElementsByTagName("head")[0].appendChild(script);
 }	
</script>	