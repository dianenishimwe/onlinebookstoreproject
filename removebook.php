<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}

include 'connection.php'; // Database connection
$message = "";

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
  $title = trim($_POST['title']);

  // Delete the book
  $stmt = $con->prepare("DELETE FROM books WHERE title = ?");
  $stmt->bind_param("s", $title);

  if ($stmt->execute()) {
    $message = "✅ Book '$title' has been removed.";
  } else {
    $message = "❌ Error removing book.";
  }

  $stmt->close();
}

// Fetch all book titles
$result = $con->query("SELECT title FROM books");
$titles = [];
while ($row = $result->fetch_assoc()) {
  $titles[] = $row['title'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Remove Book</title>
</head>
<body>
  <h2>Remove Book</h2>
  <p><?= $message ?></p>

  <form method="POST">
    <label>Select a Book to Remove:</label><br>
    <select name="title" required>
      <option value="">--Select--</option>
      <?php foreach ($titles as $t): ?>
        <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <button type="submit" onclick="return confirm('Are you sure you want to delete this book?');">Remove Book</button>
  </form>
</body>
</html>
