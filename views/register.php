<?php $title = 'Sign up'; ?>

<?php ob_start(); ?>

<h1><?=$title?></h1>

<form action="./processing.php" method="post">
    <input type="text" name="name">
    <input type="email" name="email">
    <input type="password" name="password">
    <input type="password" name="confirm_password">
    <input type="submit" name="submit" value="Submit">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layouts/app.php'); ?>