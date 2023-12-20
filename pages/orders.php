<?php
session_start();

$restaurantXml = simplexml_load_file("../Data/Restaurant.xml");
$usersXml = simplexml_load_file("../Data/Users.xml");

function getWaiterName($waiterId, $usersXml) {
    foreach ($usersXml->user as $user) {
        if ($user->id == $waiterId && $user->role == 'waiter') {
            return $user->name;
        }
    }
    return "Teadmata";
}

function getCustomerName($customerUserName, $usersXml) {
    foreach ($usersXml->user as $user) {
        if ((string)$user->username == $customerUserName) {
            return (string)$user->name; 
        }
    }
    return "Teadmata";
}

function displayOrders($restaurantXml, $usersXml, $status) {
    foreach ($restaurantXml->orders->order as $order) {
        if ($order->status == $status) {
            $waiterId = (string)$order['waiterId'];
            $waiterName = "";
            
            foreach ($restaurantXml->staff->employee as $employee) {
                if ($employee['id'] == $waiterId && $employee['role'] == 'waiter') {
                    $waiterName = (string)$employee->name;
                    break;
                }
            }
            $userName = "";
            foreach ($usersXml->user as $user) {
                if ($user->name == $waiterName) {
                    $userName = $waiterName;
                    break;
                }
            }
            echo "<div class='order'>";
            echo "<h3>Tellimine №" . $order['id'] . ", Klient: " . getCustomerName($order['customerUserName'], $usersXml) . "</h3>";
            echo "<p>Laud: " . $order['tableId'] . ", Teenindaja: " . ($userName ? $userName : "Teadmata") . "</p>";
            echo "<p>Staatus: " . $order->status . "</p>";
            
            echo "<h4>Tellimusel olevad toidud:</h4>";
            foreach ($order->orderItems->item as $item) {
                $dish = $restaurantXml->menu->xpath("//dish[@id='" . $item['dishId'] . "']")[0];
                echo "<p>" . $dish->name . " x" . $item['quantity'] . "</p>";
            }

            echo "<h4>Klientide eelistused:</h4>";
            foreach ($order->customerPreferences->preference as $preference) {
                echo "<p>" . $preference['dish']. ": " . $preference['description'] . "</p>";
            }

            
            echo "</div>";
        }
    }
}

function updateOrderStatus($restaurantXml, $orderId, $newStatus) {
    foreach ($restaurantXml->orders->order as $order) {
        if ($order['id'] == $orderId) {
            $order->status = $newStatus;
            if ($newStatus == 'served') {
                $tableId = (string)$order['tableId'];
                foreach ($restaurantXml->tables->table as $table) {
                    if ($table['id'] == $tableId) {
                        $table['occupied'] = 'false'; 
                        break;
                    }
                }
            }

            break;
        }
    }
    $restaurantXml->asXML("../Data/Restaurant.xml");
}


if (isset($_POST['update_status'])) {
    updateOrderStatus($restaurantXml, $_POST['order_id'], $_POST['status']);
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tellimused</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/confirmLogout.js"></script>
</head>
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
<div class="active-orders">
    <h2>Aktiivsed tellimused</h2>
    <?php displayOrders($restaurantXml, $usersXml, "active"); ?>
</div>

<div class="completed-orders">
    <h2>Tehtud tellimused</h2>
    <?php displayOrders($restaurantXml, $usersXml,  "completed"); ?>
</div>

<div class="completed-orders">
    <h2>Lõpetatud tellimused</h2>
    <?php displayOrders($restaurantXml, $usersXml, "served"); ?>
</div>

<div class="add-dish-form">
    <h2>Tellimuse staatuse muutmine</h2>
    <form method="post" action="">
        <select name="order_id">
            <?php foreach ($restaurantXml->orders->order as $order): ?>
                <option value="<?= $order['id'] ?>">Tellimus №<?= $order['id'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="status">
            <option value="active">Toiduvalmistamine</option>
            <option value="completed">Valmis</option>
            <option value="served">Teenindatakse kliendile</option>
        </select>
        <input type="submit" name="update_status" value="Staatuse ajakohastamine">
    </form>
</div>

<footer>
        <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
        <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
</footer>
</body>
</html>