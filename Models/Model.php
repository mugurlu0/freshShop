<?php

namespace Models;
   
class Model
{
    protected function dbConnect()
{
    $dbConnection = new \PDO('mysql:host=localhost;dbname=freshshop;charset=utf8', 'root', '');
    return $dbConnection;
} 
} 

