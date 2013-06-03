<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="dashboard">
	Here is the list of the blog. Please choose the link, or press the button to proceed.
	<div class="admin_form_link">
		<?php echo (anchor('admin/addblog/', 'Add blog',
			array(
				'title' => 'Add blog.',
				'class' => 'purple'))); ?>
	</div>
	<div class="blog_list">
		<div class="table_header blog_id">
			ID
		</div>
		<div class="table_header blog_name">
			Name
		</div>
		<div class="table_header blog_menu">
			Menu
		</div>
		<?php foreach($blogdata as $blog){?>
			<div class="blog_id table_content">
				<?php echo $blog['ID']; ?>
			</div>
			<div class="blog_name table_content">
				<?php echo $blog['desc']; ?>
			</div>
			<div class="blog_menu table_content">
				<?php echo (anchor('admin/detailblog/' . $blog['ID'], 'Detail',
					array(
						'title' => 'View blog detail.'))); ?> | 
				<?php echo (anchor('admin/editblog/' . $blog['ID'], 'Edit',
					array(
						'title' => 'View blog detail.'))); ?> |
				<?php if ($blog['status'] == 1){
					echo (anchor('admin/deactivateblog/' . $blog['ID'], 'Deactivate',
						array(
							'title' => 'View blog detail.',
							'class' => 'merah')));
				}else{
					 echo (anchor('admin/activateblog/' . $blog['ID'], 'Activate',
						array(
							'title' => 'View blog detail.',
							'class' => 'merah'))); 
				}?> |
				<?php echo (anchor('admin/deleteblog/' . $blog['ID'], 'Delete',
					array(
						'title' => 'View blog detail.',
							'class' => 'merah'))); ?>
			</div>
		<?php } ?>
	</div>
</div>

<?php /** EOF **/ ?>