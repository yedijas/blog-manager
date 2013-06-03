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
		Post something on <a href="<?php echo $blogData['URL'] ?>"><?php echo $blogData['desc'] ?></a>
	</div>
	<div class="form">
		<?php echo form_open('maincontroller/addpost/' . $blogData['ID']); ?>
		<?php echo form_hidden(array('ID' => $blogData['ID'])) ?>
		<div class="field">
			<div class="field_label"><?php echo (form_label($fieldnames['title'],'title')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'title',
				'id' => 'title',
				'style' => 'width: 400px'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label($fieldnames['content'],'content')) ?> <span class="orange">(Use the list of images URL below to show images in editor)</span></div>
			<div class="field_input"><?php echo (form_textarea(array(
				'name' => 'content',
				'id' => 'content',
				'style' => 'width: 400px; max-width: 80%'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label($fieldnames['tag'],'tag')) ?></div>
			<div class="field_input"><?php echo (form_input(array(
				'name' => 'tag',
				'id' => 'tag',
				'style' => 'width: 400px'
				))) ?></div>
		</div>
		<div class="field">
			<div class="field_label"><?php echo (form_label($fieldnames['category'],'category')) ?></div>
			<div class="field_input categories">
				<?php foreach ($categories as $catID => $catName){ ?>
					<input type="checkbox" name="category[]" value="<?php echo $catID ?>"><?php echo $catName; ?><br>
				<?php } ?>
			</div>
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
		<div style="width:100%;">
			&nbsp;
		</div>			
	</div>
</div>
<script>
    CKEDITOR.replace('content', {
		filebrowserBrowseUrl: "<?php echo base_url(); ?>index.php/maincontroller/browse/<?php echo $blogData['ID'];?>",
		filebrowserUploadUrl: "<?php echo base_url(); ?>index.php/maincontroller/addphoto/<?php echo $blogData['ID'];?>" 
	});
</script>
<?php /** EOF **/ ?>