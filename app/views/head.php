<?php if($authorized): ?>
	Вошли как: <?=$userName?> <?=$userSName?>
	<br>
	<a href='<?=url('edit')?>'>Редактировать</a>
	
	<?php
	/*
	|
	<a href='<?=url('exit')?>'>Выйти</a>
	*/
	?>

<?php else: ?>
	Вы не авторизованы
	<br>
	<?php
	/*
	<a href='<?=url('auth')?>'>Войти</a>
	|
	*/
	?>
	<a href='<?=url('register')?>'>Регистрация</a>
	
<?php endif; ?>