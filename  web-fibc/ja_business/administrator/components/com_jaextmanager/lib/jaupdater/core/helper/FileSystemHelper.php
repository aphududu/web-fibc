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

/**
 * Helper for FileSystem functions
 *
 */
class FileSystemHelper {
	/**
	 * @desc clean path (remove duplicate directory separator)
	 *
	 * @param unknown_type $path
	 * @param unknown_type $ds
	 * @return unknown
	 */
	function clean($path, $ds=DS)
	{
		$path = trim($path);

		if (empty($path)) {
			$path = JPATH_ROOT;
		} else {
			// Remove double slashes and backslahses and convert all slashes and backslashes to DS
			$path = preg_replace('#[/\\\\]+#', $ds, $path);
		}

		return $path;
	}
	
	function createDirRecursive($path, $mod = 0700) {
		$path = $path . DS;
		$path = FileSystemHelper::clean($path, DS);
		if(!is_dir($path)) {
			$aPaths = explode(DS, $path);
			
			$path = '';
			foreach ($aPaths as $subPath) {
				$path .= $subPath . DS;
				if(!is_dir($path)) {
					if(JFolder::create($path, $mod) === false) {
						return false;
					}
				}
			}
		}
		return $path;
	}

	/**
   * Create a temporary directory
   *
   * @param $dir  string based dir to create temporary directory
   * @param $prefix  string prefix for temporary directory name
   * @param $mod  int unix permission formated number
   *
   * @return  string path to directory
   */
	function tmpDir($dir = null, $prefix = null, $mod = 0700) {
		$dir = empty($dir) ? ja_sys_get_temp_dir() : $dir;
		$tmpName = jaTempnam($dir, $prefix);
		
		if (is_file($tmpName)) {
			JFile::delete($tmpName);
		}
		if (!is_dir($tmpName)) {
			JFolder::create($tmpName, $mod);
		}
		return FileSystemHelper::clean($tmpName . DS);
	}

	/**
   *
   *  Support remove a file or directory recursively
   *
   * @param $path  string path to file or directory to be remove
   * @param $recursive  boolean remove directory recursively or not
   *
   * @return  boolean true if success, otherwise return false
   */
	function rm($path, $recursive = false) {
		$retVal = true;
		$path = FileSystemHelper::clean($path);
		if (is_dir($path)) {
			$dh = opendir($path);
			while (($entry = readdir($dh)) !== false) {
				if ($entry == "." || $entry == "..") {
					continue;
				}
				$entry = FileSystemHelper::clean($path.DS.$entry);
				if (is_dir($entry) && $recursive === true) {
					if (FileSystemHelper::rm($entry, $recursive) === false) {
						$retVal = false;
					}
				} else if (is_file($entry)) {
					if (JFile::delete($entry) === false) {
						$retVal = false;
					}
				}
			}
			closedir($dh);
			if (@rmdir($path) === false) {
				$retVal = false;
			}
		} else if (is_file($path)) {
			if (JFile::delete($path) === false) {
				$retVal = false;
			}
		}

		return $retVal;
	}

	/**
   *  Advanced copy file and directory with support recursively mode
   *
   * @param $src  string source file or directory
   * @param $dest  string destination file or directory
   * @param $recursive  boolean recursive mode
   * @param $mod  int unix permission formated number
   *
   * @return  boolean true if success, otherwise return false
   */
	function cp($src, $dst, $recursive = false, $mod = 0700, $exclude = array('.svn', 'CVS')) {
		$retVal = true;
		if(is_dir($src)) {
			$retVal = JFolder::copy($src, $dst, '', true);
		} elseif(is_file($src)) {
			/*if(is_dir($dst)) {
				$dst = FileSystemHelper::clean($dst . DS) . basename($src);
			}*/
			$retVal = JFile::copy($src, $dst);
		}
	    return $retVal;
	}

	/**
   *  Advanced move file and directories with support recursively mode
   *
   * @param $src  string source file or directory
   * @param $dest  string destination file or directory
   * @param $recursive  boolean recursive mode
   * @param $mod  int unix permission formated number
   *
   * @return  boolean true if success, otherwise return false
   */
	function mv($src, $dest, $recursive = false, $mod = 0700) {
		if (FileSystemHelper::cp($src, $dest, $recursive, $mod) === false) {
			return false;
		}
		if (is_dir($src) && preg_match("/\/$/", $src) > 0) {
			$rv = true;
			$dh = opendir($src);
			while (($entry = readdir($dh)) !== false) {
				if (FileSystemHelper::rm($src.$entry, true) === false) {
					$rv = false;
				}
			}
			return $rv;
		} else {
			return FileSystemHelper::rm($src, $dest, $recursive);
		}
	}
	
	function files($path, $filter = '.', $recurse = false, $fullpath = false, $exclude = array('.svn', 'CVS'))
	{
		// Initialize variables
		$arr = array();

		// Check to make sure the path valid and clean
		$path = FileSystemHelper::clean($path);

		// Is the path a folder?
		if (!is_dir($path)) {
			return false;
		}

		// read the source directory
		$handle = opendir($path);
		while (($file = readdir($handle)) !== false)
		{
			if (($file != '.') && ($file != '..') && (!in_array($file, $exclude))) {
				$dir = $path . DS . $file;
				$isDir = is_dir($dir);
				if ($isDir) {
					if ($recurse) {
						if (is_integer($recurse)) {
							$arr2 = FileSystemHelper::files($dir, $filter, $recurse - 1, $fullpath);
						} else {
							$arr2 = FileSystemHelper::files($dir, $filter, $recurse, $fullpath);
						}
						
						$arr = array_merge($arr, $arr2);
					}
				} else {
					if (preg_match("/$filter/", $file)) {
						if ($fullpath) {
							$arr[] = $path . DS . $file;
						} else {
							$arr[] = $file;
						}
					}
				}
			}
		}
		closedir($handle);

		asort($arr);
		return $arr;
	}
	/**
	 * Gets the extension of a file name
	 */
	function getExt($file) {
		$dot = strrpos($file, '.') + 1;
		return substr($file, $dot);
	}
	/**
	 * Strips the last extension of a file name
	 *
	 * @param unknown_type $file
	 * @return unknown
	 */
	function stripExt($file) {
		return preg_replace('#\.[^.]*$#', '', $file);
	}
}
