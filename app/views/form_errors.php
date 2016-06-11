<?php if(!empty($userErrors)): ?>
	<ul>
	<?php foreach($userErrors as $error): ?>
		<li><?=$error?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>