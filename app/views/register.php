<h1>Регистрация</h1>
<br>

<?php if(!empty($userErrors)): ?>
	<ul>
	<?php foreach($userErrors as $error): ?>
		<li><?=$error?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<form method='post' action='<?=ViewHelper::url('register')?>'>
	<?php include('student_form.php'); ?>
	<input type='hidden' name='token'  value='<?=ViewHelper::html($token)?>'>
	<input type='submit' value='Зарегистрироваться'>
</form>