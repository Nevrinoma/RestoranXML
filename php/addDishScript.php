<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $xml = simplexml_load_file("../Data/Restaurant.xml") or die("Error: Cannot create object");

    $maxId = 0;
    foreach ($xml->menu->dish as $dish) {
        $id = (int) $dish['id'];
        if ($id > $maxId) {
            $maxId = $id;
        }
    }

    $newDish = $xml->menu->addChild("dish");
    $newDish->addAttribute("id", strval($maxId + 1));
    $newDish->addChild("name", $_POST["name"]);
    $newDish->addChild("price", $_POST["price"]);
    $newDish->addChild("allergyTags", $_POST["allergens"]);
    $newDish->addAttribute("type", $_POST["type"]);


    $xml->asXML("../Data/Restaurant.xml");

    header("Location: ../pages/menu.php");
}
?>
