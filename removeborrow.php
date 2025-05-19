<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}

$result = $con->query("SELECT * FROM borrowed_books ORDER BY borrow_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Borrowed Books</title>
</head>
<body>
  <h2>Borrowed Books</h2>

  <table border="1">
    <tr>
      <th>Title</th>
      <th>Student Name</th>
      <th>Borrow Date</th>
      <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['title']) ?></td>
      <td><?= htmlspecialchars($row['student_name']) ?></td>
      <td><?= htmlspecialchars($row['borrow_date']) ?></td>
      <td>
        <form action="bookreturn.php" method="POST" onsubmit="return confirm('Return this book?');">
          <input type="hidden" name="title" value="<?= htmlspecialchars($row['title']) ?>">
          <input type="hidden" name="student_name" value="<?= htmlspecialchars($row['student_name']) ?>">
          <button type="submit">Return</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
