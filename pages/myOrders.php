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
            echo "<h3>Tellimus №" . $order['id'] . ", Klient: " . getCustomerName($order['customerUserName'], $usersXml) . "</h3>";
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

function displayOrdersWithDetails($restaurantXml, $usersXml, $status) {
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
            echo "<h3>Tellimus №" . $order['id'] . ", Klient: " . getCustomerName($order['customerUserName'], $usersXml) . "</h3>";
            echo "<p>Laud: " . $order['tableId'] . ", Teenindaja: " . ($userName ? $userName : "Teadmata") . "</p>";
            echo "<h4>Tellimusel olevad toidud:</h4>";
            $totalPrice = 0;
            echo "<ul>";
            foreach ($order->orderItems->item as $item) {
                $dish = $restaurantXml->menu->xpath("//dish[@id='" . $item['dishId'] . "']")[0];
                echo "<li>" . $dish->name . " x" . $item['quantity'] . " - " . $dish->price . "€ </li>";
                $totalPrice += (float)$dish->price * (int)$item['quantity'];
            }
            echo "</ul>";
            echo "<p>Kokku: " . $totalPrice . "€</p>";

            echo "</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minu tellimused</title>
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
    <h2>Aktiivne tellimus</h2>
    <?php displayOrders($restaurantXml, $usersXml, "active"); ?>
</div>

<div class="completed-orders">
    <h2>Eelmised tellimused</h2>
    <?php displayOrdersWithDetails($restaurantXml, $usersXml, "served"); ?>
</div>

<footer>
        <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
        <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
</footer>
</body>
</html>



