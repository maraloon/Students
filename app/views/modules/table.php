<?php if(count($students)==0): ?>
	Совпадений не найдено
<?php else: ?>

	<table class="table table-striped">
		
		<thead>
			<tr>
				<th>
					<a href='<?=Util::html($viewer->makeSortUrl('name'))?>'>Имя</a>
					<?=$viewer->showSortOrder('name')?>
				</th>

				<th>
					<a href='<?=Util::html($viewer->makeSortUrl('sname'))?>'>Фамилия</a>
					<?=$viewer->showSortOrder('sname')?>
				</th>

				<th>
					<a href='<?=Util::html($viewer->makeSortUrl('group_num'))?>'>Номер группы</a>
					<?=$viewer->showSortOrder('group_num')?>
				</th>

				<th>
					<a href='<?=Util::html($viewer->makeSortUrl('points'))?>'>Баллов</a>
					<?=$viewer->showSortOrder('points')?>
				</th>
			</tr>
		</thead>
		
		<tbody>
			<?php foreach($students as $student):?>
				<?php if( (isset($user['email'])) and ($user['email']==$student->email) ):?>
					<tr class="active">
				<?php else: ?>
					<tr>	
				<?php endif;?>
				



				<td><?=Util::highlight(Util::html($student->name),$find)?></td>
				<td><?=Util::highlight(Util::html($student->sname),$find)?></td>
				<td><?=Util::highlight(Util::html($student->group_num),$find)?></td>
				<td><?=Util::highlight(Util::html($student->points),$find)?></td>

			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	
<div class="col-md">
	<?php if(isset($pages)): ?>
		<ul class="pagination">

		<?php if($currentPage>1): ?>
			<li><a href='<?=Util::html($viewer->makePageUrl($currentPage-1))?>'>&laquo;</a></li>
		<?php endif;?>

		<?php for($i=1; $i<=$pages; $i++): ?>
			<?php if($i==$currentPage): ?>
				<li class="active"><a href='#'><?=$i?></a></li>	
			<?php else: ?>
				<li><a href='<?=Util::html($viewer->makePageUrl($i))?>'><?=$i?></a></li>
			<?php endif;?>	
		<?php endfor;?>
		
		<?php if($currentPage!=$pages): ?>
			<li><a href='<?=Util::html($viewer->makePageUrl($currentPage+1))?>'>&raquo;</a></li>
		<?php endif;?>

		</ul>
	<?php endif;?>
</div>

<?php endif;?>