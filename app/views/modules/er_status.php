<?php use StudentList\Router; ?>

<?php if(isset($register_ok)): ?>
	<div class="col-md-12 well">
		Вы успешно зарегистрировались
	</div>
<?php endif; ?>

<?php if(isset($edit_ok)): ?>
	<div class="col-md-12 well">
		Вы успешно изменили свои данные
	</div>
<?php endif; ?>
