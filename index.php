<?php
session_start();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teie Restoran</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="../js/confirmLogout.js"></script>
</head>
<body>
<header>
    <nav>
        <a href="index.php"><img src="Images/logo.png" alt="Logo"></a>
        <ul>
            <li><a href="pages/menu.php">Menüü</a></li>
            <li><a href="pages/orders.php">Tellimused</a></li>
            <li><a href="pages/tables.php">Lauad</a></li>
            <li><a href="pages/staff.php">Personal</a></li>
        </ul>
        <?php
        if (isset($_SESSION["username"])) {
            echo '<a href="javascript:confirmLogout();">Привет, ' . $_SESSION["username"] . '</a>';
        } else {
            echo '<a href="pages/login.php">Logi sisse</a>';
        }
        ?>
    </nav>
</header>
<img src="Images/restWidePict.jpg" alt="Фото ресторана" id="restaurant-photo">


<section id="dashboard">
    <h2>Juhtpaneel</h2>
    <div class="dashboard-item">
        <p>Aktiivseid tellimusi: <span id="activeOrders">0</span></p>
    </div>
    <div class="dashboard-item">
        <p>Vabu laudu: <span id="freeTables">0</span></p>
    </div>
    <div class="dashboard-item">
        <p>Köögi staatus: <span id="kitchenStatus">Avatud</span></p>
    </div>
</section>

<section id="quickAccess">
    <h2>Kiirjuurdepääs</h2>
    <button onclick="location.href='pages/addOrder.html'">Lisa tellimus</button>
    <button onclick="location.href='pages/menu.php'">Vaata menüüd</button>
</section>

<section id="notifications">
    <h2>Teated</h2>
    <div id="notificationArea">

    </div>
</section>

<footer>
    <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
    <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
</footer>

</body>
</html>
