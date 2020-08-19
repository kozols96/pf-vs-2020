<?php

use Project\Components\ActiveUser;
use Project\Components\Session;
use Project\Components\View;

/**
 * @var View $this
 */

?>

<head>
  <title><?= $this->title ?></title>
  <link rel="stylesheet" href="/assets/style.css">
  <script>
    window.csrf = "<?= e(Session::getInstance()->getCsrf()); ?>"
  </script>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-light bg-light">
  <a class="navbar-brand" href="/">Quiz</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <?php if (ActiveUser::isLoggedIn()): ?>

          <li class="nav-item">
            <a class="nav-link" href="/dashboard">Dashboard</a>
          </li>

            <?php if (ActiveUser::getUser()->is_admin): ?>
            <li class="nav-item">
              <a class="nav-link" href="/admin">Admin</a>
            </li>
            <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link" href="/logout"
               onclick="onLogoutClicked()">Logout</a>
          </li>

          <form id="js--logout-form" action="/logout" method="post">
            <input type="hidden" name="csrf" value="<?= e(Session::getInstance()->getCsrf()) ?>">
          </form>

        <?php else: ?>

          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/sign-up">Register</a>
          </li>

        <?php endif; ?>
    </ul>
  </div>
</nav>


<div id="app" class="container">
    <?php if (Session::getInstance()->hasSuccessMessage()): ?>
      <div class="alert alert-success">
          <?= e(Session::getInstance()->getSuccessMessage()) ?>
      </div>
    <?php endif; ?>

    <?php if (Session::getInstance()->hasErrorMessage()): ?>
      <div class="alert alert-danger">
          <?= e(Session::getInstance()->getErrorMessage()) ?>
      </div>
    <?php endif; ?>
    <?= $this->content ?>
</div>

<script>
    function onLogoutClicked() {
        event.preventDefault();
        document.getElementById('js--logout-form').submit();
    }
</script>
<script src="/assets/script.js"></script>
</body>
