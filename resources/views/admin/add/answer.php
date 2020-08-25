<?php

use Project\Components\Session;
use Project\Components\View;
use Project\Models\QuestionModel;
use Project\Structures\AnswerItem;

/**
 * @var View $this
 * @var AnswerItem $answerAddItem
 * @var QuestionModel $question
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

<form action="/admin/add/answer?id=<?= $question->id; ?>" method="post">
    <div class="form-group">
        <label for="inputTitle">Title</label>
        <input type="hidden"
               name="csrf"
               value="<?=e(Session::getInstance()->getCsrf())?>">
        <input
            type="text"
            name="title"
            class="form-control"
            id="exampleInputEmail1"
            placeholder="Enter title"
            value="<?= e($answerAddItem->title); ?>">

        <label for="chooseIsCorrect">Is it correct?</label>

        <select class="form-control"
                name="is_correct">
          <option value="<?= !$answerAddItem->is_correct; ?>">Yes</option>
          <option value="<?= $answerAddItem->is_correct; ?>">No</option>
        </select>

    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>