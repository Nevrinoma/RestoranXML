<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $xml = simplexml_load_file("../Data/Users.xml") or die("Error: Cannot load file");




    foreach ($xml->user as $user) {
        if ($user->username == $username && $user->password == $password) {
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;  
            header("Location: ../index.php");
            exit;
        }
    }
    echo "Неправильное имя пользователя или пароль";
}

?>
