<?php if(isset($message)): ?>
    
    <?php switch ($message) {
        case 'register_succsess':?>
            <div class="alert alert-success" role="alert">
                Вы успешно зарегистрировались
            </div>
            <?php
            break;
        case 'edit_succsess':?>
            <div class="alert alert-success" role="alert">
                Вы успешно изменили свои данные
            </div>
            <?php break;
        case 'access_denied':?>
            <div class="alert alert-danger" role="alert">
                Доступ запрещен
            </div>
            <?php break;
    } ?>
<?php endif; ?>