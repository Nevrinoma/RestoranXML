<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Töötajate Haldamine</title> 
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/staffScript.js" defer></script>
</head>
<body>
    <header>
    <nav>
        <a href="../index.html"><img src="../Images/logo.png" alt="Logo"></a>
        <ul>
            <li><a href="menu.php">Menüü</a></li>
            <li><a href="orders.php">Tellimused</a></li>
            <li><a href="tables.php">Lauad</a></li>
            <li><a href="staff.php">Personal</a></li>
        </ul>
        <a href="login.php" id="loginButton">Logi sisse</a>
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
</body>
</html>
