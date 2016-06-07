<?php

    if (@!include __DIR__ . '/../vendor/autoload.php') {
        die('Install packages using `composer install`');
    }
    \Tracy\Debugger::enable();

    define('INPUT_TEXT_SIZE', 25);

    $form = new \Forms\Form('myForm');

    $form->addGroup('text-elements-group', 'Text elements');
    $form->addText('text', 'Text:', INPUT_TEXT_SIZE);
    $form->addText('text-disabled', 'Text disabled:', INPUT_TEXT_SIZE)
            ->setDisabled();
    $form->addText('text-required', 'Text required:', INPUT_TEXT_SIZE)
            ->setRequired();
    $form->addText('text-placeholder', 'Text placeholder:', INPUT_TEXT_SIZE)
            ->setPlaceholder('Placeholder...');
    $form->addText('text-prefilled', 'Text prefilled:', INPUT_TEXT_SIZE)
            ->setValue('Prefilled input');
    $form->addText('text-limited', 'Max 5 chars text:', INPUT_TEXT_SIZE)
            ->setMaxLength(5);
    $form->addTextArea('text-area', 'TextArea:', 40, 5);
    $form->addText('number', 'Number input:', INPUT_TEXT_SIZE)
            ->setType('number');
    $form->addText('date', 'Date input:', INPUT_TEXT_SIZE)
            ->setType('date');
    $form->addPassword('password', 'Password:', INPUT_TEXT_SIZE);

    $form->addGroup('another-group', 'Another group');
    $form->addText('textInput', 'Text:', INPUT_TEXT_SIZE);
    $form->addFile('group-file', 'File from group:');
    $form->addFile('group-file2', 'File2 from group:');

    $form->clearGroupPointer();
    $form->addFile('file', 'Without group file:');
    $form->addText('text-no-group', 'Without group input:', INPUT_TEXT_SIZE);
    $form->addSubmit('submit', 'Send')
        ->setValue('send');
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Form basic example</title>
    <link rel="stylesheet" type="text/css" href="assets/main.css">
</head>

<div id="wrapper">
    <header>
        <h1>All form features</h1>
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





