<?php
session_start();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Töötajate Haldamine</title> 
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/staffScript.js" defer></script>
    <script src="../js/confirmLogout.js"></script>
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
        <h1>Töötajate Haldamine</h1> 
        <table id="staffTable">
            <thead>
                <tr>
                    <th>Nimi</th> 
                    <th>Kasutajanimi</th> 
                    <th>Parool</th> 
                    <th>Roll</th> 
                    <th>Tegevused</th> 
                </tr>
            </thead>
            <tbody>
                <?php include '../php/loadStuff.php'; ?>
            </tbody>
        </table>
        
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="editForm">
                    <label for="editUsername">Kasutajanimi:</label> 
                    <input type="text" id="editUsername" name="username"><br><br>
                    <label for="editName">Nimi:</label> 
                    <input type="text" id="editName" name="name"><br><br>
                    <label for="editPassword">Parool:</label> 
                    <input type="password" id="editPassword" name="password"><br><br>
                    <label for="editRole">Roll:</label> 
                    <input type="text" id="editRole" name="role"><br><br>
                    <input type="submit" value="Salvesta muudatused"> 
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>© 2023 Taste of Pain. Kõik õigused kaitstud.</p>
        <p>Kontakt: <a href="mailto:contact@yourrestaurant.com">giuliano.lember@tasteofpain.com</a></p>
    </footer>
</body>
</html>
