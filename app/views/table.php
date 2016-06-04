<table>
	<tr>
	
		<th>
			<a href='<?=$linker->makeSortUrl('name')?>'>Имя</a>
			<?=$linker->getVisual('name')?>
		</th>
		<th>
			<a href='<?=$linker->makeSortUrl('sname')?>'>Фамилия</a>
			<?=$linker->getVisual('sname')?>
		</th>
		<th>
			<a href='<?=$linker->makeSortUrl('group_num')?>'>Номер группы</a>
			<?=$linker->getVisual('group_num')?>
		</th>
		<th>
			<a href='<?=$linker->makeSortUrl('points')?>'>Баллов</a>
			<?=$linker->getVisual('points')?>
		</th>

	</tr>
	
	<?php foreach($students as $student):?>
		<?php if( (isset($userEmail)) and ($userEmail==$student->email) ):?>
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


<br>


<?php if(isset($pages)): ?>

	Страница:
	<?php for($i=1; $i<=$pages; $i++): ?>
	
	
		<?php if($i==$currentPage): ?>
			[<?=$i?>]
			
		<?php else: ?>
			[<a href='<?=$linker->makePageUrl($i)?>'><?=$i?></a>]
			
		<?php endif;?>	
		
		
	<?php endfor;?>
	
<?php endif;?>