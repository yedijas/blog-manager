
<div id="mediaList" class="medialist">
	<?php foreach($mediaList as $key => $value){ ?>
		<?php //echo form_open('maincontroller/addpost/' . $blogData['ID']); ?>
		<div class="singleMedia">
			<div class="gambarMedia">
				<img src="<?php echo $value; ?>">
			</div>
			<div class="contentMedia">
				Title: <?php echo $key ?></br>
				<a class="orange hand" cktarget="<?php echo $value; ?>">SELECT</a>
			</div>
		</div>
	<?php } ?>
</div>
<script>
	$(document).ready(function(){
		$('a').each(function(){
			$imageURL = $(this).attr('cktarget');
			$(this).click(function(){
				redirectToMain($imageURL)
			});
		});
	});

	function redirectToMain($imageURL){
		window.opener.CKEDITOR.tools.callFunction(1, $imageURL, 'Image selected!');
	}
</script>