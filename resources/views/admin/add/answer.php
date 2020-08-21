<?php

use Project\Components\Session;
use Project\Components\View;
use Project\Structures\AnswerAddItem;

/**
 * @var View $this
 * @var AnswerAddItem $answerAddItem
 * @var array $errors
 */

$this->title = 'Add answer';

?>

<?php if (!empty($errors)): ?>

    <div class ="alert alert-danger" role="alert">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php endif;?>

<form action="/admin/add/answer" method="post">
    <div class="form-group">
        <label for="inputName">Name</label>
        <input type="hidden"
               name="csrf"
               value="<?=e(Session::getInstance()->getCsrf())?>">
        <input
            type="text"
            name="name"
            class="form-control"
            id="exampleInputEmail1"
            placeholder="Enter name"
            value="<?= e($answerAddItem->name); ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>