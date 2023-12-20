<?php
function xmlToJson($xmlFilePath, $jsonFilePath) {
    $xml = simplexml_load_file($xmlFilePath);
    if (!$xml) {
        throw new Exception("XML-faili laadimine ebaõnnestus: $xmlFilePath");
    }

    $json = json_encode($xml);

    if (!file_put_contents($jsonFilePath, $json)) {
        throw new Exception("JSON-faili kirjutamine ebaõnnestus: $jsonFilePath");
    }

    return "Fail on edukalt konverteeritud: $jsonFilePath";

    echo "<p><a href='../index.php'>Tagasi</a></p>";
}


try {
    echo xmlToJson("../Data/Restaurant.xml", "../Data/Restaurant.json");
    echo xmlToJson("../Data/Users.xml", "../Data/Users.json");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
