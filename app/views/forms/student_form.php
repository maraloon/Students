<?php $s=$student; ?>

<input type='text' placeholder='Имя' name='name' required value='<?=ViewHelper::html($s->name)?>'>
<br>

<input type='text' placeholder='Фамилия' name='sname' required value='<?=ViewHelper::html($s->sname)?>'>
<br>

<input type="radio" name="gender" value="m" <?= $s->gender ? ' checked ' : '' ?>> Муж.
<input type="radio" name="gender" value="f" <?= !$s->gender ? ' checked ' : '' ?>> Жен.

<input type='text' placeholder='Номер группы' name='group_num' required value='<?=ViewHelper::html($s->group_num)?>'>
<br>

<input type='email' placeholder='E-mail' name='email' required value='<?=ViewHelper::html($s->email)?>'>
<br> 

<input type='number' placeholder='Суммарное число баллов по ЕГЭ' name='points' value='<?=ViewHelper::html($s->points)?>'>
<br>

<input type='number' placeholder='Год рождения' name='b_year' value='<?=ViewHelper::html($s->b_year)?>'>
<br>

<input type="radio" name="is_resident" value="resident" <?= $s->is_resident ? ' checked ' : '' ?>> Местный
<input type="radio" name="is_resident" value="foreign" <?= !$s->is_resident ? ' checked ' : '' ?>> Иногородний

<br>

