<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentUsername = $_POST['currentUsername'];
    $newUsername = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $xml = simplexml_load_file('../Data/Users.xml');
    foreach ($xml->user as $user) {
        if ($user->username == $currentUsername) {
            $user->username = $newUsername;
            $user->name = $name;
            $user->password = $password;
            $user->role = $role;
            break;
        }
    }
    $xml->asXML('../Data/Users.xml');
    echo "Информация о сотруднике обновлена.";
}

?>
