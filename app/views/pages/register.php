<h1>Регистрация</h1>
<br>

<?php include('form_errors.php'); ?>

<br>
<form method='post' action='<?=ViewHelper::url('register')?>'>
	<?php include('student_form.php'); ?>
	<input type='hidden' name='token'  value='<?=ViewHelper::html($token)?>'>
	<input type='submit' value='Зарегистрироваться'>
</form>

<?php include('bottom.php'); ?>