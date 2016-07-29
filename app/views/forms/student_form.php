<?php use StudentList\Helpers\Util; ?>
<?php $s=$student; ?>
<div class="form-group">
	<label>Имя</label>
	<input type='text' placeholder='Имя' name='name' class="form-control" required value='<?=Util::html($s->name)?>'>
</div>

<div class="form-group">
	<label>Фамилия</label>
	<input type='text' placeholder='Фамилия' name='sname' class="form-control" required value='<?=Util::html($s->sname)?>'>
</div>

<div class="row">
<div class="radio col-xs-1">
	<label>
		<input type="radio" class="radio-inline" name="gender" value="m" <?= $s->gender ? ' checked ' : '' ?>>
		Муж.
	</label>
	<label>
		<input type="radio" class="radio-inline" name="gender" value="f" <?= !$s->gender ? ' checked ' : '' ?>>
		Жен.
	</label>
</div>

<div class="radio col-xs-2">
	<label>
		<input type="radio" class="radio-inline" name="is_resident" value="resident" <?= $s->is_resident ? ' checked ' : '' ?>>
		Местный
	</label>
	<label>
		<input type="radio" class="radio-inline" name="is_resident" value="foreign" <?= !$s->is_resident ? ' checked ' : '' ?>>
		Иногородний
	</label>
</div>
</div>

<div class="form-group">
	<label>Номер группы</label>
<input type='text' placeholder='Номер группы' name='group_num' class="form-control" required value='<?=Util::html($s->group_num)?>'>
</div>

<div class="form-group">
	<label>E-mail</label>
	<input type='email' placeholder='E-mail' name='email' class="form-control" required value='<?=Util::html($s->email)?>'>
</div>

<div class="form-group">
	<label>Суммарное число баллов по ЕГЭ</label>
	<input type='number' min="0" max="300" placeholder='Баллов' class="form-control" name='points' value='<?=Util::html($s->points)?>'>
</div>

<div class="form-group">
	<label for="name">Год рождения</label>
	<input type='number' min="1900" max="2016" placeholder='Год рождения' class="form-control" name='b_year' value='<?=Util::html($s->b_year)?>'>
</div>