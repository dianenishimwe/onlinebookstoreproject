
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Book</title>
</head>
<body>
  <h2>Add Book</h2>
  <form action="addbook.php" method="post">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>
    <label>Author:</label><br>
    <input type="text" name="author" required><br><br>
    <label>Category:</label><br>
    <input type="text" name="category" required><br><br>
    <button type="submit">Add Book</button>
  </form>
</body>
</html>

<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Borrowed Books</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
      background: #f4f4f4;
    }

    h2 {
      color: #004080;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      margin-top: 1rem;
    }

    th, td {
      padding: 0.75rem;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #004080;
      color: white;
    }

    button {
      background-color: #d9534f;
      color: white;
      border: none;
      padding: 6px 10px;
      cursor: pointer;
      border-radius: 4px;
    }

    button:hover {
      background-color: #c9302c;
    }
  </style>
</head>
<body>

  <h2>Borrowed Books</h2>

  <table>
    <tr>
      <th>Title</th>
      <th>Student Name</th>
      <th>Borrow Date</th>
      
    </tr>
    <?php
      $result = $con->query("SELECT * FROM borrowed_books ORDER BY borrow_date DESC");
      while ($row = $result->fetch_assoc()):
    ?>
    <tr>
      <td><?= htmlspecialchars($row['title']) ?></td>
      <td><?= htmlspecialchars($row['student_name']) ?></td>
      <td><?= htmlspecialchars($row['borrow_date']) ?></td>
      

      <td>
        <form action="bookreturn.php" method="POST" onsubmit="return confirm('Return this book?');">
          <input type="hidden" name="title" value="<?= htmlspecialchars($row['title']) ?>">
          <input type="hidden" name="student_name" value="<?= htmlspecialchars($row['student_name']) ?>">

        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>
<?php
// Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
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
  <h2>RETURNING BOOK</h2>

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
<?php

// Safe session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
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



