<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="dashboard">
	Fill in the form below to create user, or click on the button to do the tasks.
	<div class="admin_form">
		<?php echo form_open('admin/adduser'); ?>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Email','email')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'email',
				'id' => 'email'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Password','password')) ?></div>
			<div class="field_input"><?php echo (form_password(array(
				'name' => 'password',
				'id' => 'password'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Confirm Password','confirm')) ?></div>
			<div class="field_input"><?php echo (form_password(array(
				'name' => 'confirm',
				'id' => 'confirm'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('First Name','fname')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'fname',
				'id' => 'fname'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Last Name','lname')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'lname',
				'id' => 'lname'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Role','role')) ?></div>
			<div class="field_input"><?php echo (form_dropdown('role', $roles)) ?></div>
		</div>
		<div class="field">
			<div class="field_label"></div>
			<div class="field_input"><?php echo (form_submit(array(
				'name' => 'submit',
				'value' => 'Create',
				'class' => 'submit_button'
				))) ?></div>
		</div>
	</div>
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
</div>

<?php /** EOF **/ ?>