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
    public $is_resident;
    public $hash;
    
    function __construct(){}
    
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function addInfo($infoArray){
        foreach($infoArray as $key=>$value){            
            $object_vars=get_object_vars($this);
            //Если есть переменная в объекте
            if(array_key_exists($key,$object_vars)){
                //Если значение из массива не пустое
                if(isset($value) and ($value!=NULL)){
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