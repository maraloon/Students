<?php use \Project\Classes\Util; ?>
<?php use \Project\Classes\Router; ?>
<h1><?=$h1?></h1>

<?php include(Util::getAbsolutePath('/app/views/modules/form_errors.php')); ?>

<form role="form" class="form-horizontal" method='post' action='<?=Router::url($action)?>'>
	<?php include(Util::getAbsolutePath('/app/views/forms/student_form.php')); ?>
	<input type='hidden' name='token'  value='<?=Util::html($token)?>'>
	<button class="btn btn-primary btn-lg" type="submit"><?=$button?></button>
</form>

<?php include(Util::getAbsolutePath('/app/views/modules/bottom.php')); ?>