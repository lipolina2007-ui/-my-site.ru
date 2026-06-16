<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once 'connect.php';

// удаление
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM feedback WHERE id=$id");
    header("Location: admin.php");
    exit;
}

// поиск
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM feedback 
            WHERE name LIKE ? OR phone LIKE ? OR message LIKE ?
            ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM feedback ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Админ-панель</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #0f172a;
    color: #e5e7eb;
}

/* верхняя панель */
.topbar {
    background: #111827;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 18px;
    font-weight: bold;
}

.logout {
    color: #fff;
    text-decoration: none;
    background: #ef4444;
    padding: 8px 12px;
    border-radius: 6px;
}

/* контейнер */
.container {
    max-width: 1100px;
    margin: 30px auto;
    padding: 0 15px;
}

/* карточка */
.card {
    background: #111827;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

/* поиск */
input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    outline: none;
    margin-bottom: 10px;
}

/* таблица */
table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 10px;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #1f2937;
    text-align: left;
}

th {
    background: #1f2937;
    color: #93c5fd;
}

tr:hover {
    background: #1e293b;
}

/* кнопка удаления */
.delete {
    background: #ef4444;
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
}
</style>

</head>

<body>

<div class="topbar">
    <div class="logo">Админ-панель заявок</div>
    <a class="logout" href="logout.php">Выйти</a>
</div>

<div class="container">

<div class="card">

    <form method="GET">
        <input type="text" name="search" placeholder="Поиск по заявкам..." value="<?= htmlspecialchars($search) ?>">
    </form>

</div>

<div class="card">

<table>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Телефон</th>
        <th>Сообщение</th>
        <th>Дата</th>
        <th></th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['message']) ?></td>
        <td><?= $row['created_at'] ?></td>
        <td>
            <a class="delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Удалить заявку?')">
                Удалить
            </a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>