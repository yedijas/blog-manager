<?php
/**
 * Blog Manager
 *
 * @author Aditya Situmeang, Omeoo Media
 *	@email bananab9001@gmail.com
 */
?>
<div class="blog_list">
	<div class="page_description">
		Select your blog or <?php echo (anchor('maincontroller', 'Back',
			array(
				'title' => 'Back to main page.',
				'style' => 'text-transform: uppercase;'))); ?>
	</div>
	<?php foreach ($blogList as $row){ ?>
		<div class="single_blog">
			<?php echo (anchor("maincontroller/$arg/" . $row['ID'], $row['desc'],
				array(
					'title' => 'Post on ' . $row['desc']))); ?>
		</div>
	<?php } ?>
</div>
<?php /** EOF **/ ?>