<?php
require_once('../Models/User.php');

function addUser($name, $email, $password)
{
    $user = new \Models\User();

    $affectedLines = $user->createUser($name, $email, $password);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter l\'utilisateur !');
    }
    else {
        // header('Location: index.php?action=post&id=' . $postId);
        echo 'User added successfully';
    }
}
