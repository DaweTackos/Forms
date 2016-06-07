<?php

    if (@!include __DIR__ . '/../vendor/autoload.php') {
        die('Install packages using `composer install`');
    }
    \Tracy\Debugger::enable();

    define('INPUT_TEXT_SIZE', 25);

    $form = new \Forms\Form('articleForm');
    $form->setAction('process_article.php');

    $form->addGroup('article', 'Článek');
    $form->addText('name', 'Název:', INPUT_TEXT_SIZE)
            ->setRequired();
    $form->addText('h1', 'Nadpis:', INPUT_TEXT_SIZE);
    $form->addTextArea('annotation', 'Anotace:', 60, 5)
            ->setPlaceholder('Anotace...');
    $form->addTextArea('content', 'Obsah:', 60, 15)
            ->setPlaceholder('Obsah článku...');
    $form->addFile('image', 'Obrázek:');

    $form->addGroup('seo', 'Seo informace');
    $form->addText('title', 'Titulek:', INPUT_TEXT_SIZE);
    $form->addTextArea('keywords', 'Klíčová slova:', 60, 2);
    $form->addTextArea('description', 'Popis:', 60, 10);
    $form->addText('url', 'URL adresa:', INPUT_TEXT_SIZE)
            ->setType('url');

    $form->clearGroupPointer();
    $form->addSubmit('submit', 'Send')
            ->setValue('send');
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Editace článku</title>
    <link rel="stylesheet" type="text/css" href="assets/main.css">
</head>

<div id="wrapper">
    <header>
        <h1>Editace článku</h1>
    </header>
    <nav>
        <a href="index.php">Rozcestník</a>
    </nav>
    <section>
        <?php echo $form->render(); ?>
    </section>
</div>

<?php if ($_FILES) {echo '$_FILES: '; dump($_FILES); }?>
<?php if ($_POST) {echo '$_POST: '; dump($_POST); }?>





