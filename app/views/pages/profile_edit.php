<?php use StudentList\Helpers\Util; ?>
<?php use StudentList\Router; ?>
<h1>
    <?php if($action=='register') :?>
        Регистрация
    <?php else: ?>
        Изменение данных
    <?php endif;?>
</h1>

<?php include(Util::getAbsolutePath('/app/views/modules/form_errors.php')); ?>

<form role="form" class="form-horizontal" method='post' action='<?=$router->makeUrl($action)?>'>
    <?php include(Util::getAbsolutePath('/app/views/forms/student_form.php')); ?>
    <input type='hidden' name='token'  value='<?=Util::html($token)?>'>
    <button class="btn btn-primary btn-lg" type="submit">
        <?php if($action=='register') :?>
            Зарегистрироваться
        <?php else: ?>
            Изменить данные
        <?php endif;?>  
    </button>
</form>

<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php')); ?>