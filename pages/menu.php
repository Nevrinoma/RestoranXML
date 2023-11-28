<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menüü - Teie Restoran</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <nav>
        <a href="../index.html"><img src="../Images/logo.png" alt="Logo"></a>
        <ul>
            <li><a href="menu.php">Menüü</a></li>
            <li><a href="pages/orders.html">Tellimused</a></li>
            <li><a href="pages/tables.html">Lauad</a></li>
            <li><a href="pages/staff.html">Personal</a></li>
        </ul>
        <a href="pages/login.php" id="loginButton">Logi sisse</a>
    </nav>
</header>

<main class="main">
    <div class="menu-container">
        <section id="menuItems">
            <?php loadMenu(); ?>
        </section>
    </div>

    <div class="add-dish-form">
        <h2>Lisa uus roog</h2>
        <form action="../php/addDishScript.php" method="post">
            <input type="text" name="name" placeholder="Roogi nimetus" required>
            <input type="text" name="price" placeholder="Hind" required>
            <select name="type">
                <option value="main">Põhiroog</option>
                <option value="appetizer">Eelroog</option>
                <option value="drink">Jook</option>
            </select>
            <input type="text" name="allergens" placeholder="Allergeenid">
            <button type="submit">Lisa</button>
        </form>

    </div>
</main>


<footer>
    <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
    <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
</footer>
</body>
</html>

<?php
function loadMenu() {
    $xml = simplexml_load_file("../Data/Restaurant.xml") or die("Error: Cannot create object");
    $types = ['main' => 'Pearoad', 'appetizer' => 'Suupisted', 'drink' => 'Joogid'];

    foreach ($types as $type => $typeName) {
        echo "<h2>" . $typeName . "</h2>";
        echo "<div class='menu-type'>";
        foreach ($xml->menu->dish as $dish) {
            if ($dish['type'] == $type) {
                echo "<div class='menu-item'>";
                echo "<h3>" . $dish->name . "</h3>";
                echo "<p>Hind: " . $dish->price . "€</p>";
                echo "<p>Allergeenid: " . $dish->allergyTags . "</p>";
                echo "</div>";
            }
        }
        echo "</div>";
    }
}

?>
