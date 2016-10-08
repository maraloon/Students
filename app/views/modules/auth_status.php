<?php use StudentList\Router; ?>
<div class="col-md-3 well">
    <?php if($isAuthorized): ?>
        Вошли как: <?=$user->name?> <?=$user->sname?>
        <a href='edit'>Редактировать</a>
    <?php else: ?>
        Вы не авторизованы
        <a href='register'>Регистрация</a>
    <?php endif; ?>
</div>