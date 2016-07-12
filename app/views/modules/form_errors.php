<?php if(!empty($userErrors)): ?>
	<?php foreach($userErrors as $error): ?>
		<div class="error-message">
			<p><?=$error?></p>
		</div>
	<?php endforeach; ?>
<?php endif; ?>