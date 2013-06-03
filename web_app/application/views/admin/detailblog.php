<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="dashboard">
	<div class="blog_detail">
		<div class="title"><a href="<?php echo $blogdata['URL'] ?>"><?php echo $blogdata['desc']; ?></a> Detail</div>
		<div class="detail">
			<h2>Blog Name (Registered in database)</h2>
			<p><?php echo $blogdata['desc']; ?></p>
		</div>
		<div class="detail">
			<h2>Blog URL</h2>
			<p><?php echo $blogdata['URL']; ?></p>
		</div>
		<div class="detail">
			<h2>API Key</h2>
			<p><?php echo $blogdata['key']; ?></p>
		</div>
		<div class="detail">
			<h2>Status</h2>
			<p><?php
				if ($blogdata['status'] == 1){
					echo "Active";
				}else{
					echo "Deactivated";
				}
			?></p>
		</div>
	</div>
	<div class="admin_form_link">
		<?php if ($blogdata['status'] == 1){
			echo (anchor('admin/deactivateblog/' . $blogdata['ID'], 'Deactivate',
				array(
					'title' => 'Deactivate blog.',
					'class' => 'merah')));
		}else{
			echo (anchor('admin/activateblog/' . $blogdata['ID'], 'Activate',
				array(
					'title' => 'Activate blog.',
					'class' => 'merah'))); 
		}?> |
		<?php echo (anchor('admin/deleteblog/' . $blogdata['ID'], 'Delete',
			array(
				'title' => 'Delete blog.',
				'class' => 'merah'))); ?> |
		<?php echo (anchor('admin/editblog/' . $blogdata['ID'], 'Edit',
			array(
				'title' => 'Edit blog detail.',
				'class' => 'purple'))); ?>
	</div>
</div>

<?php /** EOF **/ ?>