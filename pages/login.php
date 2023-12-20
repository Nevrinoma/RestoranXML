<?php
session_start();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Autoriseerimine ja registreerimine</title>
    <link rel="stylesheet" href="../css/loginStyle.css">
    <script src="../js/confirmLogout.js"></script>
    <script src="../js/loginScript.js"></script>
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
<div class="container">

    <form id="loginForm" action="../php/validateLogin.php" method="post">
        <input type="text" name="username" placeholder="Kasutajanimi" required>
        <input type="password" name="password" placeholder="Parool" required>
        <button type="submit">Logi sisse</button>
        <p class="switch">Kas te olete siin esimest korda? <span onclick="showRegister()">Registreeru</span></p>
        <p class="switch">Töötaja lisamine <span onclick="showEmployeeRegister()">Töötajate registreerimine</span></p>
    </form>


    <form id="registerForm" action="../php/registerUser.php" method="post" style="display:none;">
        <input type="text" name="Name" placeholder="Nimi ja Perekonnanimi" required>
        <input type="text" name="newUsername" placeholder="Kasutajanimi" required>
        <input type="password" name="newPassword" placeholder="Parool" required>
        <input type="hidden" name="role" value="client">
        <button type="submit">Registreeru</button>
    </form>


    <form id="employeeRegisterForm" action="../php/registerUser.php" method="post" style="display:none;">
        <input type="text" name="Name" placeholder="Nimi ja Perekonnanimi" required>
        <input type="text" name="newUsername" placeholder="Kasutajanimi" required>
        <input type="password" name="newPassword" placeholder="Parool" required>
        <select name="role">
            <option value="waiter">Teenindaja</option>
            <option value="chef">Kokk</option>
        </select>
        <button type="submit">Registreeru</button>
    </form>
</div>

<footer>
    <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
    <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
</footer>

</body>
</html>
