<?php
session_start();
$xml = simplexml_load_file("Data/Restaurant.xml") or die("Error: Cannot load XML.");
$usersXml = simplexml_load_file("Data/Users.xml") or die("Error: Cannot load XML.");

$activeOrders = 0;
$freeTables = 0;

foreach ($xml->orders->order as $order) {
    if ($order->status == 'active') {
        $activeOrders++;
    }
}

foreach ($xml->tables->table as $table) {
    if ($table['occupied'] == 'false') {
        $freeTables++;
    }
}

$kitchenStatus = ($activeOrders > 5) ? 'Ei tööta' : 'Avatud';

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teie Restoran</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/confirmLogout.js"></script>
</head>
<body>
<header>
<nav>
    <a href="index.php"><img src="Images/logo.png" alt="Logo"></a>
    <ul>
        <?php
        if (empty($_SESSION['role'])) {
            echo '<li><a href="pages/login.php">Menu</a></li>';
            echo '<li><a href="pages/login.php">Tellimused</a></li>';
            echo '<li><a href="pages/login.php">Lauad</a></li>';
            echo '<li><a href="pages/login.php">Töötajad</a></li>';
        } elseif ($_SESSION['role'] == 'client') {
            echo '<li><a href="pages/menuCustomer.php">Menu</a></li>';
            echo '<li><a href="pages/myOrders.php">Minu tellimus</a></li>';
        } elseif ($_SESSION['role'] == 'waiter') {
            echo '<li><a href="pages/orders.php">Tellimused</a></li>';
            echo '<li><a href="pages/tables.php">Lauad</a></li>';
        } elseif ($_SESSION['role'] == 'chef') {
            echo '<li><a href="pages/orders.php">Tellimused</a></li>';
            echo '<li><a href="pages/menu.php">Menu(Lisa uus)</a></li>';
            echo '<li><a href="pages/staff.php">Töötajad</a></li>';
        }
        ?>
    </ul>
    <?php
    if (isset($_SESSION["username"])) {
        echo '<a href="javascript:confirmLogout(true);">Tere, ' . $_SESSION["name"] . '</a>';
    } else {
        echo '<a href="pages/login.php">Logi sisse või Registreeri</a>';
    }
    ?>
</nav>


</header>
<img src="Images/restWidePict.jpg" alt="Restoraani pilt" id="restaurant-photo">


<section id="dashboard">
    <h2>Juhtpaneel</h2>
    <div class="dashboard-item">
        <p>Aktiivseid tellimusi: <span id="activeOrders"><?= $activeOrders ?></span></p>
    </div>
    <div class="dashboard-item">
        <p>Vabu laudu: <span id="freeTables"><?= $freeTables ?></span></p>
    </div>
    <div class="dashboard-item">
        <p>Köögi staatus: <span id="kitchenStatus"><?= $kitchenStatus ?></span></p>
    </div>
</section>

<section id="quickAccess">
    <h2>Kiirjuurdepääs</h2>
    <button onclick="location.href='pages/addOrder.php'">Lisa tellimus</button>
    <button onclick="location.href='pages/menuCustomer.php'">Vaata menüüd</button>
    <button onclick="location.href='php/xmlToJson.php'">XML -> JSON</button>
    <br><br>
    <a href="https://lember21.thkit.ee/RestoranXML/Data/Restaurant.xml">Restoran XML fail</a><br>
    <a href="https://lember21.thkit.ee/RestoranXML/Data/Users.xml">Users XML fail</a><br>
    <a href="https://lember21.thkit.ee/RestoranXML/Data/Restaurant.json">Restoran JSON fail</a><br>
    <a href="https://lember21.thkit.ee/RestoranXML/Data/Users.json">RestoranXML JSON</a><br>
</section>

<section id="notifications">
    <h2>Teated</h2>
    <div id="notificationArea">
        <?php
        if (empty($_SESSION['role'])) {
            echo '<li><a href="pages/login.php">Logi Sisse</a></li>';
        } elseif ($_SESSION['role'] == 'waiter') {
            $readyOrders = [];
            $waiterId = null;
            foreach ($xml->staff->employee as $employee) {
                if ($employee->name == $_SESSION['name'] && $employee['role'] == 'waiter') {
                    $waiterId = (string)$employee['id'];
                    break;
                }
            }
        
            if ($waiterId) {
                foreach ($xml->orders->order as $order) {
                    if ($order->status == "completed" && (string)$order['waiterId'] == $waiterId) {
                        array_push($readyOrders, $order);
                    }
                }
            }
        
            if (!empty($readyOrders)) {
                echo "<h2>Valmis tellimused</h2>";
                echo "<div id='notificationArea'>";
                foreach ($readyOrders as $order) {
                    echo "<div class='notification'>";
                    echo "<p>Tellimus №" . $order['id'] . "</p>";
                    echo "<p><a href='pages/orders.php'>Vaadake tellimust</a></p>";
                    echo "</div>";
                }
                echo "</div>";
            }
        
        
        } elseif ($_SESSION['role'] == 'chef') {
            $activeOrders = [];
            foreach ($xml->orders->order as $order) {
                if ($order->status == "active") {
                    array_push($activeOrders, $order);
                }
            }
        
            if (!empty($activeOrders)) {
                echo "<h2>Aktiivsed tellimused</h2>";
                echo "<div id='notificationArea'>";
                foreach ($activeOrders as $order) {
                    echo "<div class='notification'>";
                    echo "<p>Tellimus №" . $order['id'] . "</p>";
                    echo "<p><a href='pages/orders.php'>Vaadake tellimust</a></p>";
                    echo "</div>";
                }
                echo "</div>";
            }
        } elseif ($_SESSION['role'] == 'client') {
            $clientOrders = [];
            foreach ($xml->orders->order as $order) {
                if ($order['customerUserName'] == $_SESSION['username'] && $order->status == "served") {
                    array_push($clientOrders, $order);
                }
            }
        
            if (!empty($clientOrders)) {
                echo "<h2>Teie arved</h2>";
                echo "<div id='notificationArea'>";
                foreach ($clientOrders as $order) {
                    echo "<div class='notification'>";
                    echo "<p>Tellimus №" . $order['id'] . "</p>";
                    echo "<p><a href='pages/myOrders.php'>Vaadake arvet</a></p>";
                    echo "</div>";
                }
                echo "</div>";
            }
        } 
        ?>
    </div>
</section>

<footer>
    <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
    <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var addOrderButton = document.querySelector('#quickAccess button');

        addOrderButton.addEventListener('click', function(event) {
            <?php if (empty($_SESSION['role'])): ?>
                event.preventDefault();
                window.location.href = 'pages/login.php';
            <?php endif; ?>
        });
    });
</script>


</body>
</html>
