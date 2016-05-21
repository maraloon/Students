<?php $s=$student; ?>

<input type='text' placeholder='Имя' name='name' value='<?=html($s->name)?>'>
<br>

<input type='text' placeholder='Фамилия' name='sname' value='<?=html($s->sname)?>'>
<br>
<?php if($s->gender): ?>
	<input type="radio" name="gender" value="m" checked> Муж.
	<input type="radio" name="gender" value="f" > Жен.
<?php else: ?>
	<input type="radio" name="gender" value="m"> Муж.
	<input type="radio" name="gender" value="f" checked> Жен.
<?php endif;?>
<br>

<input type='text' placeholder='Номер группы' name='group_num' value='<?=html($s->group_num)?>'>
<br>

<input type='email' placeholder='E-mail' name='email' value='<?=html($s->email)?>'>
<br>

<input type='number' placeholder='Суммарное число баллов по ЕГЭ' name='points' value='<?=html($s->points)?>'>
<br>

<input type='number' placeholder='Год рождения' name='b_year' value='<?=html($s->b_year)?>'>
<br>

<?php if($s->is_resident): ?>
	<input type="radio" name="is_resident" value="resident" checked> Местный
	<input type="radio" name="is_resident" value="foreign" > Иногородний
<?php else: ?>
	<input type="radio" name="is_resident" value="resident"> Местный
	<input type="radio" name="is_resident" value="foreign" checked> Иногородний
<?php endif;?>
<br>