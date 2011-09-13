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

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!class_exists('modJaToppanelHelper')){
class modJaToppanelHelper extends JObject
{
	var $_result = null;
	function _load($params)
	{		
		switch ($params->get('type')){			
			case 'modules':				
				$this->rend_html_Modules($params);
				break;
			case 'module':
				$this->rend_html_Module($params);
				break;
			case 'article-ids':
			case 'article-catid':
				$this->rend_html_Article($params);
				break;	
		}
		
		return $this->_result;
	}
	
	function rend_html_Modules($params){		
		$list =  JModuleHelper::getModules(trim($params->get('modules', '')));
		$mparams = array('style' => 'jaxhtml');
		for($j=0; $j<count($list); $j++){
			if($list[$j]->module!='mod_jatoppanel'){
				$list[$j]->content = JModuleHelper::renderModule($list[$j], $mparams);	
			}
		}		
			
		if($list){			
			$class = $params->get('display', 'ja-toppanel-col');
			ob_start ();
			$path = JModuleHelper::getLayoutPath ( 'mod_jatoppanel', 'default_modules' );
			if (file_exists ( $path )) {
				require ($path);
			}
			$this->_result = ob_get_clean ();			
		}	
		
	}
	
	function rend_html_Module($params){		
		$list_module=array();
		$modules = array();
		if($params->get('modulename', '')) $list_module = explode(",", $params->get('modulename'));	
		for($i=0; $i<count($list_module); $i++){
			if ($list_module[$i]!='mod_jatoppanel') {
				$modules[$i] =  JModuleHelper::getModule(substr(trim($list_module[$i]), 4 ));
				if($modules[$i] && $modules[$i]->id){
					$modules[$i]->content = JModuleHelper::renderModule($module);	
				}			
			}
				
		}		
		if($list){			
			$class = $params->get('display', 'ja-toppanel-col');
			ob_start ();
			$path = JModuleHelper::getLayoutPath ( 'mod_jatoppanel', 'default_modules' );
			if (file_exists ( $path )) {
				require ($path);
			}
			$this->_result = ob_get_clean ();			
		}				
	}		
	
	function rend_html_Article($params){
		$list = null;
		if($params->get('type')=='article-ids' && $params->get('article-ids', '')){
			$list = $this->getList($params->get('article-ids', ''));
		}
		elseif ($params->get('type') == 'article-catid'){
			$catids = (is_array($params->get('article-catid', array())) && $params->get('article-catid', array()))?implode(',', $params->get('article-catid', '')):$params->get('article-catid', '');			
			$list = $this->getList('', $catids, $params->get('limit', -1));
		}				
				
		if($list){
			
			require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';						
			if($list){			
				$class = $params->get('display', 'ja-toppanel-col');
				ob_start ();
				$path = JModuleHelper::getLayoutPath ( 'mod_jatoppanel', 'default_articles' );
				if (file_exists ( $path )) {
					require ($path);
				}
				$this->_result = ob_get_clean ();			
			}	
		}		
	}
	
	function getList($ids='', $catid='', $limit=0)
	{
		global $mainframe;
		$db 	= JFactory::getDBO();
		$user 	= JFactory::getUser();
		$aid	= $user->get('aid', 0);

		$contentConfig	= JComponentHelper::getParams( 'com_content' );
		$noauth			= !$contentConfig->get('shownoauth');
	
		jimport('joomla.utilities.date');
		$date = new JDate();
		$now = $date->toMySQL();

		$nullDate = $db->getNullDate();

		// query to determine article count
		$query = 'SELECT a.id' .			
			' FROM #__content AS a' ;
		$query .=	' WHERE a.state = 1 ';				
		$query .= ' AND (a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' ) ' .
				  ' AND (a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )' ;	
					
		if($ids!=''){
			$query .= "\n AND a.id in ($ids)";
		}
		if($catid != '') {
			$query .=	" AND a.catid in ($catid)";
		}						
		$query .= ' ORDER BY a.ordering ' ;		
		if($catid != '' && $limit>0) {
			$query .=	"LIMIT 0, $limit";
		}
		
		$db->setQuery($query);
		$ids = $db->loadResultArray();		
		 
		jimport('joomla.plugin.helper');
		JPluginHelper::importPlugin('content');
		
		$app = JFactory::getApplication();
		$params = new JParameter('');
		
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
  		
		require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'query.php';
		require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'models'.DS.'article.php';
		$model = new ContentModelArticle();
		$rows = array();
  		foreach ($ids as $id){
  			$model->setId($id);	
  			$row = $model->getArticle();
  			if($row->id){
				$app->triggerEvent('onPrepareContent', array (& $row, & $params, $limitstart));
				$row->introtext = $row->text;
				
				$rows[] = $row;
  			}
			
      	}
      
		return $rows;
	}
}
}
?>
