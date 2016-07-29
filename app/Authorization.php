<?php
namespace StudentList;
use StudentList\Exeptions\AuthExeption;
/*
* c['auth']->checkAuth($_COOKIE['hash']);
* Если вернёт true, то c['auth']->user содержит данные авторизованного студента для представления
* Которые можно получить из getUser
*/
class Authorization{

	protected $user;
	protected $table;
	protected $isAuthorized=NULL;

	function __construct($table){
		$this->table=$table;
	}

	public function checkAuth(){
	/*
	* Возвращает статус пользователя
	* Устанавливает значения полей, если авторизован
	*/
		if (isset($_COOKIE['hash'])) {
			$this->isAuthorized=false;
			$student=$this->table->getStudentByHash($_COOKIE['hash']);
			if ($student!=false){
				$this->isAuthorized=true;
				//Переменные для отображения
				$this->user=$student;	
			}
			return $this->isAuthorized;
		}
	}

	public function logIn($hash){
		setcookie('hash',$hash,time()+3600*12*365,'/',null,false,true);
	}

	//не используется в коде
	public function logOut(){
		setcookie('hash','');
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