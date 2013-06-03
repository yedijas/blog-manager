<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="dashboard">
	Here is the list of the users. Please choose the link, or press the button to proceed.
	<div class="admin_form_link">
		<?php echo (anchor('admin/adduser/', 'Add user',
			array(
				'title' => 'Add user.',
				'class' => 'purple'))); ?>
	</div>
	<div class="blog_list">
		<div class="table_header blog_id">
			ID
		</div>
		<div class="table_header blog_name">
			Email
		</div>
		<div class="table_header blog_menu">
			Menu
		</div>
		<?php foreach($userdata as $blog){?>
			<div class="blog_id table_content">
				<?php echo $blog['ID']; ?>
			</div>
			<div class="blog_name table_content">
				<?php echo $blog['email']; ?>
			</div>
			<div class="blog_menu table_content">
				<?php echo (anchor('admin/detailuser/' . $blog['ID'], 'Detail',
					array(
						'title' => 'View blog detail.'))); ?> | 
				<?php echo (anchor('admin/edituser/' . $blog['ID'], 'Edit',
					array(
						'title' => 'View blog detail.'))); ?> |
				<?php echo (anchor('admin/deleteuser/' . $blog['ID'], 'Delete',
					array(
						'title' => 'View blog detail.',
							'class' => 'merah'))); ?>
			</div>
		<?php } ?>
	</div>
</div>

<?php /** EOF **/ ?>