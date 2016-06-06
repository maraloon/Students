<h1>Изменение данных</h1>

<?php if(!empty($userErrors)): ?>
	<ul>
	<?php foreach($userErrors as $error): ?>
		<li><?=$error?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<br>
<form method='post' action='<?=ViewHelper::url('edit')?>'>
	<?php include('student_form.php'); ?>
	<input type='hidden' name='token'  value='<?=ViewHelper::html($token)?>'>
	<input type='submit' value='Изменить данные'>
</form>