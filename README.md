-Чтение <title> из json удалить. Такую инфу лучше держать в БД


ToDo (по условию):
-при ошибке ввода отображать --- и выделенным красным цветом ошибочным полем
-Выводятся по 50 человек на страницу (у меня 10)
-ахуинный css дезигн (стырить)



-настроить права для папок 
-разобраться с зависимостями классов
-удалить из 503 чтение файла



-Student: данные можно добавлять как через addInfo, так и напрямую. Верно ли это?



Мелочишки:
-controllers/edit: проверка $_COOKIE['hash'] - нужно ли?
-controllers/edit,register: убрать, по возможности копипасты - не знаю как
-showSortOrder не должен выводить символы, а возвращать true/false - усложнение кода, не нужно
-разобраться с set_exception_handler


Редирект это отдача в качестве ответа кода 3xx и заголовка Location. Редиректить при ошибке, как и при 404 или 403 - неправильно. Вдобавок, в адресной строке браузера теряется УРЛ и обновить страницу нельзя.


Кстати, тебе дополнительное задание. Сделай Cli скрипт который загружает по очереди всех студентов из БД, проверяет каждого на правильность и если есть ошибки, пишет id студента и подробности ошибок.

https://github.com/TheSidSpears/Students/blob/master/public/index.php
> chdir ('../')
Вместо того, чтобы полагаться на текущий каталог, лучше использовать абсолютные пути, например, содержащие _ _ DIR _ _ в начале. А то у тебя код получается зависит от того праивльный ли текущий каталог задан, что создает возможности сделать ошибку.
>  Мне в начале каждого адреса такую шнагу прописывать __DIR__.'/../ ?
Либо прописывать, либо сделать функцию например так:
$helper->getAbsolutePath('/config.json');
PathHelper::getAbsolutePath('/confog.json');


//--------------ОТВЕТЫ-------------//
>>748292 
>>755118
####Исправлено####

https://github.com/TheSidSpears/Students/blob/master/students.sql#L31
> `hash` text NOT NULL,
Неудачный тип поля на мой взгляд - почему TEXT? Он для строк длиной до 65535 символов, и вряд ли хеш будет такой длины, плюс я не уверен можно ли по нему сделать индекс в дальнейшем.

https://github.com/TheSidSpears/Students/blob/master/config.json
Не стоит делать конфиг слишком большим. В конфиг мы выносим то, что будет менять конечный пользователь. Название папки с контроллерами вряд ли имеет смысл менять.

> <a href='index.php'>На главную</a>
У тебя URL главной - это index.php или / ? Желательно иметь для одной страницы один УРЛ.


https://github.com/TheSidSpears/Students/blob/master/public/503.php#L11
>   $array=file('errors.log');
ЧТо если файл огромный? Это будет медленно и займет много памяти. Ну и не очень понятно, зачем ты вообще выводишь лог для посетителей сайта.

> for ($i=$count-21; $i < $count; $i++) { 
А что если в файле меньше 21 строки? Плюс, ты выводишь данные без экранирования и тут явно может быть XSS если HTML код от злоумышлеенника попадет в сообщение в логе. Ты путаешь язык HTML и простой текстовый файл. В HTML некоторые символы имеют специальное знаечние (например < обозначает начало тега) и нельзя просто так выводить произвольный текст.

Кстати, раз ты путаешься с этим, реши-ка задачку на экранирование отсюда (и заодно прочитай сам урок): https://github.com/codedokode/pasta/blob/master/soft/web-server.md#Экранирование

https://github.com/TheSidSpears/Students/blob/master/app/models/JSON.php
json_decode может вернуть null если в JSON ошибка. Тут нет такой проверки.

Блок кода после if должен быть в фигурных скобках.

https://github.com/TheSidSpears/Students/blob/master/app/models/JSON.php
Название класса мало что говорит о его функции. Надо назвать вроде ConfigLoader.

https://github.com/TheSidSpears/Students/blob/master/errors.log
Этот файл надо убрать из репозитория, добавив в .gitignore и сделав git rm с нужными флагами


https://github.com/TheSidSpears/Students/blob/master/app/models/FrontController.php
Тут единственная функция со стеной кода. Учись разбивать код на части и выносить в отдельные функции. Я тут явно вижу функции вроде определения контроллера или вроде вывода шаблона.

> if ($authorized){
>                //Для вида
>                $userName=$authorized['name'];
Неправильно что переменная модет существовать, а может и нет. Как в таком случае писать надежный код если ты даже не знаешь, есть ли такая переменная?

> //Подключаем контроллер
>        if (!empty($controller)){
А если она пусто то что? Выведем белую страницу?

> if (!empty($view)){
Опять же, мне это не нравится, ты полагаешься на то, что код где-то в другом месте приложения выставит переменную. Это очень неочевидно и ненадежно, как мне кажется.

https://github.com/TheSidSpears/Students/blob/master/public/503.php#L1
> header(' ', true, 503); 
Что это за синтаксис? Что за пустой заголовок? По моему это не будет работать. Там надо отправлять заголоок вроде HTTP/1.1 503 xxxx, почитай хотя бы мануал по функции header().

https://github.com/TheSidSpears/Students/blob/master/app/bootstrap.php#L12
А зачем заводить свой собственный лог? Не лучше ли писать в стандартный лог PHP? ты кстати, знаешь, где он находится?

https://github.com/TheSidSpears/Students/blob/master/app/models/Router.php
Для "игнорирования" query string праивльне использовать функцию parse_url а не самодельный сомнительный код. Он еще и работает неправильно в случае /a/b/c?d=e/f

Далее, ты разбиваешь УРЛ на части и берешь последнюю, а что если УРЛ имеет вид /a/b/c/d/e/f - ты берешь только f, а остальные игнорируются?

> if( ($module=='index.php') or ($module=='')){
Непонятно зачем разрешать УРЛ содержащий index.php? У тебя же возможность задавать произвольные УРЛ есть.

https://github.com/TheSidSpears/Students/blob/master/app/controllers/main.php
Если ты используешь ООП, почему бы и контроллер не сделать классом?

------------------------------
> $db=new DataBase($config['db']);
Это раскидано в нескольких местах кода. Вообще-то идея была, чтобы в bootstrap создать нужные объекты один раз. Ты создаешь несколько соединений с базой данных например, несколько StudentDataGateway. Это не очень логично.

Идея нравится. Но вот не пойму, если я пропишу $db=new DataBase($config['db']); в bootstrap.php, как мне к ней обращаться в FrontController и в других классах? 

Тут есть разные варианты. Самый простой - забить на эту проблему и сказать что в контроллере можно создавать оьъекты, но это имеет недостатки. Например каждый новый объект PDO создает соединение с БД.

Второй вариант - сделать какое-то хранилище (контейнер) для объектов. Самый просто вариант - массив:

$services['pdo'] = new PDO...

или объект:

$container->add('pdo', new PDO...);

А затем передать контейнер в контроллер через конструктор.

Третий вариант - передавать сервисы в конструктор контроллера по отдельности.

Урок по теме: https://github.com/codedokode/pasta/blob/master/arch/di.md

Я советую не делать слишком сложных решений. Для простой задачи наверно и массив сойдет. 
-----------------------------------------------

####ToDo####



https://github.com/TheSidSpears/Students/blob/master/app/bootstrap.php#L20
> spl_autoload_register(
Тут незачем делать 2 автозагрузчика, проще сделать один, который проверяет разные пути. А еще лучше, конечно, было бы использовать PSR-4 при выборе названий классов и файлов.

https://github.com/TheSidSpears/Students/tree/master/app/models
Тут в папку свалены разные классы, часть из которых точно не модели - например, FrontController никак моделью не является. Роутер явно не является частью модели. И вообще, MVC не значит что у тебя должно быть ровно 3 папки view, controller и model. Это деление приложения на 3 части, а не файлов на 3 папки.



> if($currentPage<=0){$currentPage=1;} 
Тебе надо лучше форматировать код. Иф пишется в 3 строки, а не в одну. Также, тут можно было обойтись функцией max.

https://github.com/TheSidSpears/Students/blob/master/app/models/ViewHelper.php
Тут оформление кода ужасное. Что за полотна из пустых строк? Почему скобка на одной строке с заголовком функции?

> $routes = explode('/', $_SERVER['REQUEST_URI']);
>        $routes[count($routes)-1]=$url;
Это копипаста (причем неточная) кода из роутера. Почему у тебя разбор УРЛ сделан в 2 разных местах, причем еще и по-разному? Принцип "единой ответственности", когда за каждую задачу отвечает кто-то один, не соблюдается.

<!-- > static function html($string,$find=NULL){
По моему экранирование и подсветка совпадений - это две разные функции. --> 

<!-- > $reg="/$find/ui";
Ты подставляешь то, что ввел пользователь, в регулярку, но что если там есть специсмволы, например, плюс, звездочка, точка? надо либо использовать str_replace либо экранировать спецсимволы с помощью preg_quote. -->

<!-- https://github.com/TheSidSpears/Students/blob/master/app/models/ViewHelper.php#L51
> $router=new Router();
Опять же, почему-то у тебя создается несколько экземплятров роутера в приложении.
 -->
https://github.com/TheSidSpears/Students/blob/master/app/models/ViewHelper.php#L63
> return self::html($url);
Почему функция makeUrl вызывает self::html? А что если нам нужен исходный неискаженный УРЛ (например мы хотим редиректить на него)?

> https://github.com/TheSidSpears/Students/blob/master/app/models/ViewHelper.php#L57
> foreach ($blockedParams as $key => $value) {
>                $url.=$key."=".$value."&";
Что если в value содержится символ &, #, ? или какой-то еще, имеющий специальное значение в УРЛ?

<!-- https://github.com/TheSidSpears/Students/blob/master/app/models/Util.php#L12
>  $result .= $array[mt_rand(0, 35)];
Число 35 надо не вписывать в код, а считать из размера массива.
 -->
<!-- https://github.com/TheSidSpears/Students/blob/master/app/controllers/edit.php
Этот класс на 90% копипаста класса register.php. Ты не должен копипастить код, надо остановиться и подумать, а как можно избежать дублирования кода? Вообще, регистрация и редактирование это практически одно и то же действие.

Те кто копипастят, не думают что будет с кодом дальше, ведь дальше им же самим придется править или добавлять что-то в несколько копий кода.

> if (isset($_COOKIE['hash'])) { //нет кука с хешем => не выполнять скрипт
> ОП, эту куку нужно как-то проверять?
Надо проверять что она соответствует реальному студенту в БД
 -->
<!-- > $token= (isset($_COOKIE['token'])) ? $_COOKIE['token'] : Util::randHash(20);
>    setcookie('token',$token,time()+3600,'/',null,false,true);
Не лучше ли работу с CSRF кукой вынести в отдельный класс? Как ты повторно исплоьзуешь этот код в другом месте? Надо сделать универсальный класс, позволяющий бороться с CSRF в любом контроллере.
 -->
> foreach($editStudent as $fieldName=>&$fieldValue){
Это неправильно. В студенте могут быть поля, которые не должны быть доступны для изменения. более того, их могут добавить уже после написания этого кода.

Более того, ты не уничтожил ссылку после цикла. Перечитай мануал про foreach.

Более того, ты еще и ниже второй раз этот код скопипастил. Не копипасть.

Само редактирвоание на мой взгляд, сделано неправильно. Логичнее взять студента из БД, изменить у него часть полей и сохранить обратно. Ты же предполагаешь что все данные о студенте будет в форме. Но это не обязательно так. Что если например позже добавят какие-то скрытые поля которые есть в студенте но не редактируются через форму? Твой код будет их обнулять.

> $table->editStudent($editStudent);
>                if( empty($table->userErrors) ){
Вот у тебя есть функция, которая может вернуть ошибки. Почему ты использешь лишнее поле вместо return? Вообще, это плохое поле так как например до вызова функции editStudent оно ничего не содержит. А если вызвать функцию несколько раз то ошибки накапливаются в ней и перестают соответствовать действительности. То есть это поле большую часть времени содержит недействительные данные.

<!-- >  header(' ', true, 400); //Так, вроде правильней
Мало того, что это в общем неправильный синтаксис, так ты еще и дальше продолжаешь выполнять код как ни в чем не бывало.
 -->
<!-- https://github.com/TheSidSpears/Students/blob/master/app/models/DataBase.php
Что делает этот класс? Что он добавляет, чего нет в PDO?
 -->
<!-- > public function connection(){
Имена функций начинаются с глагола
 -->
<!-- https://github.com/TheSidSpears/Students/blob/master/app/models/Student.php#L11
> public $name; //string(200)
Этот комментарий может быстро устареть, если поменяют код в валидаторе.
 -->
<!-- https://github.com/TheSidSpears/Students/blob/master/app/models/StudentDataGateway.php#L38
> if (!$rows->execute()){
>            throw new StudentDataGatewayException("Ошибка в ф-ии $func_name: ".__CLASS__);  
Если ты используешь ERRMODE_EXCEPTION то PDO сам выкидывает искючения при ошибке. Этот иф не нужен.
 -->
https://github.com/TheSidSpears/Students/blob/master/app/models/StudentDataGateway.php#L63
> LIKE '%$search%'");
Это SQL инъекция. Не вставляй данные напрямую в запрос

> $count=$rows->fetchAll(PDO::FETCH_ASSOC);
>        return $count[0]["COUNT(*)"];
В PDO есть функция чтобы вернуть первое значение из первой строки.

> foreach ($columns as &$column) {
>            $column=$column["Field"];
Есть array_column для этого

> $students[]=new Student();        
>            $students[count($students)-1]->addInfo($studentRow);
Вместо count(...) лучше просто завести переменную для объекта

> $student=array();
>        $student=$studentRow[0];
Есть функция чтобы взять толкьо первую строку результата

> $alredyRegistered=$this->checkEmail($student->email);
>        if($alredyRegistered){
>            $this->userErrors[]='Такой e-mail уже зарегистрирован';
Разве это не задача валидатора?

<!-- > $error_array = $this->db->errorInfo();
>        if($this->db->errorCode() != 0000){
Это не надо проверять при ERRMODE_EXCEPTION -->

> //Исключение совпадения e-mail'ов разных юзеров
>        $currentStudentData=$this->getStudentByHash($student->hash);
Это делается гораздо проще: надо просто искать по условию WHERE email = ? AND id <> ? 

https://github.com/TheSidSpears/Students/blob/master/app/views/auth_form.php
br вернй признак того, что ты не знаешь CSS. Обрати внимание, в ОП посте есть задачи по CSS.

https://github.com/TheSidSpears/Students/blob/master/app/views/student_form.php
Тут стоит добавить html5 валидацию, хотя бы required например.

> <?php if($s->is_resident): ?>
>    <input type="radio" name="is_resident" value="resident" checked> Местный
> <?php else: ?>
>    <input type="radio" name="is_resident" value="resident"> Местный
Не требуется копипастить input, хватит <?= $resident ? ' checked ' : '' ?>

<!-- https://github.com/TheSidSpears/Students/tree/master/app/views
тут у тебя много файлов и их надо хотя бы по папкам организровать как-то -->

> У меня два файла очень схожи по структуре. Эту копипасту можно как-то сократить? А нужно ли?

Регистрация и редактирования это по сути одно и то же и должен быть 1 контроллер и 1 вью для них.

> засунуть в ф-ию Util::token(). Но тогда ф-ия будет работать с куками и устанавливать глобальную переменную, что, наверное, не очень правильно
надо вынести всю работу с CSRF в класс. 

> set_exeption_handler

Это все работает если ошибка произошла до вывода текста. Если вывод уже начат, то ничего не поделать. 