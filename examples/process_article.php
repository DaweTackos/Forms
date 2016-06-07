<?php
    if (@!include __DIR__ . '/../vendor/autoload.php') {
        die('Install packages using `composer install`');
    }
    \Tracy\Debugger::enable();
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Zpracování článku</title>
    <link rel="stylesheet" type="text/css" href="assets/main.css">
</head>

<div id="wrapper">
    <header>
        <h1>Zpracování článku</h1>
    </header>
    <nav>
        <a href="index.php">Rozcestník</a>
        <br />
        <a href="article_form.php">Vyplnit další článek</a>
    </nav>
    <section>
        <?php if ($_FILES) {echo '$_FILES: '; dump($_FILES); }?>
        <?php if ($_POST) {echo '$_POST: '; dump($_POST); }?>
    </section>
</div>







