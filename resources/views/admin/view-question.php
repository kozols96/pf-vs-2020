<?php


use Project\Components\View;
use Project\Models\QuestionModel;

/**
 * @var View $this
 * @var QuestionModel $questions
 */


$this->title = 'Question : '.e($questions->title);

?>

<h2><?= e($questions->title); ?></h2>
<table class="table">
  <thead>
  <tr>
    <th>Answer ID</th>
    <th>Answer</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($questions->answers as $answer): ?>
    <tr>
      <td><?= $answer->id; ?></td>
      <td><?= e($answer->title); ?></td>
      <td>
        <a class="btn btn-sm btn-warning"
           href="/admin/edit-question?id=<?= urlencode($answer->id); ?>">
          Edit
        </a>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a class="btn btn-lg btn-success"
   href="/admin/add/quiz">
  Add new answer</a>