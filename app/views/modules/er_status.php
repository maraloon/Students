<?php use StudentList\Router; ?>

<?php if(isset($registerOk)): ?>
    <div class="col-md-12 well">
        Вы успешно зарегистрировались
    </div>
<?php endif; ?>

<?php if(isset($editOk)): ?>
    <div class="col-md-12 well">
        Вы успешно изменили свои данные
    </div>
<?php endif; ?>
