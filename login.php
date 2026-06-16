<?php
session_start();
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Вход в админку</title>
<link rel="stylesheet" href="style.css">

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

header {
    position: relative;
    width: 90%;
    max-width: 1440px;
    top: 0px;
}

/* карточка */
.login-box {
    background: #111827;
    padding: 40px;
    border-radius: 14px;
    width: 500px;
    box-shadow: 0 20px 40px rgba(67, 67, 67, 0.4);
    text-align: center;
}

/* заголовок */
.login-box h2 {
    margin-bottom: 20px;
    color: #e5e7eb;
}

/* поля */
.login-box input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    background: #1f2937;
    color: white;
    outline: none;
}

/* кнопка */
.login-box button {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    background: #3b82f6;
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    font-weight: bold;
}

.login-box button:hover {
    background: #2563eb;
}

/* ошибка */
.error {
    color: #ef4444;
    margin-top: 10px;
    font-size: 14px;
}
</style>

</head>

<body>

 <header class="header">
        <div class="container">
            <div class="logo">
                Бизнес-развитие
            </div>

            <nav>
                <a href="index.html">Главная</a>
                <a href="about.html">О компании</a>
                <a href="services.html">Услуги</a>
                <a href="cases.html">Кейсы</a>
                <a href="#advantages">Преимущества</a>
                <a href="#contacts">Контакты</a>
                <a href="admin.php">Админка</a>
            </nav>

            <div class="tel">
                <a href="tel:+73832172946">+7 (383) 217-29-46</a>
                <a href="tel:+79137286608">+7 (913) 728-66-08</a>
                <a href="tel:+79231116988">+7 (923) 111-69-88</a>
            </div>
        </div>
    </header>

<div class="login-box">

    <h2>Администрирование</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

</div>

</body>
</html>