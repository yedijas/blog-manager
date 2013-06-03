<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>
<div class="blog_posting">
	<div class="title">
		Upload something on <a href="<?php echo $blogData['URL'] ?>"><?php echo $blogData['desc'] ?></a>
	</div>
	<div class="form">
		<?php echo form_open_multipart('maincontroller/addphoto/' . $blogData['ID']); ?>
		<?php echo form_hidden(array('ID' => $blogData['ID'])) ?>
		<div class="field">
			<div class="field_label">file</div>
			<div class="field_input"><?php echo (form_upload(array(
				'name' => 'media',
				'id' => 'media',
				'style' => 'width: 400px'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"></div>
			<div class="field_input"><?php echo (form_submit(array(
				'name' => 'submit',
				'value' => 'Get In',
				'class' => 'submit_button'
				))) ?>
			</div>
		</div>
		<div class="field">
			<div class="field_label"></div>
			<div class="field_input">
				<?php echo (anchor('maincontroller', 'Back',
					array(
						'title' => 'Back to main page.',
						'style' => 'text-transform: uppercase;',
						'class' => 'bm_link'))); ?>
			</div>
		</div>
		<?php echo form_close(); ?>
		<?php echo validation_errors('<div class="error">', '</div>'); ?>
		<?php if (!empty($extraerror)) { ?>
			<div class="error">
				<?php echo $extraerror; ?>
			</div>
		<?php } ?>		
	</div>
</div>
<script>
    CKEDITOR.replace('content');
</script>
<?php /** EOF **/ ?>