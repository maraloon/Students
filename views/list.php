<table>
	<tr>
		<th>Имя</th>
		<th>Фамилия</th>
		<th>Номер группы</th>
		<th>Баллов</th>
	</tr>
	
	<?php foreach($students as $k=>$v):?>
	<tr>
		<td><?=$v->name?></td>
		<td><?=$v->sname?></td>
		<td><?=$v->group_num?></td>
		<td><?=$v->points?></td>
	</tr>
	<?php endforeach;?>
</table>