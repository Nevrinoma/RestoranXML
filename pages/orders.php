<?php
session_start();
$xml = simplexml_load_file("../Data/Restaurant.xml");

function displayOrders($xml, $status) {
    foreach ($xml->orders->order as $order) {
        if ($order->status == $status) {
            echo "<div class='order'>";
            echo "<h3>Заказ №" . $order['id'] . "</h3>";
            echo "<p>Столик: " . $order['tableId'] . ", Официант: " . $order['waiterId'] . "</p>";
            echo "<p>Статус: " . $order->status . "</p>";
            
            echo "<h4>Блюда в заказе:</h4>";
            foreach ($order->orderItems->item as $item) {
                $dish = $xml->menu->xpath("//dish[@id='" . $item['dishId'] . "']")[0];
                echo "<p>" . $dish->name . " x" . $item['quantity'] . "</p>";
            }

            echo "<h4>Предпочтения клиента:</h4>";
            foreach ($order->customerPreferences->preference as $preference) {
                echo "<p>" . $preference['type'] . ": " . $preference['description'] . "</p>";
            }

            
            echo "</div>";
        }
    }
}

function displayChefs($xml) {
    echo "<select name='chef'>";
    foreach ($xml->staff->employee as $employee) {
        if ($employee['role'] == 'chef') {
            echo "<option value='" . $employee['id'] . "'>" . $employee->name . "</option>";
        }
    }
    echo "</select>";
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menüü - Teie Restoran</title>
    <link rel="stylesheet" href="../css/styles.css">
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

<div class="active-orders">
    <h2>Активные заказы</h2>
    <?php displayOrders($xml, "active"); ?>
</div>

<div class="completed-orders">
    <h2>Выполненные заказы</h2>
    <?php displayOrders($xml, "completed"); ?>
</div>

<div class="assign-chef">
    <h2>Назначить повара</h2>
    <form method="post" action="assign_chef.php">
        <?php displayChefs($xml); ?>
        <input type="submit" value="Назначить">
    </form>
</div>



</body>
</html>
