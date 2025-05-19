<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
?>

<?php
include 'connection.php'; // Make sure this file exists and is in the same folder

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $author = trim($_POST['author']);
  $category = trim($_POST['category']);
  $available = isset($_POST['available']) ? 1 : 0;
  $cover_image = '';

  // Handle image upload
  if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
    $filename = basename($_FILES['cover_image']['name']);
    $target = 'uploads/' . $filename;

    // Create uploads folder if it doesn't exist
    if (!file_exists('uploads')) {
      mkdir('uploads', 0777, true);
    }

    move_uploaded_file($_FILES['cover_image']['tmp_name'], $target);
    $cover_image = $target;
  }

  // Insert into books table
  $stmt = $con->prepare("INSERT INTO books (title, author, category, cover_image, available) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssi", $title, $author, $category, $cover_image, $available);

  if ($stmt->execute()) {
    $message = "✅ Book added successfully!";
  } else {
    $message = "❌ Error: Book with this title already exists.";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Book</title>
</head>
<body>
  <h2>Add New Book</h2>
  <p><?= $message ?></p>

  <form method="POST" enctype="multipart/form-data">
    <label>Title :</label><br>
    <input type="text" name="title" required><br><br>

    <label>Author:</label><br>
    <input type="text" name="author" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="category"><br><br>

    <label>Cover Image:</label><br>
    <input type="file" name="cover_image" accept="image/*" required><br><br>

    <label><input type="checkbox" name="available" checked> Available</label><br><br>

    <button type="submit">Add Book</button>
  </form>
</body>
</html>

