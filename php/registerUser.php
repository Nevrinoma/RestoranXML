<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["newUsername"];
    $newPassword = $_POST["newPassword"];
    $role = $_POST["role"]; // Получение роли из формы

    $xml = simplexml_load_file("../Data/Users.xml") or die("Error: Cannot load file");

    foreach ($xml->user as $user) {
        if ($user->username == $newUsername) {
            echo "Пользователь с таким именем уже существует";
            exit;
        }
    }

    $newUser = $xml->addChild("user");
    $newUser->addChild("username", $newUsername);
    $newUser->addChild("password", $newPassword);
    $newUser->addChild("role", $role); // Добавление роли пользователя

    $xml->asXML("../Data/Users.xml");

    echo "Пользователь успешно зарегистрирован";
}
?>
