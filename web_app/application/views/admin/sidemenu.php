<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="admin_menu clearfix">
	<div>
		<?php echo (anchor('admin', 'Dashboard',
			array(
				'title' => 'Admin dashboard'))); ?>
	</div>
	<div>
		<?php echo (anchor('admin/indexblog', 'Blogs',
			array(
				'title' => 'View registered blogs.'))); ?>
	</div>
	<div>
		<?php echo (anchor('admin/indexuser', 'Users',
			array(
				'title' => 'View registered users.'))); ?>
	</div>
	<div>
		<?php echo (anchor('maincontroller/index', 'Main Site',
			array(
				'title' => 'Main site.'))); ?>
	</div>
	<div>
		<?php echo (anchor('maincontroller/logout', 'Logout',
			array(
				'title' => 'Log Out'))); ?>
	</div>
</div>

<?php /** EOF **/ ?>