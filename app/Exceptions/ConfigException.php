<?php
namespace StudentList\Exceptions;


class ConfigException extends \Exception {

    function __construct(string $message = "", $jsonLastError=NULL){
        if (isset($jsonLastError)) {
            $message='Ошибка в JSON-файле. Код: '.$jsonLastError.'; Текст: ';

            switch ($jsonLastError) {
                case JSON_ERROR_NONE:
                    $message.= 'Ошибок нет';
                break;
                case JSON_ERROR_DEPTH:
                    $message.= 'Достигнута максимальная глубина стека';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                    $message.= 'Некорректные разряды или не совпадение режимов';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    $message.= 'Некорректный управляющий символ';
                break;
                case JSON_ERROR_SYNTAX:
                    $message.= 'Синтаксическая ошибка, не корректный JSON';
                break;
                case JSON_ERROR_UTF8:
                    $message.= 'Некорректные символы UTF-8, возможно неверная кодировка';
                break;
                case JSON_ERROR_RECURSION:
                    $message.= 'Одна или несколько зацикленных ссылок в кодируемом значении';
                break;
                case JSON_ERROR_INF_OR_NAN:
                    $message.= 'Одно или несколько значений NAN или INF в кодируемом значении ';
                break;
                case JSON_ERROR_UNSUPPORTED_TYPE:
                    $message.= 'Передано значение с неподдерживаемым типом';
                break;
                default:
                    $message.= 'Неизвестная ошибка';
                break;
            }
        }
        parent::__construct($message,0,NULL);   
    }
    
}