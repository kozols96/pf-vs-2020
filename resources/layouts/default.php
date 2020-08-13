<?php

use Project\Components\View;

/**
 * @var View $this
 */

?>

<head>
    <title>Default layout</title>
</head>
<body>
<h1>Header</h1>
<?=$this->renderViewContent() ?>
<h1>Footer</h1>
</body>
