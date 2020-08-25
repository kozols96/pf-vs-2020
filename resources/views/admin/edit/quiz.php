<?php

use Project\Components\Session;
use Project\Components\View;
use Project\Exceptions\AdminValidationException;
use Project\Models\QuizModel;

/**
 * @var View $this
 * @var QuizModel $quiz
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

<form action="/admin/edit/quiz?id=<?= $quiz->id; ?>" method="post">
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
            value="<?= e($quiz->name); ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
