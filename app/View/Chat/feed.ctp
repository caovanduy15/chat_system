<form  method="POST">
	<span>name</span> <input type="text" name="name">
	<span>message</span> <textarea name="message" rows="3"></textarea>
	<input type="submit" value="POST">
</form>
<div>
	<?php foreach($data as $value): ?>
		<p><?php echo $value['tFeed']['name'] . " " .  $value['tFeed']['message'] . " " . $value['tFeed']['create_at']?></p>
	<?php endforeach; ?>
</div>

