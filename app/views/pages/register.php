<h1>Регистрация</h1>


<?php include(Util::getAbsolutePath('/app/views/modules/form_errors.php')); ?>


<form method='post' action='<?=Router::url('register')?>'>
	<?php include(Util::getAbsolutePath('/app/views/forms/student_form.php')); ?>
	<input type='hidden' name='token'  value='<?=Util::html($token)?>'>
	<input type='submit' value='Зарегистрироваться'>
</form>

<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php')); ?>