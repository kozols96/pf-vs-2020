<?php

use Project\Components\Session;
use Project\Components\View;
use Project\Exceptions\AdminValidationException;
use Project\Models\QuestionModel;
use Project\Structures\QuestionItem;


/**
 * @var View $this
 * @var QuestionModel $question
 * @var QuestionItem $questionItem
 * @var AdminValidationException $errors
 */

$this->title = 'Edit quiz';
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

<form action="/admin/edit/question?id=<?= $question->id; ?>" method="post">
    <div class="form-group">
        <label for="inputName">Title</label>
        <input type="hidden"
               name="csrf"
               value="<?=e(Session::getInstance()->getCsrf())?>">
        <input
            type="text"
            name="title"
            class="form-control"
            id="exampleInputEmail1"
            placeholder="Enter title"
            value="<?= e($question->title); ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>