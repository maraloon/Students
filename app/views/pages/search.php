<?php use \Project\Classes\Util; ?>
<?php use \Project\Classes\Router; ?>
<h1>Поиск абитуриентов</h1>
<?php include(Util::getAbsolutePath('/app/views/forms/search_form.php'));?>

Показаны только абитуриенты, найденные по запросу «<?=Util::html($find)?>».

[<a href='<?=Router::url('main')?>'>Показать всех абитуриентов</a>] <?php //будет сбрасываться сортировка, исправить ?>


<?php include(Util::getAbsolutePath('/app/views/modules/table.php'));?>
<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php'));?>