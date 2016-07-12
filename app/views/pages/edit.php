<?php include(Util::getAbsolutePath('/app/views/modules/form_errors.php')); ?>

<form method='post' action='<?=Router::url('edit')?>' class="cd-form floating-labels">
	<fieldset>
		<legend>Изменение данных</legend>

		<?php include(Util::getAbsolutePath('/app/views/forms/student_form.php')); ?>
		<input type='hidden' name='token'  value='<?=ViewHelper::html($token)?>'>
		<input type='submit' value='Изменить данные'>
	</fieldset>
</form>

<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php')); ?>