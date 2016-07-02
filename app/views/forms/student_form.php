<?php $s=$student; ?>

<input type='text' placeholder='Имя' name='name' value='<?=ViewHelper::html($s->name)?>'>
<br>

<input type='text' placeholder='Фамилия' name='sname' value='<?=ViewHelper::html($s->sname)?>'>
<br>
<?php if($s->gender): ?>
	<input type="radio" name="gender" value="m" checked> Муж.
	<input type="radio" name="gender" value="f" > Жен.
<?php else: ?>
	<input type="radio" name="gender" value="m"> Муж.
	<input type="radio" name="gender" value="f" checked> Жен.
<?php endif;?>
<br>

<input type='text' placeholder='Номер группы' name='group_num' value='<?=ViewHelper::html($s->group_num)?>'>
<br>

<input type='email' placeholder='E-mail' name='email' value='<?=ViewHelper::html($s->email)?>'>
<br>

<input type='number' placeholder='Суммарное число баллов по ЕГЭ' name='points' value='<?=ViewHelper::html($s->points)?>'>
<br>

<input type='number' placeholder='Год рождения' name='b_year' value='<?=ViewHelper::html($s->b_year)?>'>
<br>
<!-- удалить нижнее -->
<?php if($s->is_resident): ?>
	<input type="radio" name="is_resident" value="resident" checked> Местный
	<input type="radio" name="is_resident" value="foreign" > Иногородний
<?php else: ?>
	<input type="radio" name="is_resident" value="resident"> Местный
	<input type="radio" name="is_resident" value="foreign" checked> Иногородний

	<input type="radio" name="is_resident" value="resident" <?= $s->is_resident ? ' checked ' : '' ?>> Местный
	<input type="radio" name="is_resident" value="foreign" <?= !$s->is_resident ? ' checked ' : '' ?>> Иногородний
<?php endif;?>
<br>

