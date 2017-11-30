<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="tml tml-register" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message('register'); ?>
	<?php $template->the_errors(); ?>
	<form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url('register', 'login_post'); ?>" method="post">
		<p>
			<label for="user_doctor_no<?php $template->the_instance(); ?>"><?php _e('醫師證號(非必填)', 'theme-my-login') ?></label>
			<input type="text" name="user_doctor_no" id="user_doctor_no<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('user_doctor_no'); ?>" size="20" tabindex="20" />
		</p>
		<p>
			<label for="name<?php $template->the_instance(); ?>"><?php _e('姓名', 'theme-my-login') ?></label>
			<input type="text" name="name" id="name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('name'); ?>" size="20" tabindex="20" />
		</p>

		<p>
			<label for="phone<?php $template->the_instance(); ?>"><?php _e('電話', 'theme-my-login') ?></label>
			<input type="text" name="phone" id="phone<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('phone'); ?>" size="20" tabindex="20" />
		</p>

		<p class="tml-user-email-wrap">
			<label for="user_email<?php $template->the_instance(); ?>"><?php _e('Email', 'theme-my-login'); ?></label>
			<input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('user_email'); ?>" size="20" />
		</p>

		<?php if ('email' != $theme_my_login->get_option('login_type')) : ?>
		<p class="tml-user-login-wrap">
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e('設定帳號', 'theme-my-login'); ?></label>
			<input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value('user_login'); ?>" size="20" />
		</p>
		<?php endif; ?>

		<?php do_action('register_form'); ?>

		<p class="tml-registration-confirmation" id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters('tml_register_passmail_template_message', __('Registration confirmation will be e-mailed to you.', 'theme-my-login')); ?></p>

		<p class="tml-submit-wrap">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e('送出', 'theme-my-login'); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url('register'); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="register" />
		</p>
	</form>
	<?php $template->the_action_links(array( 'register' => false,'lostpassword'=> false )); ?>
</div>
