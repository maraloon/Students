<?php header(' ', true, $errorCode); ?>
<?php use StudentList\Helpers\Util; ?>

<h1>Ошибка <?=$errorCode?></h1>
<h2>
    <?php if ($errorCode==400):?>
        Попытка взлома
    <?php elseif ($errorCode==403):?>
        У вас нет доступа к этой странице
    <?php elseif ($errorCode==404):?>
        Такой страницы не существует
    <?php elseif ($errorCode==503):?>
        Упс, что-то пошло не так!
    <?php else:?>
        Упс, что-то пошло не так!  
    <?php endif;?>
</h2>
<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php'));?>