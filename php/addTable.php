<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seats = $_POST["seats"];

    $xml = simplexml_load_file("../Data/Restaurant.xml");

    
    $maxId = 0;
    foreach ($xml->tables->table as $table) {
        $id = (int) $table['id'];
        if ($id > $maxId) {
            $maxId = $id;
        }
    }

    $newTable = $xml->tables->addChild("table");
    $newTable->addAttribute("id", strval($maxId + 1)); 
    $newTable->addAttribute("seats", $seats);
    $newTable->addAttribute("occupied", "false"); 

    $xml->asXML("../Data/Restaurant.xml"); 

    header("Location: ../pages/tables.php");
    exit;
}
?>
