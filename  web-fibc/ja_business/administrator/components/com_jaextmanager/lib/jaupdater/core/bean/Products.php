<?php
/*
# ------------------------------------------------------------------------
# JA Extensions Manager Client Library
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/ 
// no direct access
defined( '_JA' ) or die( 'Restricted access' );


class jaProducts
{
	var $isSupported = 1;
	var $ws_mode = '';
	var $ws_uri = '';
	var $ws_user = '';
	var $ws_pass = '';
	var $repo = '';//on local: is path to site 
	var $coreVersion = '';
	var $type = '';
	var $name = '';
	var $folder = '';
	var $group = '';
	var $extId = '';//Unique Key (on local), format: type-id
	var $uniqueKey = '';//Unique Key (on server)
	var $extKey = '';//extension key
	var $version = '';
	var $crc = '';
	/**
	 * object config
	 *
	 * @var (UpdaterConfig) $config
	 */
	var $config;
	var $configFile = '';
	var $ignores = array("^\..*", "jabk", "jaupdater");

	function jaProducts(&$row, $config, $refresh = false) {
		$this->config = $config;
		
		$this->setRepoPath($config->get("REPO_PATH") . DS);
		$infoRequired = array('type', 'name', 'extKey', 'version');
		
		foreach ($infoRequired as $info) {
			if(!isset($row->$info)) {
				return false;
			}
		}
		foreach ($row as $key=>$value) {
			$this->$key = $value;
		}
		
		$this->coreVersion = (isset($row->coreVersion)) ? $row->coreVersion : 'j15';
		
		//create unique key
		if(!isset($row->uniqueKey) || empty($row->uniqueKey)) {
			$this->uniqueKey = "{$this->extKey}_{$this->coreVersion}";
		}
		
		$this->setInfo($refresh);
	}

	function setInfo($refresh = false, $fileInfo = '') {		
		if(!is_file($fileInfo)) {
			$fileInfo = $this->getInfoFile();
		}
		
		if (!is_file($fileInfo) || $refresh) {
			if($this->updateInfo() === false) {
				return false;
			}
		}
		
		$xml = new jaXmlParser();
		$xml->loadFile($fileInfo);
		$obj = $xml->toObject();
		$parentNode = $obj->japroduct->children;

		/*$this->date 	= (string) $parentNode->type->value;
		$this->version 	= (string) $parentNode->version->value;
		$this->name 	= (string) $parentNode->name->value;*/
		$this->extKey 	= (string) $parentNode->extKey->value;
		$this->crc 		= (string) $parentNode->crc->value;
		
		return true;
	}
	
	/**
	 * get Informations of Products to send to server
	 * get only some basic information
	 */
	function getInfo() {
		$obj = new stdClass();
		$aInfo = array('isSupported' => 1, 
						'ws_mode' => '', 
						'ws_uri' => '', 
						'ws_user' => '', 
						'ws_pass' => '', 
						'coreVersion' => 'j15', 
						'type' => '', 
						'name' => '', 
						'folder' => '', 
						'group' => '', 
						'extKey' => '', 
						'uniqueKey' => '', 
						'version' => '', 
						'configFile' => '');
		foreach ($aInfo as $info => $value) {
			$obj->$info = isset($this->$info) ? $this->$info : $value;
		}
		return $obj;
	}
	
	function getFullInfo() {
		$vars = get_object_vars($this);
		
		$obj = new stdClass();
		foreach ($vars as $key=>$value) {
			$obj->$key = $value;
		}
		return $obj;
	}
	
	function setSupport($status) {
		$this->isSupported = $status;
	}
	
	function isSupported() {
		return (int) $this->isSupported;
	}

	function setRepoPath($path) {
		$this->repo = FileSystemHelper::clean($path.DS);
	}

	function getRepoPath() {
		return $this->repo;
	}
	
	function getBackupPath() {
		global $jauc;
		$config = $this->config;
		$backupDir = $jauc->getLocalBackupPath($this->getInfo());
		
		if($backupDir === false) {
			return false;
		} else {
			return $backupDir;
		}
	}

	function genChecksum() {
		$md5CheckSums = new CheckSumsMD5();
		$location = $this->getLocation();
		$cnt = count($location);
		
		$crc = new stdClass();
		foreach ($location as $name => $path) {
			if($this->isIgnore($name))
				continue;
			if(is_dir($path)) {
				if($name != 'location') {
					$crc->$name = $md5CheckSums->dumpCRCObject($path);
				} else {
					$crc = $md5CheckSums->dumpCRCObject($path);
				}
			} elseif (is_file($path)) {
				$crc->$name = $md5CheckSums->getCheckSum($path);
			}
		}
		
		return json_encode($crc);
	}
	
	function getInfoFile() {
		$location = $this->getLocation();
		switch ($this->type) {
			case 'component':
				if(isset($location['admin']))
					$path = $location['admin'];
				elseif(isset($location['site']))
					$path = $location['site'];
				break;
			case 'module':
				if(isset($location['location']))
					$path = $location['location'];
				break;
			case 'plugin':
				$path = dirname($location[$this->extKey . ".php"]) . DS;
				break;
			case 'template':
				if(isset($location['location']))
					$path = $location['location'];
				break;
			default:
				//not match any type
				return false;
				break;
		}
		if(isset($path) && is_dir($path)) {
			return $path . "jaupdater.{$this->extKey}.xml";
		} else {
			return false;
		}
	}
	
	function updateInfo() {
		$fileInfo = $this->getInfoFile();
		if($fileInfo === false) {
			return false;
		}
		
		$xml = new jaXmlParser();
		$xml->loadFile($this->configFile);
		$obj = $xml->toObject();
		$parentNode = $obj->install->children;
		
		$version = $parentNode->version->value;
		$name = $parentNode->name->value;
		
		$dateCreated = date('r');
		$crc = $this->genChecksum();
		
		$xmlContent = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<japroduct>
  <type>$this->type</type>
  <name>$name</name>
  <extKey>$this->extKey</extKey>
  <version>$version</version>
  <date>$dateCreated</date>
  <crc>
    <![CDATA[
      $crc
    ]]>
  </crc>
</japroduct>
XML;
		$result = JFile::write($fileInfo, $xmlContent);
		
		return $result;
	}
	
	/**
	 * upgrade to newer version
	 *
	 * @param unknown_type $upgradePackage
	 * 
	 * @desc rule to update for local version
	 * - new (new file in new version): add to
	 * - updated (updated file in new version): replace a curren file (required!)
	 * - removed (removed file in new version): delete current file
	 * - ucreated (created by user): do nothing
	 * - umodified (modified by user): do nothing
	 * - nochange (nochange): do nothing
	 */
	function doUpgrade($upgradePackage, $upgradeVersion) {
		$config = $this->config;
		
		if(!is_file($upgradePackage)) {
			return false;
		}
		//auto backup when upgrade
		$fileBackup = $this->doBackup();
		
		//upgrade process
		$workingDir = FileSystemHelper::tmpDir(null, 'ja', 0777);
		$zipFile = $workingDir . $this->extKey . ".zip";
		JFile::copy($upgradePackage, $zipFile);
		
		ArchiveHelper::unZip($zipFile, $workingDir);
		//upgrade
		$workingDir = $workingDir . $this->extKey . DS;
		
		$jsonFile = $workingDir . "jaupdater.info.json";
		if(!is_file($jsonFile)) {
			return false;
		}
		$upgradeInfo = file_get_contents($jsonFile);
		$objectFilter = json_decode($upgradeInfo);
		//JFile::delete($jsonFile);
		
		//backup conflicted files
		$folderBackup = FileSystemHelper::stripExt($fileBackup);
		$this->doBackupConflictedFiles($upgradeVersion, $folderBackup);
		//
		$this->_applyPackage($workingDir, $objectFilter);
		return true;
	}
	
	/**
	 * Recovery to old version
	 *
	 * @param unknown_type $upgradePackage
	 * 
	 */
	function doRecovery($product, $folder, $file) {	
		global $jauc;
		//auto backup when recovery
		$this->doBackup();	
		// upgrade process
		$workingDir = FileSystemHelper::tmpDir(null, 'ja', 0777);
		$zipFile 	= $folder . $file;
		
		ArchiveHelper::unZip($zipFile, $workingDir);
		$workingDir = $workingDir . $this->extKey . DS;
		
		$objectFilter = new stdClass();
		$this->_applyPackage($workingDir, $objectFilter);
		
		//get backup info
		$fileInfo = $folder . FileSystemHelper::stripExt($file) . ".txt";
		if(($data = $jauc->_parseBackupInfo($fileInfo)) !== false) {
			return $data["version"];
		} else {
			return "";
		}
	}
	
	function _applyPackage($src, $objectFilter) {
		global $jauc;
		//get array version of newer version
		//it will support for downgrade purpose
		$aVersions = $this->_parseListVersions();
		//
		
		$locations = $this->getLocation();
		switch ($this->type) {
			case 'module':
			case 'template':
				FileSystemHelper::cp($src, $locations['location'], true);
				$this->_applyFileRemoved($objectFilter, $locations['location']);
				break;
			case 'component':
				if(isset($locations['admin']) && is_dir($src.'admin')) {
					FileSystemHelper::cp($src.'admin', $locations['admin'], true);
					if(isset($objectFilter->admin)) {
						$this->_applyFileRemoved($objectFilter->admin, $locations['admin']);
					}
				}
				if(isset($locations['site']) && is_dir($src.'site')) {
					FileSystemHelper::cp($src.'site', $locations['site'], true);
					if(isset($objectFilter->site)) {
						$this->_applyFileRemoved($objectFilter->site, $locations['site']);
					}
				}
				//exception: xml config file for component
				$xmlfile = basename($this->configFile);
				
				$xmlinstall = '';
				if(is_file($src . $xmlfile)) {
					$xmlinstall = $src . $xmlfile;
				} elseif (is_file($src.'admin'.DS.$xmlfile)) {
					$xmlinstall = $src.'admin'.DS.$xmlfile;
				} elseif (is_file($src.'site'.DS.$xmlfile)) {
					$xmlinstall = $src.'site'.DS.$xmlfile;
				} 
				if(is_file($xmlinstall)) {
					FileSystemHelper::cp($xmlinstall, $this->configFile, true);
				}
				break;
			case 'plugin':
				if(isset($locations[$this->extKey]) && is_dir($src.$this->extKey)) {
					FileSystemHelper::cp($src.$this->extKey, $locations[$this->extKey], true);
					$extKey = $this->extKey;
					
					if(isset($objectFilter->$extKey)) {
						$this->_applyFileRemoved($objectFilter->$extKey, $locations[$extKey]);
					}
				}
				$file = $this->extKey . ".php";
				if(is_file($src . $file)) 
					FileSystemHelper::cp($src . $file, $locations[$file], true);
				$file = $this->extKey . ".xml";
				if(is_file($src . $file)) 
					FileSystemHelper::cp($src . $file, $locations[$file], true);
				break;
		}
		
		//apply database
		if($this->type == 'component' && is_file($xmlinstall)) {
			$beforeVersion = $this->version;
			$this->setInfo(true);
			$afterVersion = $this->version;
				
			if($beforeVersion == $afterVersion) {
				//can replace current xml file with new file?
				$xml = new jaXmlParser();
				$xml->loadFile($xmlinstall);
				$obj = $xml->toObject();
				if(isset($obj->install->children->version->value)) {
					$afterVersion = $obj->install->children->version->value;
				}
			}
			
			//must check action, because user can rollback to point with newer version
			$action = ($jauc->isNewerVersion($afterVersion, $beforeVersion, false) ? 'upgrade' : 'rollback');
			//echo "{$action}: - {$beforeVersion} - {$afterVersion}<br />";
			
			if($action == 'upgrade') {
				$this->_applyDbUpgrade($src, $beforeVersion, $afterVersion);
			}
			elseif($action == 'rollback') {
				$this->_applyDbDowngrade($src, $beforeVersion, $afterVersion, $aVersions);
			}
		}
		
	}
	
	function _applyFileRemoved($objectFilter, $applyLocation) {
		//remove file base on $objectFilter
		//important note: do not remove sql files (for rollback db)
		if(count($objectFilter) > 0) {
			foreach ($objectFilter as $entry => $status) {
				$element = FileSystemHelper::clean($applyLocation . DS . $entry);
				if(is_object($status)) {
					//is folder? => remove recusive
					$this->_applyFileRemoved($objectFilter->$entry, $element);
				} else {
					if($status == 'removed' && FileSystemHelper::getExt($entry) != 'sql') {
						FileSystemHelper::rm($element);
					}
				}
			}
		}
	}
	
	function _applyDbUpgrade($src, $oldVersion, $newVersion) {
		global $jauc;
		$config = $this->config;
		$aVersions = $this->_parseListVersions();
		//sort for ascending version; default is descending
		$aVersions = array_reverse($aVersions, true);
		
		$doImport = false;
		foreach ($aVersions as $version => $versionInfo) {
			if($jauc->isNewerVersion($version, $oldVersion, true)) {
				$doImport = true;
			}
			if($doImport) {
				if(isset($versionInfo["upgrade"])) {
					$this->_importDbScript($versionInfo["upgrade"]);
				}
			}
			if($jauc->isNewerVersion($version, $newVersion, true)) {
				break;
			}
		}
	}
	
	function _applyDbDowngrade($src, $newVersion, $oldVersion, $aVersions) {
		global $jauc;
		
		$doImport = false;
		foreach ($aVersions as $version => $versionInfo) {
			if($jauc->isNewerVersion($newVersion, $version, true)) {
				$doImport = true;
			}
			if($doImport) {
				if(isset($versionInfo["rollback"])) {
					$this->_importDbScript($versionInfo["rollback"]);
				}
			}
			if($jauc->isNewerVersion($oldVersion, $version, true)) {
				break;
			}
		}
		
		//rollback db
		$backupFile = $src . "db" . DS . "backup.sql";
		if(!is_file($backupFile)) {
			$backupFile = $src . "backup.sql";
		}
		if(is_file($backupFile)) {
			$this->_importDbScript($backupFile);
		}
	}
	function _importDbScript($file) {
		$config = $this->config;
		
		$file = FileSystemHelper::clean($file);
		if(!is_file($file)) {
			return false;
		}
		$ext = strtolower(substr($file, strrpos($file, '.') + 1));
		if($ext == 'sql') {
			//echo $file;
			$oDb = new jaMysqlHelper(
							$config->get("MYSQL_HOST"), 
							$config->get("MYSQL_USER"), 
							$config->get("MYSQL_PASS"),
							$config->get("MYSQL_DB"),
							$config->get("MYSQL_DB_PREFIX"),
							$config->get("MYSQL_PATH"),
							$config->get("MYSQLDUMP_PATH")
						);
			$oDb->restore($file);
		} elseif ($ext == 'php') {
			include($file);
		}
						
	}
	
	function doBackupConflictedFiles($upgradeVersion, $folder) {
		global $jauc;
		$backupDir = $jauc->getLocalConflictPath($this->getInfo(), $folder);
		$upgradeInfo = $jauc->buildDiff($this->getFullInfo(), $upgradeVersion);
		if($backupDir !== false && $upgradeInfo !== false) {
			$conflicted = $this->_doBackupConflictedFiles($backupDir, "", $upgradeInfo);
			if(!$conflicted) {
				//dont have any conflicted files
				FileSystemHelper::rm($backupDir, true);
				return false;
			} else {
				return $folder;
			}
		}
		return false;
	}
	
	function _doBackupConflictedFiles($path, $relativePath, $data) {
		$conflicted = false;
		foreach ($data as $k=>$item){
			if( is_object($item) ){
				$subPath = $path . $k . DS;
				$relativeSubPath = $relativePath . $k . "/";
				FileSystemHelper::createDirRecursive($subPath, 0777);
				
				$subConflicted = $this->_doBackupConflictedFiles($subPath, $relativeSubPath, $item);
				if($subConflicted) {
					$conflicted = true;
				}
			}else{
				if($item == 'bmodified') {
					//the files which is modified by both user and developer
					//is conflicted file
					$conflicted = true;
					$destPath = $path . $k;
					$relativeFile = $relativePath . $k;
					$srcPath = $this->getFilePath($relativeFile);
					FileSystemHelper::cp($srcPath, $destPath);
				}
			}
		}
		return $conflicted;
	}
	
	function doBackup() {
		$config = $this->config;
		
		$workingDir = FileSystemHelper::tmpDir(null, 'ja', 0777);
		$workingDir .= $this->extKey . DS;
		if(JFolder::create($workingDir, 0777) === false) {
			return false;
		}
		$backupDir = $this->getBackupPath();
		if($backupDir === false) {
			return false;
		}
		
		$locations = $this->getLocation();
		$cnt = count($locations);
		foreach ($locations as $name => $path) {
			if($name != 'location')
				FileSystemHelper::cp($path, $workingDir.$name, true, 0777);
			else
				FileSystemHelper::cp($path, $workingDir, true, 0777);
		}
		
		$this->_backupDatabase($workingDir);
		//save all to backup file
		$createDate = date("Y-m-d H:i:s");
		$fileName = $this->extKey . "_" . date("dMY_His", strtotime($createDate));
		
		$fileNameBak = $fileName . ".zip";
		$fileBak = $backupDir.$fileNameBak;
		ArchiveHelper::zip($fileBak, $workingDir, true);
		//
		$comment = (string)(isset($this->message) ? $this->message : "");
		$info = "extKey={$this->extKey}"."\r\n";
		$info .= "version={$this->version}"."\r\n";
		$info .= "createDate={$createDate}"."\r\n";
		$info .= "comment={$comment}"."\r\n";
		
		$fileInfo = $backupDir.$fileName.".txt";
		JFile::write($fileInfo, $info);
		//
		return $fileNameBak;
	}
	
	function _backupDatabase($workingDir) {
		$config = $this->config;
		
		if($this->type == 'component') {
			if(JFolder::create($workingDir . "db", 0777) !== false) {
				$workingDir .= "db" . DS;
			}
			
			$tables = $this->_parseListTables();
			if(is_array($tables) && count($tables) > 0) {
				//backup database
				$oBak = new jaMysqlHelper(
									$config->get("MYSQL_HOST"), 
									$config->get("MYSQL_USER"), 
									$config->get("MYSQL_PASS"),
									$config->get("MYSQL_DB"),
									$config->get("MYSQL_DB_PREFIX"),
									$config->get("MYSQL_PATH"),
									$config->get("MYSQLDUMP_PATH")
								);
				
				$oBak->dump($workingDir . "backup.sql", $tables);
			}
		}
	}
	
	/**
	 * get list versions of product from xml config file
	 *
	 */
	function _parseListVersions($xmlFile = false) {
		$arrVer 	= array();
		
		if($xmlFile !== false) {
			$configFile = $xmlFile;
		} else {
			$configFile = $this->configFile;
		}
		if(!file_exists($configFile))
			return false;
		
		$xml = new jaXmlParser();
		$xml->loadFile($configFile);
		$obj = $xml->toObject();
		$parentNode = $obj->install->children;
		
		if(!isset($parentNode->jaupdater)) {
			return $arrVer;
		}
		$jaInfo = $parentNode->jaupdater->children;
		if(!isset($jaInfo->versions) || !isset($jaInfo->versions->children->version)) {
			return $arrVer;
		}
		$versions = $jaInfo->versions;
		if(!isset($versions->children->version)) {
			return $arrVer;
		}
		$listVersions = $versions->children->version;
		
		$side = (isset($versions->attributes) && isset($versions->attributes->folder)) ? $versions->attributes->folder : '';
		$path = $side == 'site' ? '' : 'administrator' . DS;
		$path = $this->getRepoPath() . $path . "components" . DS . $this->extKey . DS;
		
		
		$listVer = array();
		if(!is_array($listVersions)) {
			//only one version
			$listVer[] = $listVersions;
		} else {
			$listVer = $listVersions;
		}
		
		foreach ($listVer as $ver) {
			$id = $ver->attributes->version;
			$arrVer[$id] = array();
			$arrVer[$id]['version_name'] = $id;
			
			if(isset($ver->children->upgrade)) {
				$arrVer[$id]['upgrade'] 		= FileSystemHelper::clean($path . $ver->children->upgrade->value);
			}
			if(isset($ver->children->rollback)) {
				$arrVer[$id]['rollback'] 		= FileSystemHelper::clean($path . $ver->children->rollback->value);
			}
			if(isset($ver->children->changelogUrl)) {
				$arrVer[$id]['changelogUrl'] 		= $ver->children->changelogUrl->value;
			}
		}
		return $arrVer;
	}
	
	/**
	 * get list tables of product from xml config file
	 *
	 */
	function _parseListTables() {
		$config = $this->config;
		
		$arrTable = array();
		if(!file_exists($this->configFile))
			return false;
		
		$xml = new jaXmlParser();
		$xml->loadFile($this->configFile);
		$obj = $xml->toObject();
		$parentNode = $obj->install->children;
		
		if(!isset($parentNode->jaupdater)) {
			return $arrTable;
		}
		$jaInfo = $parentNode->jaupdater->children;
		if(!isset($jaInfo->tables) || !isset($jaInfo->tables->children->table)) {
			return $arrTable;
		}
		$tables = $jaInfo->tables->children->table;
		
		$listTables = array();
		if(!is_array($tables)) {
			//only one version
			$listTables[] = $tables;
		} else {
			$listTables = $tables;
		}
		foreach ( $listTables as $table){
			$arrTable[] = str_replace('#__', $config->get("MYSQL_DB_PREFIX"), $table->value);
		}
		
		return $arrTable;
	}

	/**
	 * path to current product' version
	 *
	 * @param unknown_type $product
	 * @return unknown
	 */
	function getLocation() {
		$path = $this->getRepoPath();
		$location = array();
		
		switch ($this->type) {
			case 'component':
				$pathAdmin = $path . "administrator" . DS . "components" . DS . $this->extKey . DS;
				if(is_dir($pathAdmin)) {
					$location['admin'] = $pathAdmin;
				}
				$pathSite = $path . "components" . DS . $this->extKey . DS;
				if(is_dir($pathSite)) {
					$location['site'] = $pathSite;
				}
				$fileConfig = basename($this->configFile);
				$location[$fileConfig] = $this->configFile;
				break;
			case 'module':
				if(isset($this->client_id) && $this->client_id) {
					$path .= "administrator" . DS;
				}
				$location['location'] = $path . "modules" . DS . $this->extKey . DS;
				break;
			case 'plugin':
				$basePath = $path . "plugins" . DS . $this->folder . DS;
				if(is_dir($basePath . $this->extKey . DS)) {
					$location[$this->extKey] = $basePath . $this->extKey . DS;
				}
				$file = $this->extKey . ".php";
				$location[$file] = $basePath . $file;
				$file = $this->extKey . ".xml";
				$location[$file] = $basePath . $file;
				break;
			case 'template':
				$location['location'] = $path . "templates" . DS . $this->extKey . DS;
				break;
			default:
				//not match any type
				return false;
				break;
		}
		/*foreach ($location as $id => $part) {
			if(!is_dir($part)) {
				unset($location[$id]);
			}
		}*/
		
		if (count($location) > 0) {
			return $location;
		}
		return false;
	}
	
	/**
	 * get path to specific file of extensions
	 *
	 */
	function getFilePath($file) {
		$location = $this->getLocation();
		if($location === false) {
			return false;
		}
		if($this->type == 'component') {
			if(substr($file, 0, strlen('site')) == 'site') {
				//file on front-end
				if(isset($location['site'])) {
					$file = preg_replace("/^site\//", "", $file);
					$file = $location['site'] . $file;
				}
			} else {
				//file on back-end
				if(isset($location['admin'])) {
					$file = preg_replace("/^admin\//", "", $file);
					$file = $location['admin'] . $file;
				}
			}
		} else {
			foreach ($location as $path) {
				if(is_file($path)) {
					if(basename($path) == basename($file)) {
						$file = $path;
						break;
					}
				} else {
					$fileTmp = FileSystemHelper::clean($path . $file);
					if(is_file($fileTmp)) {
						$file = $fileTmp;
						break;
					} else {
						//exception case (with plugin)
						$path2 = dirname($path) . DS;
						$fileTmp2 = FileSystemHelper::clean($path2 . $file);
						if(is_file($fileTmp2)) {
							$file = $fileTmp2;
							break;
						} 
					}
				}
			}
		}
		return FileSystemHelper::clean($file);
	}

	/**
   *  Use to check $entry matches any pattern in $patterns
   *
   * @param $str
   *
   * @return  boolean true if found matches pattern
   */
	function isIgnore($str) {
		foreach ($this->ignores as $key=>$pattern) {
			// Regex format
			if (!preg_match("/^\/[^\/]+\/\w+?$/" ,$pattern)) {
				$pattern = "/$pattern/";
			}
			if (preg_match($pattern, $str) > 0) {
				return true;
			}
		}
		return false;
	}
	
	/**
   * Compare 2 InfoObject
   *
   * @return  boolean true if exactly matches name & version
   */
	function compareTo($infoObject) {
		$retVal = false;
		if (!empty($infoObject)) {
			if ($this->version == $infoObject->version && $this->extKey == $infoObject->extKey) {
				$retVal = true;
			}
		}
		return $retVal;
	}

	/**
   *
   * @param $data JSON object
   */
	function loadData($data) {
		if (!empty($data)) {
			$this->type = $data->type;
			$this->name = $data->name;
			$this->extKey = $data->extKey;
			$this->version = $data->version;
			$this->crc = $data->crc;
		}
	}

	/**
   *
   * @return string
   */
	function toString() {
		return "name: $this->name - Version: $this->version";
	}
}