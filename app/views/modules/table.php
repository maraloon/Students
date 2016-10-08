<?php use StudentList\Helpers\Util; ?>
<?php if(count($students)==0): ?>
    Совпадений не найдено
<?php else: ?>
    <table class="table table-striped">
        
        <thead>
            <tr>
                <th>
                    <?=$urlMaker->showSortOrder('name')?>
                    <a href='<?=Util::html($urlMaker->makeSortUrl('name'))?>'>Имя</a>
                </th>

                <th>
                    <?=$urlMaker->showSortOrder('sname')?>
                    <a href='<?=Util::html($urlMaker->makeSortUrl('sname'))?>'>Фамилия</a>
                </th>

                <th>
                    <?=$urlMaker->showSortOrder('group_num')?>
                    <a href='<?=Util::html($urlMaker->makeSortUrl('group_num'))?>'>Номер группы</a>
                </th>

                <th>
                    <?=$urlMaker->showSortOrder('points')?>
                    <a href='<?=Util::html($urlMaker->makeSortUrl('points'))?>'>Баллов</a>
                </th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($students as $student):?>
                <?php if( (isset($user->email)) and ($user->email==$student->email) ):?>
                    <tr class="active">
                <?php else: ?>
                    <tr>    
                <?php endif;?>
                



                <td><?=Util::highlight(Util::html($student->name),$find)?></td>
                <td><?=Util::highlight(Util::html($student->sname),$find)?></td>
                <td><?=Util::highlight(Util::html($student->group_num),$find)?></td>
                <td><?=Util::highlight(Util::html($student->points),$find)?></td>

            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    
    <?php if($pages>1): ?>
        <div class="col-md">
            <ul class="pagination">

            <?php if($currentPage>1): ?>
                <li><a href='<?=Util::html($urlMaker->makePageUrl($currentPage-1))?>'>&laquo;</a></li>
            <?php endif;?>

            <?php for($i=1; $i<=$pages; $i++): ?>
                <?php if($i==$currentPage): ?>
                    <li class="active"><a href='#'><?=$i?></a></li>    
                <?php else: ?>
                    <li><a href='<?=Util::html($urlMaker->makePageUrl($i))?>'><?=$i?></a></li>
                <?php endif;?>    
            <?php endfor;?>
            
            <?php if($currentPage!=$pages): ?>
                <li><a href='<?=Util::html($urlMaker->makePageUrl($currentPage+1))?>'>&raquo;</a></li>
            <?php endif;?>

            </ul>
        </div>
    <?php endif;?>


<?php endif;?>