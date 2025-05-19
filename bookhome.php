<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Bookstore - Home</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    header {
      background: #004080;
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
    }

    nav a {
      color: white;
      margin-left: 1rem;
      text-decoration: none;
    }

    .hero {
      text-align: center;
      background: #e0f0ff;
      padding: 2rem;
    }

    .book-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1.5rem;
      padding: 2rem;
    }

    .book-card {
      background: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 1rem;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .book-card form {
      margin-top: 1rem;
    }

    .book-card input[type="text"] {
      padding: 0.4rem;
      margin-bottom: 0.5rem;
      width: 90%;
    }

    .book-card button {
      background: #004080;
      color: white;
      border: none;
      padding: 0.4rem 0.8rem;
      cursor: pointer;
      border-radius: 4px;
    }

    .message {
      text-align: center;
      color: green;
      font-weight: bold;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">Student Bookstore</div>
  <nav>
    <a href="homebook.php">Home</a>
    <a href="#">Borrow Book</a>
    <a href="#">Contact</a>
    <a href="#">Logout</a>
  </nav>
</header>

<section class="hero">
  <h1>Welcome to the Student Bookstore</h1>
  <p>Find and borrow books for your studies easily.</p>
</section>

<?php
if (isset($_GET['borrow']) && $_GET['borrow'] === 'success') {
  echo '<div class="message">Book borrowed successfully!</div>';
}
?>

<section class="book-grid">
<?php
$result = $con->query("SELECT * FROM books");

while ($row = $result->fetch_assoc()):
?>
  <div class="book-card">
    <h3><?= htmlspecialchars($row['title']) ?></h3>
    <p><?= htmlspecialchars($row['author']) ?></p>
    <form method="POST" action="borrow.php">
      <input type="hidden" name="title" value="<?= htmlspecialchars($row['title']) ?>">
      <input type="text" name="student_name" placeholder="Your name" required>
      <button type="submit">Borrow</button>
    </form>
  </div>
<?php endwhile; ?>
</section>

</body>
</html>
