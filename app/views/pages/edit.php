<h1>Изменение данных</h1>
<br>

<?php include(Util::getAbsolutePath('/app/views/modules/form_errors.php')); ?>

<br>
<form method='post' action='<?=ViewHelper::url('edit')?>'>
	<?php include(Util::getAbsolutePath('/app/views/forms/student_form.php')); ?>
	<input type='hidden' name='token'  value='<?=ViewHelper::html($token)?>'>
	<input type='submit' value='Изменить данные'>
</form>

<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php')); ?>