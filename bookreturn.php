
<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}

include 'connection.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['student_name'])) {
  $title = trim($_POST['title']);
  $student_name = trim($_POST['student_name']);

  if ($title !== "" && $student_name !== "") {
    $stmt = $con->prepare("DELETE FROM borrowed_books WHERE title = ? AND student_name = ?");
    $stmt->bind_param("ss", $title, $student_name);

    if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
        $message = "✅ Book successfully returned.";
      } else {
        $message = "⚠️ No matching record found.";
      }
    } else {
      $message = "❌ Query error: " . $stmt->error;
    }

    $stmt->close();
  } else {
    $message = "⚠️ Please fill in all fields.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Return Book</title>
</head>
<body>

<h2>Return a Borrowed Book</h2>

<?php if ($message): ?>
  <p><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST" action="">
  <label for="title">Book Title:</label><br>
  <input type="text" name="title" id="title" required><br><br>

  <label for="student_name">Student Name:</label><br>
  <input type="text" name="student_name" id="student_name" required><br><br>

  <button type="submit">Return Book</button>
</form>

</body>
</html>
