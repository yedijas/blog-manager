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
		<div class="title">User Detail</div>
		<div class="detail">
			<h2>Name</h2>
			<p><?php echo $userdata['fname'] . ' ' . $userdata['lname']; ?></p>
		</div>
		<div class="detail">
			<h2>Role</h2>
			<p><?php echo $this->RoleModel->RoleToText($userdata['role']); ?></p>
		</div>
		<div class="detail">
			<h2>Email</h2>
			<p><?php echo $userdata['email']; ?></p>
		</div>
		<div class="detail">
			<h2>Point</h2>
			<p><?php echo $userdata['point']; ?></p>
		</div>
	</div>
	<div class="admin_form_link">
		<?php echo (anchor('admin/deleteuser/' . $userdata['ID'], 'Delete',
			array(
				'title' => 'Delete user.',
				'class' => 'merah'))); ?> |
		<?php echo (anchor('admin/edituser/' . $userdata['ID'], 'Edit',
			array(
				'title' => 'Edit user detail.',
				'class' => 'purple'))); ?>
	</div>
</div>

<?php /** EOF **/ ?>