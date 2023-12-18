<?php
session_start();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и Регистрация</title>
    <link rel="stylesheet" href="../css/loginStyle.css">
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
<div class="container">

    <form id="loginForm" action="../php/validateLogin.php" method="post">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
        <p class="switch">Вы здесь впервые? <span onclick="showRegister()">Зарегистрироваться</span></p>
        <p class="switch">Добавить работника <span onclick="showEmployeeRegister()">Регистрация сотрудника</span></p>
    </form>


    <form id="registerForm" action="../php/registerUser.php" method="post" style="display:none;">
        <input type="text" name="Name" placeholder="Полное имя" required>
        <input type="text" name="newUsername" placeholder="Новое имя пользователя" required>
        <input type="password" name="newPassword" placeholder="Новый пароль" required>
        <input type="hidden" name="role" value="client">
        <button type="submit">Зарегистрироваться</button>
    </form>


    <form id="employeeRegisterForm" action="../php/registerUser.php" method="post" style="display:none;">
        <input type="text" name="Name" placeholder="Полное имя" required>
        <input type="text" name="newUsername" placeholder="Новое имя пользователя" required>
        <input type="password" name="newPassword" placeholder="Новый пароль" required>
        <select name="role">
            <option value="waiter">Официант</option>
            <option value="chef">Повар</option>
        </select>
        <button type="submit">Зарегистрировать сотрудника</button>
    </form>
</div>


<script src="../js/loginScript.js"></script>
</body>
</html>
