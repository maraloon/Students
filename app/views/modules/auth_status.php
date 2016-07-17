<?php if($isAuthorized): ?>
	
	Вошли как: <?=$user['name']?> <?=$user['sname']?>
	<br>
	<a href='<?=Router::url('edit')?>'>Редактировать</a>


<?php else: ?>
	Вы не авторизованы
	<br>
	<a href='<?=Router::url('register')?>'>Регистрация</a>
	
<?php endif; ?>