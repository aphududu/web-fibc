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
	<form  action="#" method="post" name="ja-contact"  id="ja-contact">
	
		<div class="form-list">
		
			<div class="wide clearfix" id="row_contact_text">
				<label  for="contact_text"><?php echo @$labels['text']?></label>
				<div class="input-box">
					<div id="error_text" class="jl_error"><?php if(isset($error['error_text']))echo $error['error_text'] ?></div>
					<textarea class="textarea required validate-text" id="contact_text" name="text" rows="10" cols="40" onblur="if(this.value=='')this.value='<?php echo @$labels['text']?>';" onfocus="if(this.value=='<?php echo @$labels['text'];?>')this.value='';"><?php if($text!='') echo $text; else echo @$labels['text']?></textarea>
				</div>
			</div>
			
			<div class="guest-info clearfix">
			
				<div class="wide clearfix" id="row_contact_subject">
					<label  for="contact_subject"><?php echo @$labels['subject']?></label>
					<div class="input-box">
						<div id="error_subject" class="jl_error"><?php if(isset($error['error_subject']))echo $error['error_subject'] ?></div>
						<input class="input-text required validate-subject" id="contact_subject" name="subject"  value="<?php echo @$subject?>" />
					</div>
				</div>
				
				<div class="wide clearfix" id="row_contact_name">
					<label for="contact_name" ><?php echo @$labels['name'];?></label>
					<div class="input-box">
						<div id="error_name" class="jl_error"><?php if(isset($error['name']))echo $error['name'] ?></div>
						<input  id="contact_name" type="text" name="name" class="required validate-name" value="<?php if ($name!='')echo $name; else echo @$labels['name']; ?>" maxlength="60" size="60" onblur="if(this.value=='')this.value='<?php echo @$labels['name']?>';" onfocus="if(this.value=='<?php echo @$labels['name']?>')this.value='';" />  
					</div>
				</div>
				
				<div class="wide clearfix" id="row_contact_email">
					<label id="contact_emailmsg" for="contact_email"><?php echo @$labels['email']?></label>
					<div class="input-box">
						<div id="error_email" class="jl_error"><?php if(isset($error['email']))echo $error['email'] ?></div>
						<input class="input-text required validate-email" id="contact_email" type="text" name="email" value="<?php if ($email!='')echo $email; else echo @$labels['email']; ?>" maxlength="64" size="60" onblur="if(this.value=='')this.value='<?php echo @$labels['email'] ?>';" onfocus="if(this.value=='<?php echo @$labels['email']?>')this.value='';" />  
						<div class="small"><?php echo JText::_('NOTICE REQUEST USER REAL EMAIL');?> </div>
					</div>
				</div>
				
				<?php if ($params->get( 'show_email_copy' ,0)) : ?>
				<div class="wide">
					<div class="input-box">
						<input type="checkbox" name="email_copy" id="contact_email_copy" value="1"  />
						<label for="contact_email_copy"><?php echo JText::_( 'SEND ME A COPIED EMAIL' ); ?></label>
					</div>
				</div>
				<?php endif; ?>
				
				<?php if ($captcha):?>
				<div class="wide" id="row-captcha">
					 <div id="error_captcha_code" class="jl_error"><?php if(isset($error['captcha_code']))echo $error['captcha_code'] ?></div>
					<?php 
						$mainframe->triggerEvent('onAfterDisplayForm');
					?>
				</div>
				<?php endif;?>
				<div class="btn-submit clearfix">
					<input type="button" class="button validate" value="Send Email" id="ac-submit" name="bt_submit" />
				</div>
			</div>
			
		</div>
		
		<input type="hidden" name="category" value="Error/Problems using site" />
		<input type="hidden" name="do_submit" value="1" />
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
							$('row_'+el.id).addClass('error');
						}
						check = false;
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
			var f = document.getElementById('ja-contact');
			f.submit();
			return true;
		}
		return false;
	};
});
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
			  /*regex=/^([a-zA-Z0-9]){5,200}$/;
			return regex.test(value);*/
			  return (value.length > 0);
		  break;
		case 'subject':
			regex=/^(.){5,200}$/;
			
			return regex.test(value);
		  break;
		case 'text':
			return (value.length > 0);
			/*regex=/^(.){10,1000}$/;
			alert(regex.test(value));
			return regex.test(value);*/
			break;
		default:
		   regex=/^(.){1,200}$/;
			return regex.test(value);
			break;
		}
		return true;
}
</script>