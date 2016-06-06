<?php if($authorized): ?>
	
	Вошли как: <?=$userName?> <?=$userSName?>
	<br>
	<a href='<?=ViewHelper::url('edit')?>'>Редактировать</a>


<?php else: ?>
	Вы не авторизованы
	<br>
	<a href='<?=ViewHelper::url('register')?>'>Регистрация</a>
	
<?php endif; ?>