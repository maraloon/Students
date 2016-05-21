<?php if($authorized): ?>
	Вошли как: Вася Пупкин
	<br>
	<a href='<?=url('edit')?>'>Редактировать</a>
	|
	<a href='<?=url('exit')?>'>Выйти</a>

<?php else: ?>
	Вы не авторизованы
	<br>
	<a href='<?=url('auth')?>'>Войти</a>
	|
	<a href='<?=url('register')?>'>Регистрация</a>
	
<?php endif; ?>