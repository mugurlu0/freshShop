<?php 
session_start();
$title = 'Log in'; ?>

<?php ob_start(); ?>

<h1><?=$title?></h1>

<form action="signin.php" method="post">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="submit" value="Submit">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('layouts/app.php'); 

$_SESSION['email'] = $_POST['email'];
$_SESSION['password'] = $_POST['password'];
?>