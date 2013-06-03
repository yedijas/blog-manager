<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="dashboard">
	<div class="admin_form">
		<?php echo form_open('admin/editblog'); ?>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Blog Name','desc')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'desc',
				'id' => 'desc',
				'value' => $blog['desc']
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('Blog URL','URL')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'URL',
				'id' => 'URL',
				'value' => $blog['URL']
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label('API Key','key')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'key',
				'id' => 'key',
				'value' => $blog['key']
				))) ?></div>
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