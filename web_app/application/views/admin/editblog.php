<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="dashboard">
	Fill in the form below to edit the blog, or click on the button to do the tasks.
	<div class="admin_form_link">
		<?php if ($blog['status'] == 1){
			echo (anchor('admin/deactivateblog/' . $blog['ID'], 'Deactivate',
				array(
					'title' => 'Deactivate blog.',
					'class' => 'merah')));
		}else{
			echo (anchor('admin/activateblog/' . $blog['ID'], 'Activate',
				array(
					'title' => 'Activate blog.',
					'class' => 'merah'))); 
		}?> |
		<?php echo (anchor('admin/deleteblog/' . $blog['ID'], 'Delete',
			array(
				'title' => 'Delete blog.',
				'class' => 'merah'))); ?> |
		<?php echo (anchor('admin/detailblog/' . $blog['ID'], 'Detail',
			array(
				'title' => 'View blog detail.',
				'class' => 'purple'))); ?>
	</div>
	<div class="admin_form">
		<?php echo form_open('admin/editblog'); ?>
		<?php echo form_hidden(array('ID' => $blog['ID'])) ?>
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