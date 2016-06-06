<?php
/*
Если нажата "Изменить данные"
	Валидация
	Изменение строки в БД
	Страница: edit_ok.php
Иначе
	Проверяем кук hash
	Ищем в таблице
	Если есть такой
		Подставляем данные юзера
	Иначе
		Нет доступа, 503
*/

if (isset($_COOKIE['hash'])) { //нет кука с хешем => не выполнять скрипт
/*сделать проверку кука на иньекции*/
	//Переменные
	$userErrors=array(); //все ошибки во время регистрации

	//Токен
	if(!isset($_COOKIE['token'])){
		$token=Util::randHash(20);
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
			//Попытка взлома
			  //header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request"); 
			  header(' ', true, 400); //Так, вроде правильней
		}
		else{

			//Тестовый студент
			$editStudent=new Student();

			//Передаём весь POST, не фильтруя лишнее - это сделает класс
			//безопасное получение переданных значений
			foreach($editStudent as $fieldName=>&$fieldValue){
				$fieldValue=isset($_POST[$fieldName]) ? trim(strval($_POST[$fieldName])) : '';
			}
			$editStudent->hash=$_COOKIE['hash'];
			

			//Ищем ошибки в заполнении
			$valid=new StudentValidator($editStudent);

			//нет ошибок
			if(empty($valid->errors)){		
				//Соединяемся с базой
				$db=new DataBase($config['db']);
				//Соединяемся с таблицей
				$table=new StudentDataGateway($db->connection());
				//Добавляем студента в таблицу
				$table->editStudent($editStudent);

				if( empty($table->userErrors) ){
					//Успешное изменение данных
					header('Location: edit_ok');	
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
				$student=$editStudent;
			}



		}


	}
	//Если юзер перешел на форму и еще ничего не передавал
	else{



			//Соединяемся с базой
			$db=new DataBase($config['db']);
			//Соединяемся с таблицей
			$table=new StudentDataGateway($db->connection());
			//Добавляем студента в таблицу
			$studentRow=$table->getStudentByHash($_COOKIE['hash']);

			//Создаём объект студента
			$student=new Student();
			//безопасное получение переданных значений
			foreach($student as $fieldName=>&$fieldValue){
				$fieldValue=isset($studentRow[$fieldName]) ? trim(strval($studentRow[$fieldName])) : '';
			}



	}


}
else{
	header(' ', true, 503);
}