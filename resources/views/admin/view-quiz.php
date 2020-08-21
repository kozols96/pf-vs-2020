<?php

use Project\Components\View;
use Project\Models\QuizModel;

/**
 * @var View $this
 * @var QuizModel $quizzes
 */


$this->title = 'Quiz : '.e($quizzes->name);

?>

<h2><?= e($quizzes->name); ?></h2>
<table class="table">
  <thead>
  <tr>
    <th>Question ID</th>
    <th>Question</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($quizzes->questions as $question): ?>
    <tr>
      <td><?= $question->id; ?></td>
      <td><?= e($question->title); ?>
      </td>
      <td><a class="btn btn-sm btn-warning"
             href="/admin/edit/question?id=<?= urlencode($question->id); ?>">
          Edit
        </a>
        <a class="btn btn-sm btn-success"
           href="/admin/view-question?id=<?= urlencode($question->id); ?>">
          View
        </a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a class="btn btn-lg btn-success"
   href="/admin/add/question?id=<?=urlencode($quizzes->id)?>">
  Add new question</a>