<?php
/*
# ------------------------------------------------------------------------
# JA Retweet plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/ 

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );


class plgContentPlg_Jaretweet extends JPlugin
{
	var $plugin;
	var $plgParams;
	var $_plgCode;
	var $position;
	var $source;
	
	function plgContentPlg_Jaretweet( &$subject, $config )
	{
		parent::__construct( $subject, $config );

		$this->plugin = &JPluginHelper::getPlugin('content', 'plg_jaretweet');
		$this->plgParams = new JParameter($this->plugin->params);
		$this->position   = $this->plgParams->get('position', 'onBeforeDisplayContent');
		if(strpos($this->position, 'on') !== 0) {
			//right event?
			$this->position = 'onBeforeDisplayContent';
		}
		$this->source   = $this->plgParams->get('source', 'both');
		
		$this->stylesheet ($this->plugin);
	}
	
	function onBeforeDisplay( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onAfterDisplayTitle( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onBeforeDisplayContent( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onAfterDisplayContent( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onAfterDisplay( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	
	function onK2BeforeDisplay( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onK2AfterDisplayTitle( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onK2BeforeDisplayContent( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onK2AfterDisplayContent( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	function onK2AfterDisplay( &$article, &$params, $limitstart ){ return $this->_displayButton( __FUNCTION__, $article, $params, $limitstart ); }
	
	function _displayButton( $position, &$article, &$params, $limitstart ) {
		global $mainframe;
		if ($mainframe->isAdmin()) {
			return '';
		}
		
		if($this->position != $position) {
			return '';
		}
		
		$catid = $article->catid;
		$option 	= JRequest::getVar('option');
		$view 		= JRequest::getVar('view');
		$id			= JRequest::getInt('id');
		$plgParams 	= $this->plgParams;
		
		if(!$article->id) {
			return '';
		}
		
		if ($this->source != 'both' && $this->source != $option) 
			return '';
		
		$display_on_home = (int) $plgParams->get('display_on_home', 1);
		if($view == 'frontpage' && $display_on_home != 1)
			return '';
			
		$display_on_list = (int) $plgParams->get('display_on_list', 1);
		if((($option == 'com_k2' && $view != 'item') || ($option == 'com_content' && $view != 'article' && $view != 'frontpage')) && $display_on_list != 1)
			return '';
		
		if($this->isDetailPage()) {
			//it is not called from detail view
			if($id && $id != $article->id) {
				return '';
			}
		}
		
		
		if($this->isContentItem($article)) {
			$catids         = $plgParams->get('catsid','');
		} else {
			$catids         = $plgParams->get('k2catsid','');
		}
		if (is_array($catids)){
			$categories = $catids;
		} elseif ($catids==''){
			$categories[] = $catid;
		} else {
			$categories[] = $catids;
		}
		
		if( !in_array($catid,$categories)) {
			return '';
		}
		//
		
		/**
		 * @link : http://dev.twitter.com/pages/tweet_button
		 * 
		 * Data Source  					Share query string  	data- attribute of anchor tag  	rel= attribute of a link tag  	Default
		 * Priority 						1 						2 								3 								4
		 * URL to Tweet 					url 					data-url 						rel="canonical" 				HTTP Referrer
		 * via user 						via 					data-via 						rel="me" 	 
		 * Tweet text 						text 					data-text 	  					Content of the <title> tag
		 * Recommended accounts 			related 				data-related 	  	 
		 * Count box position 				count 					data-count 	  					horizontal
		 * Language 						lang 					data-lang 	  					en
		 * URL to which  					counturl 				data-counturl 	  				the url being shared
		 *  your shared URL resolves to
		 * 
		 */
		if($this->isDetailPage()) {
			$style         	= $plgParams->get('data-count', 'vertical');
		} else {
			$style         	= $plgParams->get('data-count-list', 'horizontal');
		}
		
		$lang         	= $plgParams->get('lang', 'en');
		$data_via		= $plgParams->get('data-via', '');
		
		$shareUrl = "http://twitter.com/share";
		$shareUrl .= "?text=" . urlencode($article->title);
		$shareUrl .= "&amp;count=" . urlencode($style);
		$shareUrl .= "&amp;lang=" . urlencode($lang);
		if (!empty($data_via)) $shareUrl .= "&amp;via=" . urlencode($data_via);

		$data_related	= $plgParams->get('data-related', '');
		if(!empty($data_related)) {
			$desc = $plgParams->get('data-related-desc', '');
			if(!empty($desc)) {
				$shareUrl .= "&amp;related=" . urlencode($data_related.':'.$desc);
			} else {
				$shareUrl .= "&amp;related=" . urlencode($data_related);
			}
		}
		
		$classCss		= ($view == 'frontpage') ? 'ja-retweet-'.$style.'-home' : 'ja-retweet-'.$style.'';
		
		//get article's url
		if($this->isContentItem($article)){
			if(!isset($article->readmore_link) || empty($article->readmore_link)){
				$article->readmore_link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug, $article->sectionid));
			}
			$path = $article->readmore_link;
		}
		else
			$path = $article->link;
		if(!preg_match("/^\//", $path)) {
			//convert to relative url
			$path = JURI::root(true).'/'.$path;
		}
		//convert to absolute url
		$url = $this->getRootUrl().$path;
		//$sefurl = $this->convertUrl($path);
		
		//
		$url = str_replace('&amp;', '&', $url);
		
		$tmp_url = 	$this->getRootUrl();
		$tmp_url = str_replace('&amp;', '&', $tmp_url);
		
		$shareUrl .= "&amp;url=" . urlencode($tmp_url);
		//$shareUrl .= "&amp;counturl=" . urlencode($sefurl);
		$shareUrl .= "&amp;counturl=" . urlencode($url);
		
		$html = '
			<div class="'.$classCss.'">
			<a href="'.$shareUrl.'" class="twitter-share-button">Tweet</a>
			';
		if(!defined('JA_USE_TWITTER_WIDGET')) {
			define('JA_USE_TWITTER_WIDGET', 1);
			$html .= '<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
		}
		$html .='
			</div>
			';
	
		return $html;
	}

	function onAfterRender(){
		global $mainframe;
		if ($mainframe->isAdmin()) {
			return '';
		}
		
		$body = JResponse::getBody();
		//add script at the bottom of page
		/*
		$script = "
		<script type=\"text/javascript\">
		//<![CDATA[ 
		window.addEvent('load', function(){
			(function () {
			  var s = document.createElement('script'); s.async = true;
			  s.src = 'http://platform.twitter.com/widgets.js';
			  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(s);
			}());
		});
		//]]> 
		</script>
		";*/
		//$body = str_replace('</body>', $script.'</body>'."\r\n", $body);
		//if its a detail page
		if ($this->isDetailPage()) {
			$document = JFactory::getDocument();
	
			$tags = '<meta name="tweetmeme-title" content="' . $document->getTitle() . '" />'."\r\n";
			
			$body = str_replace('<head>', '<head>'."\r\n".$tags, $body);
			
		}
		JResponse::setBody($body);
	}
	
	/**
	 *
	 * @return (string) - root url without last slashes
	 */
	function getRootUrl() {
		$url = str_replace(JURI::root(true), '', JURI::root());
		$url = preg_replace("/\/+$/", '', $url);
		return $url;
	}
	
	function isDetailPage() {
		$option 	= JRequest::getVar('option');
		$view 		= JRequest::getVar('view');
		//if its a detail page
		if (($option == 'com_k2' && $view == 'item') || ($option == 'com_content' && $view == 'article')) {
			return true;
		}
		return false;
	}
	
	function isContentItem($article) {
		return (isset($article->sectionid)) ? true : false;
	}
	
	function isK2Item($article) {
		return ($this->isContentItem($article)) ? false : true;
	}
	
	function removeCode($content)
	{
		//return preg_replace( $this->_plgCode, '', $content );
		return str_replace( $this->_plgCode, '', $content );
	}
	
	function getLayoutPath($plugin, $layout = 'default')
	{
		global $mainframe;

		// Build the template and base path for the layout
		$tPath = JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.$plugin->name.DS.$layout.'.php';
		$bPath = JPATH_BASE.DS.'plugins'.DS.$plugin->type.DS.$plugin->name.DS.'tmpl'.DS.$layout.'.php';
		// If the template has a layout override use it
		if (file_exists($tPath)) {
			return $tPath;
		} elseif (file_exists($bPath)) {
			return $bPath;
		}
		return '';
	}

	function loadLayout ($plugin, $layout = 'default') {
		$layout_path = $this->getLayoutPath ($plugin, $layout);
		if ($layout_path) {
			ob_start();
			require $layout_path;
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
		return '';
	}

	function stylesheet ($plugin) {
		global $mainframe;
		JHTML::stylesheet('style.css','plugins/'.$plugin->type.'/'.$plugin->name.'/assets/css/');
		if (is_file(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'css'.DS.$plugin->name.".css")) {
			//overwrite with template stylesheet
			JHTML::stylesheet($plugin->name.".css",'templates/'.$mainframe->getTemplate().'/css/');
		}
	} 
	/**
	 * convert from normal format to sef format
	 *
	 * @param unknown_type $matches
	 * @return unknown
	 */
	function convertUrl($originalPath, $pathonly=false)
	{
		jimport( 'joomla.application.router' );
		// Get the router
		$router = new JRouterSite( array('mode' => JROUTER_MODE_SEF) );
	
		// Make sure that we have our router
		if (! $router) {
			if($pathonly)
				return $originalPath;
			else 
				return $this->getRootUrl().$originalPath;
		}
	
		/*if ( (strpos($originalPath, '&') !== 0 ) && (strpos($originalPath, 'index.php') !== 0) ) {
			if($pathonly)
				return $originalPath;
			else 
				return $this->getRootUrl().$originalPath;
		}*/
		
		// Build route
		$path = str_replace(JURI::root(true), '', $originalPath);
		$uri = &$router->build($path);
		
		$path = $uri->toString(array('path', 'query', 'fragment'));
		if(!preg_match("/^\/+/", $path)) {
			$path = "/{$path}";
		}
		//
		if($pathonly) {
			return $path;
		} else {
			$url = $this->getRootUrl();
			return $url.$path;
		}
	}
}
?>