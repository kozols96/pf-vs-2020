<?php

use Project\Components\View;

/**
 * @var View $this
 * @var array $array
 */

$this->title = 'Index page';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vue.js TODO app</title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body>
<h1>Vue.js TODO app</h1>
<div id="app">
    <div v-if="showObject">
        <input type="text" :placeholder="object.id"/>
        <input type="text" :placeholder="object.email"/>
    </div>

    <button @click="showObject = !showObject">Show object</button>
</div>

<script>

    new Vue({
        el: '#app',
        data: {
            showObject: false,
            object: {
                id: 1,
                name: 'name',
                email: 'karlis@gmail.com',
            }},

    });
</script>
</body>
<html>
