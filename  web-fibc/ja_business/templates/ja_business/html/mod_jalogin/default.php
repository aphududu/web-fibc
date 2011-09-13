<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="formlogin">
<?php if($type == 'logout') : ?>
<?php if ($params->get('greeting')) : ?>
	<div id="ja-logout" class="clearfix">
	<ul>
	<li><span class="userName"><?php echo JText::sprintf( 'HINAME', $user->get('name') ); ?></span>
	<a href="<?php echo JRoute::_("index.php?option=com_user&task=logout&return=".base64_encode('index.php'));?>" class="logout-switch">
<?php endif; ?>
<?php echo JText::_( 'BUTTON_LOGOUT'); ?></a></li>
	</ul>
	</div>
</div>
<?php else : ?>

<div id="ja-login" class="clearfix">
	<ul class="clearfix">
	<li class="view-login">
		<a class="login-switch" href="<?php echo JRoute::_('index.php?option=com_user&view=login');?>" onclick="showBox('ja-user-login','mod_login_username',this, window.event || event);return false;" title="<?php JText::_('Login');?>"><span>Login</span></a>
	
	<!--LOFIN FORM content-->
	<div id="ja-user-login" style="display: none;">
	<?php if(JPluginHelper::isEnabled('authentication', 'openid')) : ?>
        <?php JHTML::_('script', 'openid.js'); ?>
    <?php endif; ?>
    <form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="login" >
        <?php echo $params->get('pretext'); ?>
                <div class="header-module clearfix">
                	<span class="title-module">Login</span>
                </div>
                <label for="mod_login_username" class="ja-login-user clearfix">
                    <span><?php echo JText::_('Username') ?>: </span>
                    <input name="username" id="mod_login_username" type="text" class="inputbox" alt="username" size="20" />
                </label>
    
                <label for="mod_login_password" class="ja-login-password clearfix">
                    <span><?php echo JText::_('Password') ?>: </span>
                    <input type="password" id="mod_login_password" name="passwd" class="inputbox" size="20" alt="password" />
                </label>
                <label for="mod_login_remember" class="login_remember clearfix">
                	<input type="submit" name="Submit" class="button" value="Login" />
                    <input type="checkbox" name="remember" id="mod_login_remember" class="inputbox" value="yes" alt="Remember Me" />
                    <span>Remember Me</span>
                </label>
                <div class="ja-login-links clearfix" style="display: none;">
                <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>">
                <?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
                <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=remind' ); ?>">
                <?php echo JText::_('FORGOT_YOUR_USERNAME'); ?></a>
                <?php 
                    $usersConfig = &JComponentHelper::getParams( 'com_users' );
                    if ($usersConfig->get('allowUserRegistration')) : ?>
                    <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=register' ); ?>">
                        <?php echo JText::_('REGISTER'); ?></a>
                <?php endif; ?>
                </div>
        <?php echo $params->get('posttext'); ?>
    
        <input type="hidden" name="option" value="com_user" />
        <input type="hidden" name="task" value="login" />
        <input type="hidden" name="return" value="<?php echo $return; ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>
    </form>
    </div>
		
	</li>
	<?php 
				$option = JRequest::getCmd('option');
				$task = JRequest::getCmd('task');
				if($option!='com_user' && $task != 'register') { ?>
	<li class="view-register">
		<a class="register-switch" href="<?php echo JRoute::_("index.php?option=com_user&task=register");?>" onclick="showBox('ja-user-register','namemsg',this, window.event || event);return false;" >
			<span><?php echo JText::_('REGISTER');?></span>
		</a>
		<!--LOFIN FORM content-->
		<script type="text/javascript" src="<?php echo JURI::base();?>media/system/js/validate.js"></script>
		<div id="ja-user-register" style="display: none;">
				<script type="text/javascript">
				<!--
					Window.onDomReady(function(){
						document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
					});
				// -->
				</script>
				
				<?php
					if(isset($this->message)){
						$this->display('message');
					}
				?>
				
				<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">	
				<div class="header-module clearfix">
                	<span class="title-module">Register</span>
                </div>
                <label for="name" class="name clearfix">
                    <span id="namemsg" for="name"><?php echo JText::_( 'Name' ); ?>: *</span>
                    <input type="text" name="name" id="name" size="40" value="" class="inputbox required" maxlength="50" /> 
                </label>
                	
                <label for="username" class="username clearfix">
                    <span id="usernamemsg" for="username"><?php echo JText::_( 'Username' ); ?>:  *</span>
                    <input type="text" id="username" name="username" size="40" value="" class="inputbox required validate-username" maxlength="25" />
                </label>
                	
                <label for="email" class="email clearfix">
                    <span id="emailmsg" for="email"><?php echo JText::_( 'Email' ); ?>: *</span>
                    <input type="text" id="email" name="email" size="40" value="" class="inputbox required validate-email" maxlength="100" />
                </label>
                	
                <label for="password" class="password clearfix">
                    <span id="pwmsg" for="password"><?php echo JText::_( 'Password' ); ?>: *</span>
                    <input class="inputbox required validate-password" type="password" id="password" name="password" size="40" value="" />
                </label>
                <label for="password2" class="pw2msg clearfix">
                    <span id="pw2msg" for="password2"><?php echo JText::_( 'Verify Pass' ); ?>: *</span>
                    <input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" />
                </label>		
					<button class="button validate" type="hidden" style="display: none;"><?php echo JText::_('Register'); ?></button>
					<input type="button" name="task" value="Register" class="button"/>
					<span><?php echo "All fields are required(*) ."; ?></span>
					<input type="hidden" name="id" value="0" />
					<input type="hidden" name="gid" value="0" />
					<?php echo JHTML::_( 'form.token' ); ?>
				</form>
		</div>
	</li>
	</ul>
	<?php } ?>
		<!--LOFIN FORM content-->
</div>
</div>
<?php endif; ?>