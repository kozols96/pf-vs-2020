<?php

use Project\Components\View;

/**
 * @var View $this
 * @var array $array
 */

$this->title = 'Register';

?>

<form action="/sign-up" method="post">
    <div class="form-group">
        <label for="inputName">Name</label>
        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name">
    </div>
    <div class="form-group">
        <label for="inputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We will always share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>