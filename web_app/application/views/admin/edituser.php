<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="dashboard">
	Fill in the form below to edit the user, or click on the button to do the tasks.
	<div class="admin_form_link">
		<?php echo (anchor('admin/deleteuser/' . $userdata['ID'], 'Delete',
			array(
				'title' => 'Delete user.',
				'class' => 'merah'))); ?> |
		<?php echo (anchor('admin/detailuser/' . $userdata['ID'], 'Detail',
			array(
				'title' => 'View user detail.',
				'class' => 'purple'))); ?>
	</div>
	<div class="admin_form">
		<?php echo form_open('admin/edituser/' . $userdata['ID']); ?>
		<?php echo form_hidden(array('ID' => $userdata['ID'])) ?>
		<div class="field">
			<div class="field_label"><?php echo (form_label('First Name','fname')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'fname',
				'id' => 'fname',
				'value' => $userdata['fname']
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Last Name','lname')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'lname',
				'id' => 'lname',
				'value' => $userdata['lname']
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Email','email')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'email',
				'id' => 'email',
				'value' => $userdata['email']
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Role','role')) ?></div>
			<div class="field_input"><?php echo (form_dropdown('role', $roles, $userdata['role'])) ?></div>
		</div>
		<div class="field">
			<div class="field_label"></div>
			<div class="field_input"><?php echo (form_submit(array(
				'name' => 'submit',
				'value' => 'Update',
				'class' => 'submit_button'
				))) ?></div>
		</div>
	</div>
	<?php echo validation_errors('<div class="error">', '</div>'); ?>
</div>

<?php /** EOF **/ ?>