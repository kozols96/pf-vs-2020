<?php

use Project\Components\View;
use Project\Models\QuizModel;
use Project\Models\UserModel;

/**
 * @var View $this
 * @var UserModel[] $users
 * @var QuizModel[] $quizzes
 */

$this->title = 'Admin panel';

?>

<table class="table">
  <thead>
  <tr>
    <th>ID</th>
    <th>Email</th>
    <th>Name</th>
    <th>Joined at</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user): ?>
    <tr>
      <td><?= $user->id; ?></td>
      <td><?= e($user->email); ?></td>
      <td><?= e($user->name); ?></td>
      <td><?= $user->created_at; ?></td>
      <td>
        <a class="btn btn-sm btn-success" href="/admin/view-user?id=<?= urlencode($user->id); ?>">
          View
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<h2>All admin users</h2>
<table class="table">
  <thead>
  <tr>
    <th>ID</th>
    <th>Email</th>
    <th>Name</th>
    <th>Joined at</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user): ?>
      <?php if ($user->is_admin): ?>
      <tr>
        <td><?= $user->id; ?></td>
        <td><?= e($user->email); ?></td>
        <td><?= e($user->name); ?></td>
        <td><?= $user->created_at; ?></td>
        <td>
          <a class="btn btn-sm btn-success" href="/admin/view-user?id=<?= urlencode($user->id); ?>">
            View
          </a>
        </td>
      </tr>
      <?php endif; ?>
  <?php endforeach; ?>
  </tbody>
</table>

<h2>All quizzes</h2>
<table class="table">
  <thead>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Question count</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($quizzes as $quiz): ?>
    <tr>
      <td><?= $quiz->id; ?></td>
      <td><?= e($quiz->name); ?></td>
      <td><?= $quiz->questions()->count() ?></td>
      <td>
        <a class="btn btn-sm btn-warning" href="/admin/edit/quiz?id=<?= urlencode($quiz->id); ?>">
          Edit
        </a>
        <a class="btn btn-sm btn-success" href="/admin/view-quiz?id=<?= urlencode($quiz->id); ?>">
          View
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a class="btn btn-lg btn-success"
   href="/admin/add/quiz">
  Add new quiz</a>
