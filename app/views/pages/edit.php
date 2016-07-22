<h1>Изменение данных</h1>

<?php include(Util::getAbsolutePath('/app/views/modules/form_errors.php')); ?>

<form role="form" class="form-horizontal" method='post' action='<?=Router::url('edit')?>'>
	<?php include(Util::getAbsolutePath('/app/views/forms/student_form.php')); ?>
	<input type='hidden' name='token'  value='<?=Util::html($token)?>'>
	<button class="btn btn-primary btn-lg" type="submit">Изменить данные</button>
</form>

<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php')); ?>