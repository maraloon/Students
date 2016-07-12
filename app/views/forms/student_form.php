<?php $s=$student; ?>


<div class="icon">
	<label class="cd-label" for="name">Имя</label>
	<input class="user" type="text" name="name" id="cd-name" required value='<?=ViewHelper::html($s->name)?>'>
</div>

<div class="icon">
	<label class="cd-label" for="sname">Фамилия</label>
	<input class="user" type="text" name="sname" id="cd-name" required value='<?=ViewHelper::html($s->sname)?>'>
</div>

<div>
	<h4>Пол</h4>

	<ul class="cd-form-list">
		<li>
			<input type="radio" name="gender" value="m" <?= $s->gender ? ' checked ' : '' ?>>
			<label for="gender">Мужской</label>
		</li>
			
		<li>
			<input type="radio" name="gender" value="f" <?= !$s->gender ? ' checked ' : '' ?>>
			<label for="gender">Женский</label>
		</li>
	</ul>
</div>

<div>
	<h4>Откуда</h4>

	<ul class="cd-form-list">
		<li>
			<input type="radio" name="is_resident" value="resident" <?= $s->is_resident ? ' checked ' : '' ?>>
			<label for="cd-radio-1">Местный</label>
		</li>
			
		<li>
			<input type="radio" name="is_resident" value="foreign" <?= !$s->is_resident ? ' checked ' : '' ?>>
			<label for="cd-radio-2">Иногородний</label>
		</li>
	</ul>
</div>

<div class="icon">
	<label class="cd-label" for="cd-company">Номер группы</label>
	<input class="company" type="text" name="group_num" id="cd-company" required value='<?=ViewHelper::html($s->group_num)?>'>
</div> 

<div class="icon">
	<label class="cd-label" for="cd-email">Email</label>
	<input class="email" type="email" name="email" id="cd-email" required value='<?=ViewHelper::html($s->email)?>'>
</div>


<div class="icon">
	<label class="cd-label" for="points">Суммарное число баллов по ЕГЭ</label>
	<input class="budget" type="number" name="points" id="cd-email" required value='<?=ViewHelper::html($s->points)?>'>
</div>

<div class="icon">
	<label class="cd-label" for="points">Год рождения</label>
	<input class="budget" type="number" name="b_year" id="cd-email" required value='<?=ViewHelper::html($s->b_year)?>'>
</div>