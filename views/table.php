<?php
//для теста. Удалить
$pages=5;
$currentPage=3;
$cookie_user='Чин';
?>

<table>
	<tr>
		<th>Имя</th>
		<th>Фамилия</th>
		<th>Номер группы</th>
		<th>Баллов</th>
	</tr>
	
	<?php foreach($students as $student):?>
	
		<?php if($cookie_user==$student->name): /*заменить это дерьмо на ссылку слева от строки "Изменить"*/?>
			<tr bgcolor='green'>
		<?php else: ?>
			<tr>
		<?php endif;?>	
	
		<td><?=html($student->name)?></td>
		<td><?=html($student->sname)?></td>
		<td><?=html($student->group_num)?></td>
		<td><?=html($student->points)?></td>
		
	</tr>
	
	<?php endforeach;?>
</table>





<?php if(isset($pages)): ?>

	Страница:
	<?php for($i=1; $i<=$pages; $i++): ?>
	
	
		<?php if($i==$currentPage): ?>
			[<?=$i?>]
			
		<?php else: ?>
			[<a href='<?=$i?>.php'><?=$i?></a>]
			
		<?php endif;?>	
		
		
	<?php endfor;?>
	
<?php endif;?>