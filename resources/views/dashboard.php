<?php

/**
 * @var View $this
 * @var ActiveUser $user
 */

use Project\Components\ActiveUser;
use Project\Components\Session;
use Project\Components\View;

$this->title = 'Dashboard';

$isQuizActive = (bool)Session::getInstance()->get(Session::KEY_CURRENT_ATTEMPT_ID);

?>

<h1>Welcome to Dashboard, <?= e($user->name)?></h1>

<quiz-main :user-name="'<?= e($user->name); ?>'" :p-is-quiz-active="<?= json_encode($isQuizActive); ?>">
</quiz-main>