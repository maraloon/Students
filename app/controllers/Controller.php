<?php
namespace Project\Controllers;
abstract class Controller{

	protected $c; //контейнер


	function __construct($container){
		$this->c=$container;
	}

}