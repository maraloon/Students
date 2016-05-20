<h1>Регистрация</h1>
<br>

<?php //print_r($s); ?>

<?php if(!empty($valid->errors)): ?>
	<ul>
	<?php foreach($valid->errors as $error): ?>
		<li><?=$error?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<form method='post' action='<?=url('register')?>'>
	<?php include('student_form.php'); ?>
	<input type='hidden' name='token'  value='<?=html($token)?>'>
	<input type='submit' value='Зарегистрироваться'>
</form>