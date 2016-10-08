<?php use StudentList\Helpers\Util; ?>
<?php use StudentList\Router; ?>
<h1>Поиск абитуриентов</h1>
<?php include(Util::getAbsolutePath('/app/views/forms/search_form.php'));?>

Показаны только абитуриенты, найденные по запросу «<?=Util::html($find)?>».

[<a href='main'>Показать всех абитуриентов</a>] <?php //будет сбрасываться сортировка, исправить ?>


<?php include(Util::getAbsolutePath('/app/views/modules/table.php'));?>
<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php'));?>