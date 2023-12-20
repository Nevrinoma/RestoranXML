<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST["Name"]; 
    $newUsername = $_POST["newUsername"];
    $newPassword = $_POST["newPassword"];
    $role = $_POST["role"]; 

    $usersXml = simplexml_load_file("../Data/Users.xml") or die("Error: Cannot load Users.xml");
    $restaurantXml = simplexml_load_file("../Data/Restaurant.xml") or die("Error: Cannot load Restaurant.xml");
    foreach ($usersXml->user as $user) {
        if ($user->username == $newUsername) {
            echo "Selle nimega kasutaja on juba olemas";
            exit;
        }
    }

    $newUser = $usersXml->addChild("user");
    $newUser->addChild("name", $Name); 
    $newUser->addChild("username", $newUsername);
    $newUser->addChild("password", $newPassword);
    $newUser->addChild("role", $role); 
    $usersXml->asXML("../Data/Users.xml");

    $newId = "e" . str_pad((count($restaurantXml->staff->employee) + 1), 2, "0", STR_PAD_LEFT);

    $newEmployee = $restaurantXml->staff->addChild("employee");
    $newEmployee->addAttribute("id", $newId);
    $newEmployee->addAttribute("role", $role);
    $newEmployee->addChild("name", $Name);
    $restaurantXml->asXML("../Data/Restaurant.xml");

    header("Location: ../pages/login.php");
    exit;
}
?>
