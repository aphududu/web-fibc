<?php 
/*
# ------------------------------------------------------------------------
# JA Quick contact module for joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

if (!defined ('_JEXEC')) {
	define( '_JEXEC', 1 );
	$path = dirname(dirname(dirname(dirname(__FILE__))));
	define('JPATH_BASE', $path );

	if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
		//Apache CGI
		$_SERVER['PHP_SELF'] =  rtrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '/\\');
	} else {
		//Others
		$_SERVER['SCRIPT_NAME'] =  rtrim(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))), '/\\');
	}
	
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

	/**
	 * CREATE THE APPLICATION
	 *
	 * NOTE :
	 */
	$mainframe =& JFactory::getApplication('administrator');
	
	/**
	 * INITIALISE THE APPLICATION
	 *
	 * NOTE :
	 */
	$mainframe->initialise(array(
		'language' => $mainframe->getUserState( "application.lang", 'lang' )
	));
	
	//JPluginHelper::importPlugin('system');
	
	// trigger the onAfterInitialise events
	//JDEBUG ? $_PROFILER->mark('afterInitialise') : null;
	//$mainframe->triggerEvent('onAfterInitialise');
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.application.module.helper');

/**
 * modJAAnimation class.
 */
$task = isset($_REQUEST['japaramaction'])?$_REQUEST['japaramaction']:'';

if($task!=''){
	$lang = JFactory::getLanguage();
	$lang->load('mod_jaquickcontact');
	JAAdminAnim::$task();
}


class JAAdminAnim{
	
	function sendEmail(){
		global $mainframe;						
		// Initialize some variables		
		$captcha = JPluginHelper::importPlugin('content','captcha');
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$json = JRequest::getVar('json', '', 'post', 'string', JREQUEST_ALLOWRAW );
		//$json = str_replace (array("\\n","\\t"), array("\n", "\t"), $json);
		//$json = str_replace ('\\', '', $json);print_r($json);
		$post = json_decode($json);

		$module	=& JModuleHelper::getModule('mod_jaquickcontact');

		$params = new JParameter( $module->params );
		
		$email = $post->email;
		$name = $post->name;
		$text = $post->text;
		$subject = $post->subject;
		$captcha = "";
		$header = "From: $email";
		$error1 = array();
		if(!eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) )
	    { 
	        $error1['email'] = JText::_("EMAIL REQUIRE");
	    }
	    if(!$name)
	    {
	        $error1['name']= JText::_("NAME REQUIRE");
	    }
	    if(!$subject)
	    {
	        $error1['subject']= JText::_("SUBJECT REQUIRE");
	    }
	    if (strlen($text)>$params->get('max_chars',1000) ||strlen($text)<5)
	    {
	    	$error1['text'] =JText::_('MESSAGE REQUIRE');
	    }
		 if ($captcha==true)
	    {
	   		$ccheck = $mainframe->triggerEvent('onValidateForm');
	    
		    if (!$ccheck ||(isset($ccheck)&&!$ccheck[0]))
		    {
		    	$error1['captcha_code'] = JText::_('CAPTCHA REQUIRE');
		    }
	    }
		$error_msg = implode("<br/>",$error1);
	    if(count($error1)==0)
		{
			$message = "
				Name: $name <br/>
				Email: $email <br/> ";
			$message .=
				"<br/>	            
				$text
				";
			$email_copy =(JRequest::getVar('email_copy',0)==1)?1:0;
			$adminemail = $mainframe->getCfg( 'mailfrom' );
			$recipient =$params->get('recipient',$adminemail);
			$mail = JFactory::getMailer();
			$errors = array();

			$mail->addRecipient( $recipient );
			if ($params->get('show_email_copy',0)&&($email_copy==1))
			{
				$mail->addRecipient( $email);
			}
			$mail->IsHTML(true);
			$mail->setSender( array( $email, $subject ) );
			$mail->setSubject( $subject );
			$mail->setBody( $message );

			$success = $mail->Send();
			if($success===true)
			{
				$thanks = $params->get('thank_msg','Thank you!') ;
				$result['successful'] = $thanks;
			}
			else
			{
				if (strtolower(get_class($success)) == 'jexception')
				{
					$status  = $success->getMessage();
				}
				else 
					$status = JText::_('Error send mail');
				$result['error'] = $status;
			}
			echo json_encode($result);
			exit;
		}
		else
		{
			$result['error'] = $error_msg;
			echo json_encode($result);
			exit;
		}
	}
}