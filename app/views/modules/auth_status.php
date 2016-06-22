<?php if($authorized): ?>
	
	Вошли как: <?=$user['name']?> <?=$user['sname']?>
	<br>
	<a href='<?=ViewHelper::url('edit')?>'>Редактировать</a>


<?php else: ?>
	Вы не авторизованы
	<br>
	<a href='<?=ViewHelper::url('register')?>'>Регистрация</a>
	
<?php endif; ?>