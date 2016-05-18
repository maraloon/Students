<?php

//Токен
if(!isset($_COOKIE['token'])){
	$token=md5(uniqid(rand(), true));
	setcookie('token',$token,time()+3600,'/',null,false,true);
}
else{
	$token=$_COOKIE['token'];
	setcookie('token',$token,time()+3600,'/',null,false,true);
}

//Если данные формы передавались
if(!empty($_POST)){
	echo "Есть POST"; //del
	print_r($_POST); //del
	
	//Проверка токена
	if( (empty($_COOKIE['token'])) or (empty($_POST['token'])) or ($_COOKIE['token']!=$_POST['token']) ){
		//Попытка взлома. Без предупреждений перекидываем на главную
		/*Возможно, нужно по другому обрабатывать эту ошибку.
		  Напирмер, записывать ip злоумышленника и посылать админу по почте*/
		header('Location: index.php');
	}
	//безопасное получение переданных значений
	foreach($form_data as $k=>&$s){
		$s=isset($_POST[$k]) ? trim(strval($_POST[$k])) : '';
		$s=htmlspecialchars($s,ENT_QUOTES);
		$s=preg_replace("#((data|javascript)(://))#iu","",$s);
	}
	print_r($form_data);	
	
	//Ищем ошибки в заполнении
	$check_student=new Student($form_data['name'],$form_data['sname'],$form_data['group_num'],$form_data['points'],$form_data['gender'],$form_data['email'],$form_data['b_year'],$form_data['is_resident']);
	//передаём данные формы в валидатор
	$valid=new StudentValidator($check_student);
	
	//нет ошибок
	if(empty($valid->errors)){
		//Херня. Поменять на что-нибудь нормальное
		header('Location: index.php?reg_status=true');
	}
	//ошибки в форме
	else{
		//заполняет форму регистрации значениями пользователя
		$s=$check_student;

	}
}
//Если юзер перешел на форму и еще ничего не передавал
else{
	
	//заполняет форму регистрации пустыми значениями
	$s=new Student('','','','',true,'','',true);
	
}

//Вид - форма регистрации
$view='register';

