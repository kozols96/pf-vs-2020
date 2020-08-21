<?php

use Project\Components\Session;
use Project\Components\View;
use Project\Models\QuestionModel;
use Project\Models\QuizModel;
use Project\Structures\QuestionAddItem;
use Project\Structures\QuizAddItem;
use Project\Structures\UserRegisterItem;

/**
 * @var View $this
 * @var QuestionAddItem $questionAddItem
 * @var QuizModel $quiz
 * @var array $errors
 */

$this->title = 'Add question';

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

<form action="/admin/add/question?id=<?=$quiz->id?>" method="post">
    <div class="form-group">
        <label for="inputName">Name</label>
        <input type="hidden"
               name="csrf"
        value="<?=e(Session::getInstance()->getCsrf())?>">
        <input
                type="text"
                name="title"
                class="form-control"
                id="exampleInputEmail1"
                placeholder="Enter title"
                value="<?= e($questionAddItem->title); ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>