<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $xml = simplexml_load_file("../Data/Users.xml") or die("Error: Cannot load file");

    foreach ($xml->user as $user) {
        if ($user->username == $username && $user->password == $password) {
            header("Location: ../index.html");
            exit;
        }
    }
    echo "Неправильное имя пользователя или пароль";
}
?>