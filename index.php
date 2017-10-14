<?php include_once 'logic.php' ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <form method="post" action="index.php">
            <div>
                <input type="text" name="contact_form[username]" placeholder="Your name">
                <br>
                <br>
            </div>
            <div>
                <textarea name="contact_form[message]" cols="30" rows="10" placeholder="Your message"></textarea><br>
            </div>
            <div>
                <input type="submit">
            </div>
        </form>
        <?php if(isset($comments)) :?>
            <?php var_dump($comments) ?>
            <ul>
            <?php foreach($comments as $comment) :?>
                <li><b><?= $comment['username'] ?></b><br><p><?= $comment['message'] ?></p></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if(isset($error)) :?>
            <b>!!! <?= $error ?> !!!</b>
        <?php endif; ?>
    </body>
</html>
