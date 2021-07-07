<?php 
session_start();
$email = $_SESSION['email'] = $_POST['email'];
$password = $_SESSION['password'] = $_POST['password'];
require_once '../Models/User.php';
require_once '../Models/Model.php';

// voir si les données de mon POST  du form de indexBis.php existent

$user = new Models\User();
$user->checkUser($email, $password);