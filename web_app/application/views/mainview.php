<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>

<div class="menu clearfix">
	<?php if ($this->session->userdata('cemail') === FALSE){ ?>
	<div>
		<?php echo (anchor('maincontroller/login', 'Login',
			array(
				'title' => 'Login Page'))); ?>
	</div>
	<div>
		<?php echo (anchor('maincontroller/register', 'Register',
			array(
				'title' => 'Register Page'))); ?>
	</div>
	<?php }else{ ?>
	<div>
		<?php echo (anchor('maincontroller/logout', 'Logout',
			array(
				'title' => 'Log Out'))); ?>
	</div>
	<div>
		<?php echo (anchor('maincontroller/chooseblog/addpost', 'Post',
			array(
				'title' => 'Post Something Up!'))); ?>
	</div>
	<?php } ?>
	<?php if ($this->session->userdata('crole') == 1) { ?>
	<div>
		<?php echo (anchor('admin/index', 'Admin',
			array(
				'title' => 'Admin Panel'))); ?>
	</div>
	<?php } ?>
</div>

<?php /** EOF **/ ?>