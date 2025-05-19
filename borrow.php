<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $student_name = $_POST['student_name'];

    $stmt = $con->prepare("INSERT INTO borrowed_books (title, student_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $student_name);

    if ($stmt->execute()) {
        header("Location: homebook.php?borrow=success");
        exit();
    } else {
        echo "Error borrowing book: " . $stmt->error;
    }
}
?>
