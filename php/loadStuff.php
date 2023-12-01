<?php
function loadStaff() {
    $xml = simplexml_load_file("../Data/Users.xml") or die("Error: Cannot load file");

    foreach ($xml->user as $user) {
        if ((string) $user->role !== 'client') {
            $passwordMasked = str_repeat("*", strlen($user->password));
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user->name) . "</td>";
            echo "<td>" . htmlspecialchars($user->username) . "</td>";
            echo "<td onmouseover='showPassword(this)' onmouseout='hidePassword(this)'>" . $passwordMasked . "</td>";
            echo "<td>" . htmlspecialchars($user->role) . "</td>";
            echo "<td><button class='edit-btn' onclick='editStaff(\"" . htmlspecialchars($user->username) . "\", \"" . htmlspecialchars($user->name) . "\", \"" . htmlspecialchars($user->password) . "\", \"" . htmlspecialchars($user->role) . "\")'>Muuda</button>";
            echo "<button class='delete-btn' onclick='deleteStaff(\"" . htmlspecialchars($user->username) . "\")'>Kustuta</button></td>";
            echo "</tr>";
        }
    }
}

loadStaff();
?>
