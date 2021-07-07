<?php
session_start();
require_once '../Models/User.php';
require_once '../Models/Model.php';

$model = new Models\Model();

// on vérifie si toute les variables POST existe
$registrationIsFilled = !empty($_POST['name']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password']) &&
    !empty($_POST['confirm_password']);

// if (!$registrationIsFilled) {
//     return;
// }

// on stocke dans des htmlspecialchars pour ne pas se faire pirater
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$password_retype = htmlspecialchars($_POST['confirm_password']);






// le nombre de caractère du nom est trop grand
if (strlen($name) > 100) {
    // header('Location: inscription.php?reg_err=firstName_length');
    echo 'the name is too long';
    die();
}


// le nombre de caractère d'adresse mail est  est trop grand 
if (strlen($email) > 100) {
    // header('Location: inscription.php?reg_err=email_length');
    echo 'the mail address is too long';
    die();
}

// vérifier que l'adresse email est bien valide
$isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$isEmailValid) {
    // header('Location: inscription.php?reg_err=email');
    echo 'the email address is not valid';
    die();
}

if ($password != $password_retype) {
    // header('Location: inscription.php?reg_err=password');
    echo 'the password doesn\'t match the password retype field';
    die();
}

$cost = ['cost' => 12];
//  toujours hasher le mot de passe avec des algorithme de hash 
//  car ça peut compromettre les données de l'utilisateur
$password = password_hash($password, PASSWORD_BCRYPT, $cost);

#dbprocessing

require_once '../controllers/UsersController.php';

addUser($name, $email,$password);

//insert user role
// $inserationUserRole = "INSERT INTO user_roles (`user_id`, `role_id` ) VALUES($last_id, 2)";
// try {
//     $result = $dbConnection->exec($inserationUserRole);
// } catch (PDOException $exception) {
//     echo $exception->getMessage();
// }

// header('Location:inscription.php?reg_err=success');
echo 'you are registered successfully';
$_SESSION['name']= $name;
header("Location: index.php?name='.$name.'");