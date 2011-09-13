<?php
defined('_JEXEC') or die('Restricted access');

	$do_submit = isset($_POST['do_submit'])?$_POST['do_submit']:0;
	$status =null;
	global $mainframe;
	$captcha = JPluginHelper::importPlugin('content','captcha');
	$user = JFactory::getUser();
	$name = isset($user->username)?$user->username:'';
	$email = isset($user->email)?$user->email:'';
	$text ='';
	$labels = array();
	$use_ajax = $params->get("use_ajax","0");
	$labels['name'] = $params->get('sender_label',JText::_( 'ENTER YOUR NAME' ));
	$labels['email'] =$params->get('email_label',JText::_( 'EMAIL ADDRESS' ));
	$labels['subject'] =$params->get('subject_label',JText::_( 'ENTER YOUR SUBJECT') );
	$labels['text'] =$params->get('message_label',JText::_( 'ENTER YOUR MESSAGE' ));
	$subject = $params->get('subject');
	$error = array();
	if($do_submit) 
	{
		$name = stripslashes(JRequest::getVar('name',$name));
		$email = stripslashes(JRequest::getVar('email',$email));
		$subject = stripslashes(JRequest::getVar('subject',$subject));
		$text = JRequest::getString('text');
	   	if(!eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) )
	    { 
	        $error['email'] = JText::_("EMAIL REQUIRE");
	    }
	    if(!$name)
	    {
	        $error['name']= JText::_("NAME REQUIRE");
	    }
	    if(!$subject)
	    {
	        $error['subject']= JText::_("SUBJECT REQUIRE");
	    }
	    if (strlen($text)>$params->get('max_chars',1000) ||strlen($text)<5)
	    {
	    	$error['text'] =JText::_('MESSAGE REQUIRE');
	    }
	    if ($captcha==true)
	    {
	   		$ccheck = $mainframe->triggerEvent('onValidateForm');
	    
		    if (!$ccheck ||(isset($ccheck)&&!$ccheck[0]))
		    {
		    	$error['captcha_code'] = JText::_('CAPTCHA REQUIRE');
		    }
	    }
	    if(count($error)==0)
	    {
	        $header = "From: $email";
	
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
	            $url_redirect =$params->get('redirect_url','index.php');
	            return $mainframe->redirect($url_redirect,$thanks);
	        }
	        else
	        {
	        	if (strtolower(get_class($success)) == 'jexception')
	        	{
	        		$status  = $success->getMessage();
	        	}
	            else $status = JText::_('Error send mail');
	        }
	
	    }
	    unset($_POST["do_submit"]);
	    unset($do_submit);
	   
	}    
	JHTML::_('stylesheet', 'style.css','modules/mod_jaquickcontact/assets/',true); 
	$templatename = $mainframe->getTemplate();
    if (file_exists(JPATH_THEMES.DS.$templatename.DS.'css'.DS.'mod_jaquickcontact.css'))
    {
    	JHTML::_('stylesheet', 'mod_jaquickcontact.css',$mainframe->getBasePath() . 'templates/'.$templatename.'/css/');
    }
	if(!empty($use_ajax) && $use_ajax == '1')
	{
		require(JModuleHelper::getLayoutPath('mod_jaquickcontact','ajax_layout'));
	}
	else
	{
		require(JModuleHelper::getLayoutPath('mod_jaquickcontact'));
	}

