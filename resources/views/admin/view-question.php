<?php


use Project\Components\View;
use Project\Models\QuestionModel;

/**
 * @var View $this
 * @var QuestionModel $questions
 */


$this->title = 'Question : ' . e($questions->title);

?>

<h2><?= e($questions->title); ?></h2>
<table class="table">
  <thead>
  <tr>
    <th>Answer ID</th>
    <th>Answer</th>
    <th>Is correct</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($questions->answers as $answer): ?>
    <tr>
      <td><?= $answer->id; ?></td>
      <td><?= e($answer->title); ?></td>
      <td><?php if ($answer->is_correct): ?>
          Yes
          <?php else: ?>
          No
          <?php endif; ?>
      </td>
      <td>
        <a class="btn btn-sm btn-warning"
           href="/admin/edit/answer?id=<?= urlencode($answer->id); ?>">
          Edit
        </a>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a class="btn btn-lg btn-success"
   href="/admin/add/answer?id=<?= $questions->id; ?>">
  Add new answer</a>