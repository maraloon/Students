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

	public function checkAuth(){
	/*
	* Возвращает статус пользователя
	* При первом обращении сверяет куки с БД
	* При повторном просто выводит сохранённое значение isAuthorized
	* Устанавливает значения полей, если авторизован
	*/
		if (empty($isAuthorized)) {
			if (isset($_COOKIE['hash'])) {
				$this->isAuthorized=false;

				$student=$this->c['table']->getStudentByHash($_COOKIE['hash']);
				if ($student!=false){
					$this->isAuthorized=true;
					//Переменные для отображения
					$this->user=$student;
					
				}
				//return $this->isAuthorized;
			}
		}
		return $this->isAuthorized;


	}

	public function setHash($hash){
		setcookie('hash',$hash,time()+3600*12*365,'/',null,false,true);
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