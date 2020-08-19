<?php

/**
 * @var View $this
 * @var ActiveUser $user
 */

use Project\Components\ActiveUser;
use Project\Components\View;

$this->title = 'Dashboard';

?>

<h1>Welcome to Dashboard, <?= e($user->name)?></h1>

<quiz-main :user-name="'<?= e($user->name); ?>'"></quiz-main>