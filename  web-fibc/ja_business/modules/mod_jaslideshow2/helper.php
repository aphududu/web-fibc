<?php 
/*
# ------------------------------------------------------------------------
# JA Slideshow II module for Joomla 15
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/
  // no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . '/components/com_content/helpers/route.php');
/**
 * modJASildeNews class.
 */
class ModJASlideshow3 {

	/**
	 * @var string $condition;
	 *
	 * @access private
	 */
	var $conditons = '';
	
	/**
	 * @var string $order 
	 *
	 * @access private
	 */
	var $order = 'a.ordering';
	
	/**
	 * @var string $limit
	 *
	 * @access private
	 */
	var $limit  = '';
	
	function &getInstance(){
		static $instance = null;
		if( !$instance ){
			$instance = new ModJASlideshow3();
		}
		return $instance;
	}
	
	/**
	 * magic method 
	 * 
	 * @param string method  method is calling
	 * @param string $params.
	 * @return unknown 
	 */
	function callMethod( $method, $params ) {
		if( method_exists( $this, $method ) ) {
			if( is_callable( array( $this, $method ) ) ) {
				return call_user_func( array( $this, $method ), $params );
			}
		}
		return false;
	}
	/**
	 * get listing items from rss link or from list of categories.
	 *
	 * @param JParameter $params
	 * @return array
	 */
	function getListArticles( $params ){
		$rows = array();

		// check cache was endable ?
		if ( $params->get('enable_cache') ) {
			$cache =& JFactory::getCache();
			$cache->setCaching( true );
			$cache->setLifeTime( $params->get( 'cache_time', 30 ) * 60 );	
			$rows = $cache->get( array( $this , 'getArticles' ), array( $params ) ); 
		} else {
			$rows = $this->getArticles( $params );
		}					

		return $rows;
	}
	
	/**
	 * get articles from list of categories and follow up owner paramer.
	 *
	 * @param JParameter $params.
	 * @return array list of articles
	 */
	function getArticles( $params ){
	
		$this->setOrder( $params->get('source-articles-sort_order_field' ,'created'),
						 $params->get('source-articles-sort_order','DESC') );
		$this->setLimit( $params->get('source-articles-max_items', 5) );
		$rows = $this->fetchListArticles( $params );
		return $rows;							
	}
	
	/**
	 *
	 *
	 *
	 */
	function parserCustomTag( $text ){ 
		if( preg_match("#{jaimage(.*)}#s", $text, $matches, PREG_OFFSET_CAPTURE) ){ 
			return $matches;
		}	
		return null;
	}
	
	/**
	 * get list articles follow setting configuration.
	 *
	 * @param JParameter $param
	 * @return array 
	 */ 
	function fetchListArticles( $params ){

		global $mainframe; 
		$titleMaxChars 	= (int) $params->get( 'title_max_chars', 60 );
		$descMaxChars 	= (int) $params->get( 'maxchars', 60 );
		
	 	$db	    = &JFactory::getDBO();
		
		$my = &JFactory::getUser();

		$aid	= $my->get( 'aid', 0 );
		$date =& JFactory::getDate();
		$now  = $date->toMySQL();
		
		$query 	= 	'SELECT a.*,cc.description as catdesc, cc.title as cattitle,s.description as secdesc, s.title as sectitle,' .
					' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
					' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":",cc.id,cc.alias) ELSE cc.id END as catslug,'.
					' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as secslug'
					. "\n FROM #__content AS a".
					' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
					' INNER JOIN #__sections AS s ON s.id = a.sectionid'
					. "\n WHERE a.state = 1"
					. "\n AND ( a.publish_up = " . $db->Quote( $db->getNullDate() ) . " OR a.publish_up <= " . $db->Quote( $now  ) . " )"
					. "\n AND ( a.publish_down = " . $db->Quote( $db->getNullDate() ) . " OR a.publish_down >= " . $db->Quote( $now  ) . " )"
					. ( ( !$mainframe->getCfg( 'shownoauth' ) ) ? "\n AND a.access <= " . (int) $aid : '' )
					;
		
		$query .=  $this->getCondition( $params );
		$query .= ' ORDER BY ' . $this->order;

		if( $this->limit ) {
			$query .=  ' LIMIT ' . $this->limit;
		}	
		
		$db->setQuery($query);
		$data = $db->loadObjectlist();
		JPluginHelper::importPlugin ( 'content' );
		$dispatcher = & JDispatcher::getInstance ();
		$params = & $mainframe->getParams ( 'com_content' );
		$limitstart = JRequest::getVar ( 'limitstart', 0, '', 'int' );
		/*$is_php_version53 = $this->isPhpVersion53();*/

		foreach( $data as $i => $row){
			ModJASlideshow3::parseImages( $row, $params );
			$data [$i]->text = $data [$i]->introtext;
			$results = $dispatcher->trigger ( 'onPrepareContent', array ( &$data [$i], &$params, $limitstart ) );

			$data [$i]->introtext = $data [$i]->text;
			$data[$i]->title = $this->trimString( $data[$i]->title, $titleMaxChars );
			$data[$i]->introtext = $this->trimString( $data[$i]->introtext, $descMaxChars );
		}
		return $data;
	}
	
	function isPhpVersion53()
	{
		$phpversion = phpversion();
		if(strpos($phpversion,"5.3") == 0)
		{
			return true;
		}
		return false;
	}
	
	/**
	 * get condition from setting configuration.
	 *
	 * @param JParameter $params
	 * @return string.
	 */
	function getCondition( $params ){
		
		$condition = '';
		$keyworkd = $params->get( 'source-articles-display_model-modarts-with_keyword', '' );
		if( $params->get("source-articles-display_model", "modcats") == 'modcats' ) {
			$categories = $params->get( 'source-articles-display_model-modcats-category' , '' );	
			
			if( $categories != '' ) {
				$ids = $this->getIds( $categories );		
				$condition = " AND cc.id IN($ids)";
			}
		} else {
			$keyword =  addslashes( $params->get( 'source-articles-display_model-modarts-with_keyword',
												  'Featured' ) );
			$condition = " AND  a.metakey LIKE '%".$keyword."%' ";
		}

		return $condition;
	}
	
	/**
	 * parser options, helper for clause where sql.
	 *
	 * @string array $options
	 * @return string.
	 */
	function getIds( $options ){
		if( !is_array($options) ){
			return (int)$options;
		} else {
			return "'".implode( "','", $options  )."'";
		}		
	}
	
	/**
	 * add sort order sql
	 *
	 * @param string $order is article's field.
	 * @param string $mode is DESC or ASC
	 * @return .
	 */
	function setOrder( $order, $mode ){
		$this->order = ' a.'.$order . ' '. $mode;
		return $this;
	}
	
	/**
	 * add set limit sql
	 * 
	 * @param integer $limit.
	 * @return .
	 */
	function setLimit( $limit ){
		$this->limit = $limit; 
		return $this;
	}
	
	/**
	 * trim string with max specify
	 *  
	 * @param string $title
	 * @param integer $max.
	 */
	function trimString( $title, $maxchars=60, $includeTags = NULL  )
	{
		if(!empty($includeTags))
		{
			$title = $this->trimIncludeTags($title,$this->buildStrTags($includeTags));
		}
		if (function_exists ( 'mb_substr' )) {
			$doc = JDocument::getInstance ();
			$title2 =  SmartTrim::mb_trim ( ($title), 0, $maxchars, $doc->_charset );
			return stripslashes($title2);
		} else {
			$title2 = SmartTrim::trim ( ($title), 0, $maxchars );
			return stripslashes($title2);
		}
	}
	
	public function buildStrTags($strTags = "")
	{
		$strOut = "";
		if(!empty($strTags) && !is_array($strTags))
		{
			$arrStr = explode(",",$strTags);
			if(!empty($arrStr))
			{
				foreach($arrStr as $key => $item)
				{
					$strOut .= "<".$item.">";
				}
			}
		}
		elseif(!empty($strTags) && is_array($strTags))
		{
			$strOut = implode(",",$strTags);
			$strOut = str_replace(",","",$strOut);
		}
		return $strOut;
	}
	function trimIncludeTags($strContent,$listTags = "")
	{
		$strOut = strip_tags($strContent,$listTags);
		return $strOut;
	}
	
	/**
	 * detect and get link with each resource
	 *
	 * @param string $item
	 * @param bool $useRSS.
	 * @return string.
	 */
	function getLink( $item ){
		return  JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid));
	}
	
	/**
	 * get parameters from configuration string.
	 *
	 * @param string $string;
	 * @return array.
	 */
	function parseParams( $string ) {
		$string = html_entity_decode($string, ENT_QUOTES);
		$regex = "/\s*([^=\s]+)\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))/";
		 $params = null;
		 if(preg_match_all($regex, $string, $matches) ){
				for ($i=0;$i<count($matches[1]);$i++){ 
				  $key 	 = $matches[1][$i];
				  $value = $matches[3][$i]?$matches[3][$i]:($matches[4][$i]?$matches[4][$i]:$matches[5][$i]);
				  $params[$key] = $value;
				}
		  }
		  return $params;
	}
	
	/**
	 * parser a image in the content of article.
	 */
	function parseImages( &$row, $params ){
		$row->link = $this->getLink( $row );
		$text =  $row->introtext.$row->fulltext;
		$row->date = strtotime ( $row->modified ) ? $row->created : $row->modified;
		$row->thumbnail = '';
		$row->mainImage = '';
		$data = $this->parserCustomTag( $text );
		if( isset($data[1][0]) ){
			$tmp = $this->parseParams( $data[1][0] );
			$row->mainImage = isset($tmp['main']) ? $tmp['main']:'';
			$row->thumbnail = isset($tmp['thumb']) ?$tmp['thumb']:'';	
		} else {
			$regex = "/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/";
			preg_match ($regex, $text, $matches); 
			$images = (count($matches)) ? $matches : array();
			if (count($images)){
				$row->mainImage = $images[1];
				$row->thumbnail = $images[1];
			}
		}
	}
	
	/**
	 * render image from image source.
	 */
	function renderImage( $title, $image, $params, $width = 0, $height = 0, $attrs='', $returnURL=false ) {
		global $database, $_MAMBOTS, $current_charset;
		if ( $image ) {
			$title = strip_tags( $title ); 
			$thumbnailMode = $params->get( 'source-articles-images-thumbnail_mode', 'crop' );
			$aspect 	   = $params->get( 'source-articles-images-thumbnail_mode-resize-use_ratio', '1' );
			$crop = $thumbnailMode == 'crop' ? true:false;
			$jaimage = JAImage::getInstance();
			if( $thumbnailMode != 'none' && $jaimage->sourceExited($image) ) {
				$imageURL = $jaimage->resize( $image, $width, $height, $crop, $aspect );
				if( $returnURL ){
					return JURI::base().$imageURL;
				}
				if ( $imageURL == $image ) {
					$width = $width ? "width=\"$width\"" : "";
					$height = $height ? "height=\"$height\"" : "";
					$image = "<img src=\"".JURI::base()."$imageURL\"   alt=\"{$title}\" title=\"{$title}\" $width $height $attrs />";
				} else {
					$image = "<img src=\"".JURI::base()."$imageURL\"  $attrs  alt=\"{$title}\" title=\"{$title}\" />";
				}
			} else {
				if( $returnURL ){
					return JURI::base().$image;
				}
				$width = $width ? "width=\"$width\"" : "";
				$height = $height ? "height=\"$height\"" : "";
				$image = "<img $attrs src=\"$image\" alt=\"{$title}\" title=\"{$title}\"/>";	
			}	
		} else {
			$image = '';	
		} 
		// clean up globals
		return $image;
	}
	
	/**
	 *
	 *
	 */
	function getListImages( $params ){
		$folder   = $params->get( 'folder'  , 'images/stories/fruit' );
		$orderby  = $params->get( 'source-images-orderby' , '0' );
		$sort 	  = $params->get( 'source-images-sort'	  , '0' );
		$descriptions  		= 	$params->get('description',"");
		$thumbWidth 		= 	$params->get('thumbWidth',60);
		$thumbHeight 		= 	$params->get('thumbHeight',60);
		$mainWidth 			= 	$params->get('mainWidth',360);
		$mainHeight 		= 	$params->get('mainHeight',240);
		$descMaxChars = $params->get('maxchars', 60);

		
		$descriptionArr = preg_split('/<lang=([^>]*)>/', $descriptions , -1 , PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		$description = '';
		
		if(count($descriptionArr) > 1){
			for($i=0; $i< count( $descriptionArr ); $i=$i+2 ){
				if( $descriptionArr[$i] == $iso_client_lang ){
					$description = $descriptionArr[($i+1)];
					break;
				}
			}
			if(!$description){
				$description = $descriptionArr[1];
			}
		} else if(isset($descriptionArr[0])) {
				$description = $descriptionArr[0];
		} 
		
		//Parse description. Description in format: [desc img="imagename" url="link"]Description goes here[/desc]
		$descriptionArray = $this->parseDescNew ( $description );
		
		$images = $this->readDirectory( $folder, $orderby, $sort );
		$data = array(); 

	    if( !empty($images) )
		{
			foreach( $images as $k => $img ){
				$items[] = $k;
				if(isset($descriptionArray[$img]) && isset($descriptionArray[$img]["caption"] ))
				{
					$descriptionArray[$img]["caption"] = $this->trimString( $descriptionArray[$img]["caption"], $descMaxChars );
				}

				if($img) {
					$data['captionsArray'][]  = (isset($descriptionArray[$img]) && isset($descriptionArray[$img]['caption'])) ? str_replace("'", '"', $descriptionArray[$img]['caption']) :'';
				}
				// URL of image proccess
				$url = JRoute::_((isset($descriptionArray[$img]) && isset($descriptionArray[$img]['url'])) ? $descriptionArray[$img]['url'] :'');
				$id = (isset($descriptionArray[$img]) && isset($descriptionArray[$img]['id'])) ? $descriptionArray[$img]['id'] :'';
				if ($id) $url = JRoute::_(ContentHelperRoute::getArticleRoute($id));
				$data['urls'][] = $url;
				// Target of URL
				$target = JRoute::_((isset($descriptionArray[$img]) && isset($descriptionArray[$img]['target'])) ? $descriptionArray[$img]['target'] :'');
				$id = (isset($descriptionArray[$img]) && isset($descriptionArray[$img]['id'])) ? $descriptionArray[$img]['id'] :'';
				if ($id) $target = JRoute::_(ContentHelperRoute::getArticleRoute($id));
				$data['targets'][] = $target;
				
				$data['thumbArray'][] = $this->renderImage ( '', $folder.'/'.$img, $params, $thumbWidth, $thumbHeight,'', true );
				$data['mainImageArray'][] = $this->renderImage ( '', $folder.'/'.$img, $params, $mainWidth, $mainHeight, '', true );
				
			}
		}
		return $data;
	}
	
	/**
	 *
	 *
	 */
	function readDirectory( $folder, $orderby, $sort ){
		$imagePath 	= JPATH_SITE ."/".$folder;
		$imgFiles 	= JFolder::files( $imagePath );
		$folderPath = $folder .'/';
		$imageFile = array();
		$i = 0;
		if(!empty($imgFiles))
		{
			foreach ($imgFiles as $file){
				$i_f 	= $imagePath .'/'. $file;
				if ( preg_match( "/bmp|gif|jpg|png|jpeg/", $file ) && is_file( $i_f ) ) {
					$imageFile[$i][0] = $file;
					$imageFile[$i][1] = filemtime($i_f)	;
					$i++;
				}
			}
		}
	
		$images = $this->sortImage( $imageFile, $orderby , $sort );
		return $images;
	}
	/**
	 *
	 *
	 */
	function getFile( $name, $modPath, $tmplPath = '' ) {
		if (!$tmplPath) {
			global $mainframe;
			$tmplPath = 'templates'.DS.$mainframe->getTemplate().DS.'css'.DS;
		}
		if (file_exists(JPATH_SITE.DS.$tmplPath.$name)) {
			return $tmplPath.$name;
		}
		return $modPath.$name;
	}
	
	/**
	 *
	 *
	 */
	function sortImage( $image, $orderby , $sort ){
		$sortObj = array();
		$imageName = array();
		if($orderby == 1){
			for($i=0;$i<count($image);$i++){
				$sortObj[$i] = $image[$i][1];
				$imageName[$i] = $image[$i][0];
			}
		}
		else{
			for($i=0;$i<count($image);$i++){
				$sortObj[$i] = $image[$i][0];
			}
			$imageName = $sortObj;
		}
		if($sort == 1) array_multisort($sortObj, SORT_ASC, $imageName);
		elseif($sort == 2)	array_multisort($sortObj, SORT_DESC, $imageName);
		else shuffle($imageName);
		return $imageName;
	}
	
	/**
	 *
	 *
	 */
	function parseDescNew( $description ) {
		
		$regex = '#\[desc ([^\]]*)\]([^\[]*)\[/desc\]#m';
		preg_match_all ($regex, $description, $matches, PREG_SET_ORDER);
		
		$descriptionArray = array();
		foreach ($matches as $match) {
		$params = $this->parseParams( $match[1] );
		if (is_array($params)) {
			$img = isset($params['img'])?trim($params['img']):'';
			if (!$img) continue;
				$url = isset($params['url'])?trim($params['url']):'';
				$target = isset($params['target'])?trim($params['target']):'';
				$descriptionArray[$img] = array( 'url'		=> $url,
												 'caption'	=> str_replace("\n","<br />",trim($match[2])),
												 'target'	=>$target);
			}
		}
		
		return $descriptionArray;
	}

}
?>

<?php 
if (! class_exists ( 'SmartTrim' )) {
	class SmartTrim {
		/*
      $hiddenClasses: Class that have property display: none or invisible.
    */
		function mb_trim($strin, $pos = 0, $len = 10000, $hiddenClasses = '', $encoding = 'utf-8') {
			mb_internal_encoding ( $encoding );
			$strout = trim ( $strin );
			
			$pattern = '/(<[^>]*>)/';
			$arr = preg_split ( $pattern, $strout, - 1, PREG_SPLIT_DELIM_CAPTURE );
			$left = $pos;
			$length = $len;
			$strout = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				$arr [$i] = trim ( $arr [$i] );
				if ($arr [$i] == '')
					continue;
				if ($i % 2 == 0) {
					if ($left > 0) {
						$t = $arr [$i];
						$arr [$i] = mb_substr ( $t, $left );
						$left -= (mb_strlen ( $t ) - mb_strlen ( $arr [$i] ));
					}
					
					if ($left <= 0) {
						if ($length > 0) {
							$t = $arr [$i];
							$arr [$i] = mb_substr ( $t, 0, $length );
							$length -= mb_strlen ( $arr [$i] );
							if ($length <= 0) {
								$arr [$i] .= '...';
							}
						
						} else {
							$arr [$i] = '';
						}
					}
				} else {
					if (SmartTrim::isHiddenTag ( $arr [$i], $hiddenClasses )) {
						if ($endTag = SmartTrim::getCloseTag ( $arr, $i )) {
							while ( $i < $endTag )
								$strout .= $arr [$i ++] . "\n";
						}
					}
				}
				$strout .= $arr [$i] . "\n";
			}
			//echo $strout;  
			return SmartTrim::toString ( $arr, $len );
		}
		
		function trim($strin, $pos = 0, $len = 10000, $hiddenClasses = '') {
			$strout = trim ( $strin );
			$pattern = '/(<[^>]*>)/';
			$arr = preg_split ( $pattern, $strout, - 1, PREG_SPLIT_DELIM_CAPTURE );
			$left = $pos;
			$length = $len;
			$strout = '';
			for($i = 0; $i < count ( $arr ); $i ++) {
				$arr [$i] = trim ( $arr [$i] );
				if ($arr [$i] == '')
					continue;
				if ($i % 2 == 0) {
					if ($left > 0) {
						$t = $arr [$i];
						$arr [$i] = substr ( $t, $left );
						$left -= (strlen ( $t ) - strlen ( $arr [$i] ));
					}
					
					if ($left <= 0) {
						if ($length > 0) {
							$t = $arr [$i];
							$arr [$i] = substr ( $t, 0, $length );
							
							$length -= strlen ( $arr [$i] );
							if ($length <= 0) {
								$arr [$i] .= '...';
							}
						
						} else {
							$arr [$i] = '';
						}
					}
				} else {
					if (SmartTrim::isHiddenTag ( $arr [$i], $hiddenClasses )) {
						if ($endTag = SmartTrim::getCloseTag ( $arr, $i )) {
							while ( $i < $endTag )
								$strout .= $arr [$i ++] . "\n";
						}
					}
				}
				$strout .= $arr [$i] . "\n";
			}
			//echo $strout;  
			return SmartTrim::toString ( $arr, $len );
		}
		
		function isHiddenTag($tag, $hiddenClasses = '') {
			//By pass full tag like img
			if (substr ( $tag, - 2 ) == '/>')
				return false;
			if (in_array ( SmartTrim::getTag ( $tag ), array ('script', 'style' ) ))
				return true;
			if (preg_match ( '/display\s*:\s*none/', $tag ))
				return true;
			if ($hiddenClasses && preg_match ( '/class\s*=[\s"\']*(' . $hiddenClasses . ')[\s"\']*/', $tag ))
				return true;
		}
		
		function getCloseTag($arr, $openidx) {
			$tag = trim ( $arr [$openidx] );
			if (! $openTag = SmartTrim::getTag ( $tag ))
				return 0;
			
			$endTag = "<$openTag>";
			$endidx = $openidx + 1;
			$i = 1;
			while ( $endidx < count ( $arr ) ) {
				if (trim ( $arr [$endidx] ) == $endTag)
					$i --;
				if (SmartTrim::getTag ( $arr [$endidx] ) == $openTag)
					$i ++;
				if ($i == 0)
					return $endidx;
				$endidx ++;
			}
			return 0;
		}
		
		function getTag($tag) {
			if (preg_match ( '/\A<([^\/>]*)\/>\Z/', trim ( $tag ), $matches ))
				return ''; //full tag
			if (preg_match ( '/\A<([^ \/>]*)([^>]*)>\Z/', trim ( $tag ), $matches )) {
				//echo "[".strtolower($matches[1])."]";
				return strtolower ( $matches [1] );
			}
			//if (preg_match ('/<([^ \/>]*)([^\/>]*)>/', trim($tag), $matches)) return strtolower($matches[1]);
			return '';
		}
		
		function toString($arr, $len) {
			$i = 0;
			$stack = new JAStack ( );
			$length = 0;
			while ( $i < count ( $arr ) ) {
				$tag = trim ( $arr [$i ++] );
				if ($tag == '')
					continue;
				if (SmartTrim::isCloseTag ( $tag )) {
					if ($ltag = $stack->getLast ()) {
						if ('</' . SmartTrim::getTag ( $ltag ) . '>' == $tag)
							$stack->pop ();
						else
							$stack->push ( $tag );
					}
				} else if (SmartTrim::isOpenTag ( $tag )) {
					$stack->push ( $tag );
				} else if (SmartTrim::isFullTag ( $tag )) {
					//echo "[TAG: $tag, $length, $len]\n";
					if ($length < $len)
						$stack->push ( $tag );
				} else {
					$length += strlen ( $tag );
					$stack->push ( $tag );
				}
			}
			
			return $stack->toString ();
		}
		
		function isOpenTag($tag) {
			if (preg_match ( '/\A<([^\/>]+)\/>\Z/', trim ( $tag ), $matches ))
				return false; //full tag
			if (preg_match ( '/\A<([^ \/>]+)([^>]*)>\Z/', trim ( $tag ), $matches ))
				return true;
			return false;
		}
		
		function isFullTag($tag) {
			//echo "[Check full: $tag]\n";
			if (preg_match ( '/\A<([^\/>]*)\/>\Z/', trim ( $tag ), $matches ))
				return true; //full tag
			return false;
		}
		
		function isCloseTag($tag) {
			if (preg_match ( '/<\/(.*)>/', $tag ))
				return true;
			return false;
		}
	}
	
	class JAStack {
		var $_arr = null;
		function JAStack() {
			$this->_arr = array ();
		}
		
		function push($item) {
			$this->_arr [count ( $this->_arr )] = $item;
		}
		function pop() {
			if (! $c = count ( $this->_arr ))
				return null;
			$ret = $this->_arr [$c - 1];
			unset ( $this->_arr [$c - 1] );
			return $ret;
		}
		function getLast() {
			if (! $c = count ( $this->_arr ))
				return null;
			return $this->_arr [$c - 1];
		}
		function toString() {
			$output = '';
			foreach ( $this->_arr as $item ) {
				$output .= $item . "\n";
			}
			return $output;
		}
	}
}

?>
