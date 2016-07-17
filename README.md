ToDo (по условию):
-PSR-4 через композер. Автоподстановка интерфейсов
-при ошибке ввода отображать --- и выделенным красным цветом ошибочным полем
-ахуинный css дезигн (стырить)
	-main.css
	-всё по центру
-title из таблицы
-настроить права для папок 
-разобраться с зависимостями классов
-удалить из 503 чтение файла
-Кстати, тебе дополнительное задание. Сделай Cli скрипт который загружает по очереди всех студентов из БД, проверяет каждого на правильность и если есть ошибки, пишет id студента и подробности ошибок.


//--------------ОТВЕТЫ-------------//
>>796168

<!-- > https://github.com/TheSidSpears/Students/blob/master/students.sql#L31
>  `hash` text NOT NULL,
Тут лучше подойдет varchar -->

https://github.com/TheSidSpears/Students/blob/master/router.json
Вот тут я не уверен что в роутере должен указываться вью. зачем? Ты планируешь один вью с несколькими контроллерами использовать? Это вряд ли получится, так как вью привязан к своему контроллеру и не совместим с другими. И даже если он совместим, при правке это легко сломать.
-Мне на самом деле эта строка нужна была, чтобы указать в какой папке вью. Если заменю "view": "status/register_ok" на "folder": "status" - будет норм?

<!--  Ангалогично мне кажется нет смысла в роутере указвать заголовок страницы (если только ты не используешь это еще например для меню - и то, наверно выгоднее как-то в контроллере это хранить). -->

https://github.com/TheSidSpears/Students/blob/master/public/.htaccess#L5
не очень понятно зачем тут перенаправление всех УРЛ на 503.php. Коментарий бы добавил.

<!-- https://github.com/TheSidSpears/Students/blob/master/public/errors.log
Почему лог ошибок в публичной папке? и кстати зачем вообще его было делать, если в php уже есть готовый лог? -->

<!-- https://github.com/TheSidSpears/Students/blob/master/public/index.php
тут странный код: ты создаешь объект и ничего с ним не делаешь:

> $frontController=new FrontController($container);

Задача конструктора - инициализировать объект, а не обрабатывать запрос. -->

<!-- https://github.com/TheSidSpears/Students/blob/master/app/bootstrap.php#L12
Ты используешь относительный путь который зависит например от теущего каталога. надо использовтаь абсолютный путь например с использованием __DIR__ или метода преобразования относительного пути в абсолютный. -->

https://github.com/TheSidSpears/Students/blob/master/app/bootstrap.php#L19
Автозагрузку можно было бы через композер сделать. <!-- И тут та же проблема с относительными путями. -->

<!-- https://github.com/TheSidSpears/Students/blob/master/app/container.php#L7
>  return JSONLoader::config();
>   return JSONLoader::router();
Статические методы это не ООП-подход. Не вижу причин тут использовать статический вызов.  -->Также не вижу где написан путь к конфигу.

Более того, ты возвращаешь массив непонятной структуры. Не лучше ли возвращать объект с методами для получения данных?
- В чём заключается непонятность структуры? Ты предлагаешь делать методы типа getDBLogin(), getDBPass() и т.д. или как?

<!-- https://github.com/TheSidSpears/Students/blob/master/app/controllers/FrontController.php#L15
> public $isAuthorized=false;
зачем тут это публичное свойство? Контроллер это не сервис чтобы другие могли к нему обращаться. У тебя есть сервис авторизации для этого. Не надо дублировать его функции. -->

<!-- https://github.com/TheSidSpears/Students/blob/master/app/classes/Router.php
Роутер странный. Он называется роутер и при этом он не использует даже файл с конфигом. Что он вообще делает? По моему ты не смог изолировать функционал роутинга в одном классе и он у тебя вытек в front controller.

https://github.com/TheSidSpears/Students/blob/master/app/controllers/FrontController.php#L33
Это функционал роутера. -->

<!-- > https://github.com/TheSidSpears/Students/blob/master/router.json
> "controller": "Main",
Плохая идея писать имя класса не полностью. Если я захочу поискать где используется класс MainController, я не найду это место. -->

<!-- https://github.com/TheSidSpears/Students/blob/master/app/controllers/MainController.php#L96
> $this->viewData['students']=$this->c['table']->getStudents($this->sortBy,$this->orderBy,$this->limit,$this->offset,$this->find);
Слишком сложное выражение, плохо читается. Вместо $this->c['table'] лучше писать $this->studentTDG или $studentTDG. -->

https://github.com/TheSidSpears/Students/blob/master/app/controllers/MainController.php
Контроллер переусложнен. По моему он весь пишется в виде одного местода на 15-20 строк, а ты зачем-то надобавлял тут свойств и методов. У тебя как-то все выглядит переусложненно, попробуй упростить и избавиться от лишнего.
-сократил, но не уверен что верно

<!-- https://github.com/TheSidSpears/Students/blob/master/app/controllers/MainController.php#L31

>        if ($isAuthorized) {
>             $user=$this->c['auth']->getUser();
>            $this->user=$this->filterUserData($user);
зачем тут filterUserData? Не понимаю. -->

<!-- https://github.com/TheSidSpears/Students/blob/master/app/controllers/EditController.php
https://github.com/TheSidSpears/Students/blob/master/app/controllers/RegisterController.php
Не очень удачное решение. Вместо наследования тут проще сделать один контроллер и поставить пару ифов. такой код читать будет проще, чем постоянно переключаться между 2 классами. -->

<!-- https://github.com/TheSidSpears/Students/blob/master/app/controllers/RegisterController.php#L29
> setcookie('hash',$student->hash,time()+360012365,'/',null,false,true);
Странно, у тебя есть класс отвечающий за авторизацию, но куку почему-то ты ставишь в контроллере. -->

https://github.com/TheSidSpears/Students/blob/master/app/controllers/ERController.php#L73
> protected function fillStudent(Student $student){
Непонятно что тут делает цикл ибо он ничего не меняет в массиве.
-foreach ($_POST as $post) {$post=trim(strval($post));}
Он делает trim и strval, разве нет?




Опять же, редактирование переусложнено. Надо радикально упрощать код, убрать наследование, убрать код из конструктора. Свойства во многих случаях проще заменить на обычные переменные.

Метод showView тоже назван неудачно. Логчинее назвать его "обработать запрос" и сделать абстрактным в базовом контроллере.

https://github.com/TheSidSpears/Students/blob/master/app/classes/Authorization.php#L12
> function __construct($container){
перечитай урок про DI. Это service locator и это плохая вещь.

Сам класс авторизации странный, половины функций связанных с авторизацией, в нем нет, они в контроллере.

https://github.com/TheSidSpears/Students/blob/master/app/classes/JSONLoader.php
Тут зачем-то захардкожены имена файлов.

> $array=file_get_contents($filename,FILE_IGNORE_NEW_LINES);
Имя переменной не соответствует тому что она хранит

> LIMIT :y OFFSET :x");
Неудачные названия плейсхолдеров

> $rows = $this->db->prepare("SELECT FROM `students` ORDER BY $sortBy $orderBy LIMIT :y OFFSET :x");
>        if (isset($search)) {
>            $rows = $this->db->prepare("SELECT FROM `students` WHERE CONCAT(`name`,' ',`sname`,' ',`group_num`,' ',`points`,' ',`gender`,' ',`email`,' ',`b_year`,' ',`is_resident`) LIKE :search ORDER BY $sortBy $orderBy LIMIT :x,:y");
Получается первый prepare был сделан зря? зачем тогда его делать?

В student->addInfo есть проблема. У тебя нет фильтрации по разрешенными полям и пользователь может менять любые свойства студента в том числе те, которых нет в форме. ну например что если мы добавим колонку is_admin - пользователь сможет передать $POST['is_admin'] = 1 при редактирвоании. И кстати об этом было написано в моем уроке.

> https://github.com/TheSidSpears/Students/blob/master/app/classes/StudentValidator.php#L98
> foreach($mask['values'] as $value){                    
>                    if($s->$field=$value){
in_array()

> 'regexp'=>"/^([а-яa-z][ ']*)+$/iu",
Где буква ё? Где дефис для фамилий?

https://github.com/TheSidSpears/Students/blob/master/app/classes/StudentValidator.php#L66
> function __construct(Student $s, $container, $id=NULL){
Почему ты пишешь код валидации в конструкторе? И почему передаешь контейнер? Почитай про DI.

https://github.com/TheSidSpears/Students/blob/master/app/classes/ViewHelper.php
тут слишком много всего понамешано. Еще и контейнер.

В общем:

1) упрощай код
2) перечитай урок по DI
3) перечитай комментарии к задаче