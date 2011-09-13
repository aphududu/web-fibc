<?php
defined('_JEXEC') or die('Restricted access');
?>
<?php if ($status!=''):?>
<script type="text/javascript">
	alert('<?php echo $status?>');
</script>
<?php endif;?>
<div id="ja-contact-form">
	<div class="form-info">
		<?php echo $params->get('intro_text','Contact Us')?>
	</div>
	<div id="message_error"></div>
	<form  action="#" name="ja-contact" method="post" id="ja-contact" class="form-validate">
		<ul class="form-list">
			<li class="wide clearfix" id="row_contact_name">
				<label for="contact_name" >
					<?php echo @$labels['name'];?>:
				</label>
				<div class="input-box">
					<div id="error_name" class="jl_error"><?php if(isset($error['name']))echo $error['name'] ?></div>
					<input  id="contact_name" type="text" name="name" class="required validate-name" value="<?php if ($name!='')echo $name; else echo @$labels['name']; ?>" maxlength="60" size="60" onblur="if(this.value=='')this.value='<?php echo @$labels['name']?>';" onfocus="if(this.value=='<?php echo @$labels['name']?>')this.value='';" />  
				</div>
			</li>
			<li class="wide clearfix" id="row_contact_email">
				<label id="contact_emailmsg" for="contact_email">
				<?php echo @$labels['email']?>:
				</label>
				<div class="input-box">
					<div id="error_email" class="jl_error"><?php if(isset($error['email']))echo $error['email'] ?></div>
					<input class="input-text required validate-email" id="contact_email" type="text" name="email" value="<?php if ($email!='')echo $email; else echo @$labels['email']; ?>" maxlength="64" size="60" onblur="if(this.value=='')this.value='<?php echo @$labels['email'] ?>';" onfocus="if(this.value=='<?php echo @$labels['email']?>')this.value='';" />  
					<div class="small"><?php echo JText::_('NOTICE REQUEST USER REAL EMAIL');?> </div>
				</div>
			</li>
			<li class="wide clearfix" id="row_contact_subject">
				<label id="contact_subjectmsg " for="contact_subject">
					<?php echo @$labels['subject']?>:
				</label>
				<div class="input-box">
					<div id="error_subject" class="jl_error"><?php if(isset($error['error_subject']))echo $error['error_subject'] ?></div>
					<input class="input-text required validate-subject" id="contact_subject" name="subject"  value="<?php echo @$subject?>" onblur="if(this.value=='')this.value='<?php echo @$subject?>';" onfocus="if(this.value=='<?php echo @$subject;?>')this.value='';"/>
				</div>
			</li>
			<li class="wide clearfix" id="row_contact_text">
				<label id="contact_textmsg" for="contact_text">
					<?php echo @$labels['text']?>:
				</label>
				<div class="input-box">
					<div id="error_text" class="jl_error"><?php if(isset($error['error_text']))echo $error['error_text'] ?></div>
					<textarea class="textarea required validate-text" id="contact_text" name="text" rows="10" cols="40" onblur="if(this.value=='')this.value='<?php echo @$labels['text']?>';" onfocus="if(this.value=='<?php echo @$labels['text'];?>')this.value='';"><?php if($text!='') echo $text; else echo @$labels['text']?></textarea>
				</div>
			</li>
			<?php if ($params->get( 'show_email_copy' ,0)) : ?>
			<li class="wide">
				<div class="input-box">
					<input type="checkbox" name="email_copy" id="contact_email_copy" value="1"  />
					<label for="contact_email_copy">
					<?php echo JText::_( 'SEND ME A COPIED EMAIL' ); ?>
					</label>
				</div>
			</li>
			<?php endif; ?>
			<?php if ($captcha):?>
			<li class="wide" id="row-captcha">
				<div class="input-box">
				 <div id="error_captcha_code" class="jl_error"><?php if(isset($error['captcha_code']))echo $error['captcha_code'] ?></div>
			<?php 
			
				 $mainframe->triggerEvent('onAfterDisplayForm');
			?>
			</div>
			</li>
			<?php endif;?>
			<li>
				<div align="center">
					<input type="button" class="button validate" value="Send Email" id="ac-submit" name="submit"/>
				</div>
			</li>
		</ul>
		<input type="hidden" name="subject" id="subject" value="<?php echo $params->get('subject','Error 404')?>" />
		<input type="hidden" name="category" value="Error/Problems using site" />
		<input type="hidden" name="do_submit" value="1"/>
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
<script type="text/javascript">
/* <![CDATA[ */
	maxchars = <?php echo $params->get('max_chars',1000);?>;
	captcha = <?php echo intval($captcha)?>;
	var emailabel = '<?php echo @$labels['email']?>';
	var senderlabel = '<?php echo @$labels['name']?>';
	var messagelabel = '<?php echo @$labels['text']?>';
	Window.onDomReady(function(){
		el = $('ac-submit');
	el.onclick = function()
	{
		if( !el.hasClass("sm") )
		{
			var requireds = $$('.required');
			var errors = $$('.error');
			if (!errors || errors.length>0)
			{
				errors.removeClass('error');
			}
			var check = true;
			if(requireds )
			{
				requireds.each(function (el)
				{
					var handler = (el.className && el.className.search(/validate-([a-zA-Z0-9\_\-]+)/) != -1) ? el.className.match(/validate-([a-zA-Z0-9\_\-]+)/)[1] : "";
					if ((handler) && (handler != 'none') ) 
					{
						v_label = ($$('label[for='+el.id+']'));
						if(v_label) label_text = v_label[0].innerHTML;
						var value = el.getValue();
						if((label_text ==value) ||(label_text == (value+":")) || !(ja_handlers(handler,value)) ||!(el).getValue())
						{
							if($('row_'+el.id))
							{
								show_error($("error_"+handler), handler);
								$('row_'+el.id).addClass('error');
							}
							check = false;
						}
						else
						{
							$("error_"+handler).innerHTML = "";
						}
					}
				});
			}
			var captchas = $$('#row-captcha input');
			if(captchas)
			{
				captchas.each(function (input)
				{
					if(input.hasClass('required'))
					{
						if (!ja_handlers('captcha',input.value))
						{
							if(!$('row-captcha').hasClass('error'))
							{
								$('row-captcha').addClass('error');
							}
							check = false;
						}
					}
				});
			}
			if(check)
			{
				send_email_ajax();
			}
			return false;
		}
	};
});
function send_email_ajax()
{
	var xurl = "<?php echo $mainframe->getBasePath() ?>modules/<?php echo $module->module; ?>/admin/helper.php?japaramaction=sendEmail";
	var request = {
		name:$("contact_name").getValue(),
		email:$("contact_email").getValue(),
		subject:$("contact_subject").getValue(),
		text:$("contact_text").getValue(),
		captcha:""
	};
	var jSonRequest = new Json.Remote(xurl, {
		onComplete: function(result){
				requesting = false;
				contentHTML="";
				if (result.successful) {
					contentHTML += "<div class=\"success-message\"><span class=\"success-icon\">"+result.successful+"</span></div>";
					$("ac-submit").addClass("sm");
					$("ac-submit").disabled="disabled";
				}
				if (result.error) {
					contentHTML += "<div class=\"error-message\"><span class=\"error-icon\">"+result.error+"</span></div>";
				}
				$("message_error").innerHTML = contentHTML;
			}
	}).send(request);;
}
function show_error(handle, type)
{
	var message = "";
	switch (type)
	{
		case "email":
			message = "<?php  echo JText::_("EMAIL REQUIRE");?>";
			break;
		case "name":
			message = "<?php  echo JText::_("NAME REQUIRE");?>";
			break;
		case "subject":
			message = "<?php  echo JText::_("SUBJECT REQUIRE");?>";
			break;
		case "text":
			message = "<?php  echo JText::_('MESSAGE REQUIRE');?>";
			break;
		case "captcha_code":
			message = "<?php  echo JText::_('CAPTCHA REQUIRE');?>";
			break;
	}
	$(handle).innerHTML = message;
}
function remove_whitespace( str )
{
	return str.replace(/^([\s\t\n]|\&nbsp\;)+|([\s\t\n]|\&nbsp\;)+$/g, '');
}
/* ]]> */
function ja_handlers(handle,value)
{
	switch(handle)
	{
		case 'email':
		  		regex=/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
				return regex.test(value);
		  break;
		case 'name':
			  value = remove_whitespace( value );
			  regex=/^(.){5,200}$/;
			 // regex=/^([a-zA-Z0-9._-]){5,200}$/;
			return regex.test(value);
		  break;
		case 'subject':
			regex=/^(.){5,200}$/;
			return regex.test(value);
		  break;
		case 'text':
			regex=/^(.){10,200}$/;
			return regex.test(value);
			break;
		default:
		   regex=/^(.){1,200}$/;
			return regex.test(value);
			break;
		}
		return true;
}
</script>