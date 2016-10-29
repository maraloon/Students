<?php
namespace StudentList\Models;
/*implement

__construct
addInfo
*/


class Student{
    protected $id;
    public $name;
    public $sname;
    public $group_num;
    public $points;
    public $gender;
    public $email;
    public $b_year;
    public $residence;
    public $hash;

    const GENDER_MALE='m';
    const GENDER_FEMALE='f';
    const RESIDENCE_RESIDENT='resident';
    const RESIDENCE_FOREIGN='foreign';
  
    function __construct(){}
    
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function isResident(){
        if ($this->residence==$this::RESIDENCE_RESIDENT) {
            return true;
        }
        return false;
        
    }

    public function addInfo($infoArray){
        foreach($infoArray as $key=>$value){            
            $object_vars=get_object_vars($this);
            //Если есть переменная в объекте
            if(array_key_exists($key,$object_vars)){
                //Если значение из массива не пустое
                if($value!=NULL){
                    //Передать значение объекту
                    $this->$key=$value;
                }
            }
        }

        if(isset($infoArray['id'])){
            $this->setId($infoArray['id']);
        }
    }
}