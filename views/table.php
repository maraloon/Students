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
	
	<?php foreach($students as $k=>$v):?>
	
		<?php if($cookie_user==$v->name): /*заменить это дерьмо на ссылку слева от строки "Изменить"*/?>
			<tr bgcolor='green'>
		<?php else: ?>
			<tr>
		<?php endif;?>	
	
		<td><?=$v->name?></td>
		<td><?=$v->sname?></td>
		<td><?=$v->group_num?></td>
		<td><?=$v->points?></td>
		
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