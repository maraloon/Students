<h1>Поиск абитуриентов</h1>

<?php include(Util::getAbsolutePath('/app/views/modules/header.php'));?>
<br><br>

<?php include(Util::getAbsolutePath('/app/views/forms/search_form.php'));?>

Показаны только абитуриенты, найденные по запросу «<?=ViewHelper::html($find)?>».
<br>
[<a href='<?=Router::url('main')?>'>Показать всех абитуриентов</a>] <?php //будет сбрасываться сортировка, исправить ?>
<br><br>

<?php include(Util::getAbsolutePath('/app/views/modules/table.php'));?>
<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php'));?>