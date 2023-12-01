<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];


    $xml = new SimpleXMLElement('../Data/Users.xml', 0, true);

    $index = 0;
    $i = 0;
    foreach ($xml->user as $user) {
        if ($user->username == $username) {
            $index = $i;
            break;
        }
        $i++;
    }
    unset($xml->user[$index]);

    $xml->asXML('../Data/Users.xml');

    echo "Сотрудник удален.";
}
?>
