<?php use StudentList\Helpers\Util; ?>
<footer class="navbar-bottom row-fluid text-center">
    <div class="col-md-4">
        <a href='<?=Util::html($urlMaker->makeToMainUrl())?>'>Главная</a> <?php //пока не работает не в main ?>
    </div>

    <div class="col-md-4">
        <a href='https://github.com/codedokode/pasta/blob/master/student-list.md'>Техническое задание</a>
    </div>
    
    <div class="col-md-4 ">
        <a href='https://github.com/TheSidSpears/Students'>Git</a> проекта
    </div>
</footer>