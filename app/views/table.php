<table>
	<tr>
	
		<th>
			<a href='<?=$viewer->makeSortUrl('name')?>'>Имя</a>
			<?=$viewer->showSortOrder('name')?>
		</th>

		<th>
			<a href='<?=$viewer->makeSortUrl('sname')?>'>Фамилия</a>
			<?=$viewer->showSortOrder('sname')?>
		</th>

		<th>
			<a href='<?=$viewer->makeSortUrl('group_num')?>'>Номер группы</a>
			<?=$viewer->showSortOrder('group_num')?>
		</th>

		<th>
			<a href='<?=$viewer->makeSortUrl('points')?>'>Баллов</a>
			<?=$viewer->showSortOrder('points')?>
		</th>

	</tr>
	
	<?php foreach($students as $student):?>
		<?php if( (isset($userEmail)) and ($userEmail==$student->email) ):?>
			<tr bgcolor='green'>
		<?php else: ?>
			<tr>	
		<?php endif;?>
		

		<td><?=ViewHelper::html($student->name,$find)?></td>
		<td><?=ViewHelper::html($student->sname,$find)?></td>
		<td><?=ViewHelper::html($student->group_num,$find)?></td>
		<td><?=ViewHelper::html($student->points,$find)?></td>
		
	</tr>
	
	<?php endforeach;?>
</table>


<br>


<?php if(isset($pages)): ?>

	Страница:
	<?php for($i=1; $i<=$pages; $i++): ?>
	
	
		<?php if($i==$currentPage): ?>
			[<?=$i?>]
			
		<?php else: ?>
			[<a href='<?=$viewer->makePageUrl($i)?>'><?=$i?></a>]
			
		<?php endif;?>	
		
		
	<?php endfor;?>
	
<?php endif;?>