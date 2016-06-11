<h1>Поиск абитуриентов</h1>



<?php include('head.php');?>
<br><br>




<?php include('search_form.php');?>




Показаны только абитуриенты, найденные по запросу «<?=ViewHelper::html($find)?>».
<br>
[<a href='<?=ViewHelper::url('main')?>'>Показать всех абитуриентов</a>] <?php //будет сбрасываться сортировка, исправить ?>
<br><br>




<?php include('table.php'); ?>
<?php include('bottom.php'); ?>