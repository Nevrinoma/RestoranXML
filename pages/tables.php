<?php
session_start();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Столы Ресторана</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
<nav>
    <a href="../index.php"><img src="../Images/logo.png" alt="Logo"></a>
    <ul>
        <?php
        if (empty($_SESSION['role'])) {
            echo '<li><a href="login.php">Menu</a></li>';
            echo '<li><a href="login.php">Tellimused</a></li>';
            echo '<li><a href="login.php">Lauad</a></li>';
            echo '<li><a href="login.php">Töötajad</a></li>';
        } elseif ($_SESSION['role'] == 'client') {
            echo '<li><a href="menuCustomer.php">Menu</a></li>';
            echo '<li><a href="myOrders.php">Minu tellimus</a></li>';
        } elseif ($_SESSION['role'] == 'waiter') {
            echo '<li><a href="orders.php">Tellimused</a></li>';
            echo '<li><a href="tables.php">Lauad</a></li>';
        } elseif ($_SESSION['role'] == 'chef') {
            echo '<li><a href="orders.php">Tellimused</a></li>';
            echo '<li><a href="menu.php">Menu(Lisa uus)</a></li>';
            echo '<li><a href="staff.php">Töötajad</a></li>';
        }
        ?>
    </ul>
    <?php
    if (isset($_SESSION["username"])) {
        echo '<a href="javascript:confirmLogout(false);">Tere, ' . $_SESSION["name"] . '</a>';
    } else {
        echo '<a href="pages/login.php">Logi sisse või Registreeri</a>';
    }
    ?>
</nav>
</header>
    <main>
        <h1>Столы Ресторана</h1>
        <div class="tables-container">
            <?php
                $xml = simplexml_load_file("../Data/Restaurant.xml");
                foreach ($xml->tables->table as $table) {
                    echo "<div class='table'>";
                    echo "<h2>Стол №" . $table['id'] . "</h2>";
                    echo "<p>Мест: " . $table['seats'] . "</p>";
                    echo "<p>Занят: " . ($table['occupied'] == 'true' ? 'Да' : 'Нет') . "</p>";
                    
                    echo "</div>";
                }
            ?>
        </div>
        <div class="add-dish-form">
        <form action="../php/addTable.php" method="post">
            <h1>Lisa uus: </h1>
            <label for="seats">Количество мест:</label>
            <input type="number" name="seats" id="seats" required>

            <input type="submit" value="Добавить стол">
        </form>
        </div>
    </main>
    <footer>
        <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
        <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
    </footer>
</body>
</html>
