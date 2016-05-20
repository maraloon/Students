<?php

//Токен
if(!isset($_COOKIE['token'])){
	$token=randHash(20);
	setcookie('token',$token,time()+3600,'/',null,false,true);
}
else{
	$token=$_COOKIE['token'];
	setcookie('token',$token,time()+3600,'/',null,false,true);
}

//Если данные формы передавались
if(!empty($_POST)){
	
	//Проверка токена
	if( (empty($_COOKIE['token'])) or (empty($_POST['token'])) or ($_COOKIE['token']!=$_POST['token']) ){
		//Попытка взлома. Без предупреждений перекидываем на главную
		  //header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request"); 
		  header(' ', true, 400); //Так, вроде правильней
	}
	else{


		$newStudent=new Student($_POST['name'],$_POST['sname'],$_POST['group_num'],$_POST['points'],$_POST['gender'],$_POST['email'],$_POST['b_year'],$_POST['is_resident']);
		
		//безопасное получение переданных значений
		foreach($newStudent as $k=>&$v){
			$v=isset($_POST[$k]) ? trim(strval($_POST[$k])) : '';
			/*
			$v=htmlspecialchars($v,ENT_QUOTES);
			$v=preg_replace("#((data|javascript)(://))#iu","",$v);
			*/
		}	
		
		//Ищем ошибки в заполнении
		$valid=new StudentValidator($newStudent);
		
		//нет ошибок
		if(empty($valid->errors)){
			
			/*
			Попытка записи в базу
			Установка хеша
				Запись хеша в базу
				Отдать кук с хешем
			Страница со статусом
			*/
			$db=new StudentDataGateway($config->db);
			$addNewStudent=$db->addStudent($newStudent);
			if(empty($addNewStudent->errors)){
				echo "Ошибок в StudentDataGateway нет"; //del
				//Генерация хеша
				$hash=randHash(20);
				//Добавляем хеш в БД
				$db->addHash($studentId,$hash);
				//Передаём кук с хешем
				
				//Авторизовать
				//еще не знаю как
				
				//Переправить
				//header('Location: index.php?register_ok');	
			}
			else{
				echo "Ошибка : в StudentDataGateway"; //del
			}
			
			
			

		}
		//ошибки в форме
		else{
			//заполняет форму регистрации значениями пользователя
			$student=$newStudent;
		}


	
	}

}
//Если юзер перешел на форму и еще ничего не передавал
else{
	
	//заполняет форму регистрации пустыми значениями
	$student=new Student('','','','',true,'','',true);
	
}

//Вид - форма регистрации
$view='register';

