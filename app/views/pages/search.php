<?php use StudentList\Helpers\Util; ?>
<h1>Поиск абитуриентов</h1>
<?php include(Util::getAbsolutePath('/app/views/forms/search_form.php'));?>

Показаны только абитуриенты, найденные по запросу <i>«<?=Util::html($find)?>»</i>.

<a href='<?=Util::html($urlMaker->makeToMainUrl())?>'>Показать всех абитуриентов</a>

<?php include(Util::getAbsolutePath('/app/views/modules/table.php'));?>
<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php'));?>