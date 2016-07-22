<form method='get' action='<?=Router::url('search')?>'>
	<input type='text' name='find' placeholder='Поиск' value='<?=Util::html($find)?>'>
	<input type='submit' value='Найти'>
</form>