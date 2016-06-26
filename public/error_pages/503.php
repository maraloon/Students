<?php header(' ', true, 503); //Возвращает 503 - проверенно. Не лучше и не хуже стандартного способа ?>
<h1>Ошибка 503</h1>
<h2>Упс, что-то пошло не так!</h2>
<p>Администрация уже оповещена и предпримет меры в ближайшее время</p>
<a href='/'>На главную</a>


<br>
<?php
	//$array=file_get_contents('../errors.log',FILE_IGNORE_NEW_LINES);
	$array=file('errors.log');

	$count=count($array);

	for ($i=$count-21; $i < $count; $i++) { 
		echo $array[$i]."<br>";
	}

	//var_dump($array);
?>