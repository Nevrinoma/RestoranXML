<?php
session_start();
$xml = simplexml_load_file("../Data/Restaurant.xml") or die("Error: Cannot create object");
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tellimus </title>
    <link rel="stylesheet" href="../css/orderStyle.css">
    <script src="../js/confirmLogout.js"></script>
</head>
<body>
<header>
    <nav>
        <a href="../index.php"><img src="../Images/logo.png" alt="Logo"></a>
        <ul>
            <li><a href="menu.php">Menüü</a></li>
            <li><a href="orders.php">Tellimused</a></li>
            <li><a href="tables.php">Lauad</a></li>
            <li><a href="staff.php">Personal</a></li>
        </ul>
        <?php
        if (isset($_SESSION["username"])) {
            echo '<a href="javascript:confirmLogout();">Привет, ' . $_SESSION["username"] . '</a>';
        } else {
            echo '<a href="login.php">Logi sisse</a>';
        }
        ?>
    </nav>
</header>

<main class="main">
    <div class="menu-container">
        <section id="menuItems">
            <?php loadMenu(); ?>
        </section>
    </div>

    <div class="order-constructor">
        <form action="submitOrder.php" method="post">
            <label for="tableId">Выберите столик:</label>
            <select name="tableId" id="tableId">
                <?php foreach ($xml->tables->table as $table): ?>
                    <option value="<?= $table['id'] ?>">Столик <?= $table['id'] ?> (<?= $table['seats'] ?> мест)</option>
                <?php endforeach; ?>
            </select>
            <label for="waiterId">Выберите официанта:</label>
            <select name="waiterId" id="waiterId">
                <?php foreach ($xml->staff->employee as $employee): ?>
                    <option value="<?= $employee['id'] ?>"><?= $employee->name ?></option>
                <?php endforeach; ?>
            </select>
            <fieldset>
                <legend>Выберите блюда:</legend>
                <?php foreach ($xml->menu->dish as $dish): ?>
                    <div>
                        <input type="checkbox" name="dishes[]" id="dish_<?= $dish['id'] ?>" value="<?= $dish['id'] ?>">
                        <label for="dish_<?= $dish['id'] ?>"><?= $dish->name ?> (<?= $dish->price ?>€)</label>

                        <label for="dish_<?= $dish['id'] ?>_qty">Количество:</label>
                        <input type="number" name="dish_qty[<?= $dish['id'] ?>]" id="dish_<?= $dish['id'] ?>_qty" value="1" min="1">

                        <label for="dish_<?= $dish['id'] ?>_desc">Описание:</label>
                        <input type="text" name="dish_desc[<?= $dish['id'] ?>]" id="dish_<?= $dish['id'] ?>_desc">

                    </div>
                <?php endforeach; ?>
            </fieldset>
            <input type="submit" value="Сделать заказ">
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
