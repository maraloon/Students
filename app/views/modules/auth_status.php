<?php if($isAuthorized): ?>
	Вошли как: <?=$user['name']?> <?=$user['sname']?>
	<a href='<?=Router::url('edit')?>'>Редактировать</a>
<?php else: ?>
	Вы не авторизованы
	<a href='<?=Router::url('register')?>'>Регистрация</a>
<?php endif; ?>