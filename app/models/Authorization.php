<?php
/*
* c['auth']->checkAuth($_COOKIE['hash']);
* Если вернёт true, то c['auth']->user содержит данные авторизованного студента для представления
* Которые можно получить из getUser
*/
class Authorization{

	protected $user;
	protected $isAuthorized;

	function __construct($container){
		$this->c=$container;
	}

	public function checkAuth($cookieHash){
	/*
	* Возвращает статус пользователя
	* Устанавливает значения полей, если авторизован
	*/
		$this->isAuthorized=false;

		$student=$this->c['table']->getStudentByHash($cookieHash);
		if ($student!=false){
			$this->isAuthorized=true;
			//Переменные для отображения
			$this->user=$student;
			
		}
		return $this->isAuthorized;
	}

	public function getUser(){
		if ($this->isAuthorized) {
			return $this->user;
		}
		else{
			throw new AuthExeption('Попытка гостя получить данные авторизованного пользователя');
		}
	}
}