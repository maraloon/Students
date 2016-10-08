<?php use StudentList\Helpers\Util; ?>
<?php use StudentList\Router; ?>
<div class="col-md-3 pull-right">
    <form  role="form" class="form-inline" method='get' action='<?=$router->makeUrl('search')?>'>
        <input type='text' name='find' class="form-control" placeholder='Поиск' value='<?=Util::html($find)?>'>
        <input type='submit' class="form-control" value='Найти'>
    </form>
</div>