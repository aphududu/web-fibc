<?php
/*
# ------------------------------------------------------------------------
# JA Facebook Share for Joomla 1.5
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


class plgContentPlg_Jafacebookshare extends JPlugin
{
	var $plugin;
	var $plgParams;
	var $_plgCode;
	var $position;
	var $source;
	
	function plgContentPlg_Jafacebookshare( &$subject, $config )
	{
		parent::__construct( $subject, $config );

		$this->plugin = &JPluginHelper::getPlugin('content', 'plg_jafacebookshare');
		$this->plgParams = new JParameter($this->plugin->params);
		$this->position   = $this->plgParams->get('position', 'onBeforeDisplayContent');
		if(strpos($this->position, 'on') !== 0) {
			//right event?
			$this->position = 'onBeforeDisplayContent';
		}
		$this->source   = $this->plgParams->get('source', 'both');
		
		$this->stylesheet ($this->plugin);
	}
	
	function onPrepareContent( &$article, &$params, $limitstart )
	{
		global $mainframe;
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
		
		if($this->isDetailPage()) {
			$type         	= $plgParams->get('type', 'box_count');
		} else {
			$type         	= $plgParams->get('type_list', 'button_count');
		}
		$classCss		= ($view == 'frontpage') ? 'ja-facebookshare-'.$type.'-home' : 'ja-facebookshare-'.$type.'';
		
		
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
		//
		//$url = str_replace('&amp;', '&', $url);
		
		/**
		 * $url = urlencode($url);
		 * $title = urlencode($article->title);
		 */
		$html = '
			<div class="'.$classCss.'">
			<fb:share-button class="url" href="'.$url.'" type="'.$type.'"></fb:share-button>
			</div>
			';
		return $html;
	}
	
	/**
	 * include Facebook Markup Language Language (FBML)
	 * This function is required for all Facebook's social plugins,
	 * and it is commonly used for all plugins that are used FBML
	 *
	 */
	function getFBML() {
		if(!defined('JA_INCLUDE_FBML')) {
			define('JA_INCLUDE_FBML', 1);
			$plgParams = $this->plgParams;
			$app_id        = $plgParams->get('app_id', '');
			
			$fbml = "
			<div id=\"fb-root\"></div>
			<script type=\"text/javascript\">
			    window.fbAsyncInit = function() {
			      FB.init({appId: '{$app_id}', status: true, cookie: true, xfbml: true});
			    };
				window.addEvent('load', function(){
				  (function() {
					var e = document.createElement('script'); 
					e.type = 'text/javascript';
					e.async = true;
					e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
					document.getElementById('fb-root').appendChild(e);
				  }());
			  });
			</script>
			";
			return $fbml;
		}
		return '';
	}

	function onAfterRender(){
		global $mainframe;
		if ($mainframe->isAdmin()) {
			return '';
		}
		$body = JResponse::getBody();
		
		//include FBML
		$fbml = $this->getFBML();
		if(!empty($fbml)) {
			$body = str_replace('</body>', $fbml.'</body>'."\r\n", $body);
			//Declares a namespace for FBML tags in an HTML document.
			//add xmlns:fb="http://www.facebook.com/2008/fbml" to header tag
			$regex = "/<html.*?xmlns:fb=\".*?\"[^>]*?>/i";
			if(!preg_match($regex, $body)) {
				$body = str_replace('<html', '<html xmlns:fb="http://www.facebook.com/2008/fbml"', $body);
			}
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
}
?>