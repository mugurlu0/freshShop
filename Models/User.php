<?php 

namespace Models;

require_once("Model.php");

class User extends Model{
    public function createUser($name, $email, $password)
    {
        // vérifier s'il existe dans la base de donnée
        $dbConnection = $this->dbConnect();
        $check = $dbConnection->prepare('SELECT * FROM users WHERE user_email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $rowCount = $check->rowCount();

        
        // rowCount superior a 0 , c'est que la personne existe dans la base donnée
        $userExists = $rowCount > 0;
        if ($userExists) {
            // header('Location: inscription.php?reg_err=already');
            echo 'the user already exists';
            die();
        }

        
        $insert = $dbConnection->prepare("INSERT INTO users(username, user_email, user_password) VALUES(:username, :user_email, :user_password)");
        $insert->bindParam(':username', $name);
        $insert->bindParam(':user_email', $email);
        $insert->bindParam(':user_password', $password);
        $insert->execute();
        //get user last user id from DB
        $last_id = $dbConnection->lastInsertId();
        
        return $insert;
          
    }

    public function checkUser($email, $password){
        $dbConnection = $this->dbConnect();
        if (!empty($_POST['email']) && !empty($_POST['password'])) {

            // stocker les POST dans des  htmlspecialchars pour éviter les piratage 
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
        
            // voir si la personne est bien inscrit dans la base de données
            $check = $dbConnection->prepare('SELECT username, user_email, user_password FROM users WHERE user_email = ?');
            //on met toutes les données dans un tableau 
            $check->execute(array($email));
            // on stocke les donné dans data et on le chercher avec fetch
            $data = $check->fetch();
            // avec rowCount on va vérifier si la table existe
            $row = $check->rowCount();
        
            // si la valeur de rowCount égale à 1 , c'est que la personne  existe
            if ($row == 1) {
                // vérifier que l'adresse email est bien valide
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if (password_verify($password, $data['user_password'])) {
                        $user = new User();
                        $user->email = $data['user_email'];
                        $user->password = $data['user_password'];
        
                        $_SESSION['user'] = $user;
                        header('Location: index.php');
                        die();
                    } else {
                        // header('Location: indexBis.php?login_err=password');
                        die();
                    }
                    // si l'email n'est pas valide on va le renvoyer dans indexBis.php
                } else {
                    // header('Location: indexBis.php?login_err=email');
                    die();
                }
                //Sinon la personne n'existe pas
            } else {
                // header('Location: indexBis.php?login_err=already');
                die();
            }
        }
    }

}