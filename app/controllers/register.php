<?php
//Переменные
$userErrors=array(); //все ошибки во время регистрации


//Токен
$token= (isset($_COOKIE['token'])) ? $_COOKIE['token'] : Util::randHash(20);
setcookie('token',$token,time()+3600,'/',null,false,true);

//Если данные формы передавались
if(!empty($_POST)){
	
	//Проверка токена
	if( (empty($_COOKIE['token'])) or (empty($_POST['token'])) or ($_COOKIE['token']!=$_POST['token']) ){
		//Попытка взлома
		  //header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request"); 
		  header(' ', true, 400); //Так, вроде правильней
	}
	else{
		 
		//Тестовый студент
		$newStudent=new Student();
		//Передаём весь POST, не фильтруя лишнее - это сделает класс
		//безопасное получение переданных значений
		foreach($newStudent as $fieldName=>&$fieldValue){
			$fieldValue=isset($_POST[$fieldName]) ? trim(strval($_POST[$fieldName])) : '';
		}
		//Добавляем хеш для авторизации
		$hash=Util::randHash(20);
		$newStudent->hash=$hash;

		
		//Ищем ошибки в заполнении
		$valid=new StudentValidator($newStudent);
		
		//нет ошибок
		if(empty($valid->errors)){		
			//Соединяемся с базой
			$db=new DataBase($config['db']);
			//Соединяемся с таблицей
			$table=new StudentDataGateway($db->connection());
			//Добавляем студента в таблицу
			$table->addStudent($newStudent);
			
			if( empty($table->userErrors) ){
				echo "Ошибок в StudentDataGateway нет"; //del
				//Передаём кук с хешем
				setcookie('hash',$hash,time()+3600*12*365,'/',null,false,true);

				
				//Переправить
				header('Location: register_ok');	
			}
			//ошибки при добавлениии информации в таблицу
			else{
				foreach($table->userErrors as $error){
					$userErrors[]=$error;
				}

			}
			
			
			

		}
		//ошибки в форме
		else{		
			foreach($valid->errors as $error){
				$userErrors[]=$error;
			}
		}
		
		if(!empty($userErrors)){
			//заполняет форму регистрации значениями пользователя
			$student=$newStudent;
		}

	
	}

}
//Если юзер перешел на форму и еще ничего не передавал
else{
	
	//заполняет форму регистрации пустыми значениями
	$student=new Student();
	
}