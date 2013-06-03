<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="login_page clearfix">
	<?php echo form_open('maincontroller/login'); ?>
	
	<div class="field">
		<div class="field_label"><?php echo (form_label($fieldnames['email'],'email')) ?></div>
		<div class="field_input"><?php echo (form_input(array(
			'name' => 'email',
			'id' => 'email'
			))) ?></div>
	</div>
	<div class="field">
		<div class="field_label"><?php echo (form_label($fieldnames['password'],'password')) ?></div>
		<div class="field_input"><?php echo (form_password(array(
			'name' => 'password',
			'id' => 'password'
			))) ?></div>
	</div>
	<div class="field">
		<div class="field_label"></div>
		<div class="field_input"><?php echo (form_submit(array(
			'name' => 'submit',
			'value' => 'Get In',
			'class' => 'submit_button'
			))) ?></div>
	</div>
	<div class="field">
		<div class="field_label">&nbsp;</div>
		<div class="field_input"><?php echo (anchor('maincontroller/register', 'Register',
			array(
				'title' => 'Register Page',
				'class' => 'bm_link'))); ?></div>
	</div>
	<div class="field">
		<div class="field_label">&nbsp;</div>
		<div class="field_input"><?php echo (anchor('maincontroller', 'Back',
			array(
				'title' => 'Main Menu',
				'class' => 'bm_link'))); ?></div>
	</div>

	<?php echo form_close(); ?>

	<?php echo validation_errors('<div class="error">', '</div>'); ?>
</div>

<?php /** EOF **/ ?>