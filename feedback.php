<?php
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $sql = "INSERT INTO feedback (name, phone, message)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $phone, $message);

    if ($stmt->execute()) {
        echo "Сообщение успешно отправлено!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>