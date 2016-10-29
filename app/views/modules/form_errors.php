<?php if(!empty($validErrors)): ?>
<div class="col-md-12">
    <div class="alert alert-danger" role="alert">
        <ul>
        <?php foreach($validErrors as $error): ?>
            <li style="list-style-type: none;">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <?=$error?>  
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>