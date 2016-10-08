
<?php if(!empty($validErrors)): ?>
<div class="col-md-12">
    <div class="alert alert-danger">
        <ul>
        <?php foreach($validErrors as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>