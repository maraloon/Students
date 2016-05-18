<input type='text' placeholder='Имя' name='' value='<?=$s->name?>'></input>
<br>

<input type='text' placeholder='Фамилия' name=''value='<?=$s->sname?>'></input>
<br>
<?php if($s->gender): ?>
	<input type="radio" name="sex" value="m" checked> Муж.
	<input type="radio" name="sex" value="f" > Жен.
<?php else: ?>
	<input type="radio" name="sex" value="m"> Муж.
	<input type="radio" name="sex" value="f" checked> Жен.
<?php endif;?>
<br>

<input type='text' placeholder='Номер группы' name='' value='<?=$s->group_num?>'></input>
<br>

<input type='email' placeholder='E-mail' name='' value='<?=$s->email?>'></input>
<br>

<input type='number' placeholder='Суммарное число баллов по ЕГЭ' name='' value='<?=$s->points?>'></input>
<br>

<input type='number' placeholder='Год рождения' name='' value='<?=$s->b_year?>'></input>
<br>

<?php if($s->is_resident): ?>
	<input type="radio" name="is_resident" value="resident" checked> Местный
	<input type="radio" name="is_resident" value="foreign" > Иногородний
<?php else: ?>
	<input type="radio" name="is_resident" value="resident"> Местный
	<input type="radio" name="is_resident" value="foreign" checked> Иногородний
<?php endif;?>
<br>