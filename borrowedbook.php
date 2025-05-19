<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Borrow a Book</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      padding: 2rem;
    }

    .form-container {
      max-width: 400px;
      background: white;
      padding: 2rem;
      border-radius: 8px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #004080;
    }

    label {
      display: block;
      margin-top: 1rem;
    }

    input, select, button {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.5rem;
      font-size: 1rem;
    }

    button {
      background-color: #004080;
      color: white;
      border: none;
      border-radius: 4px;
      margin-top: 1.5rem;
      cursor: pointer;
    }

    button:hover {
      background-color: #003060;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Borrow a Book</h2>

    <form action="borrow.php" method="post">
      <label for="student_name">Your Name:</label>
      <input type="text" name="student_name" required>

      <label for="title">Select Book:</label>
      <select name="title" required>
        <option value="">-- Choose a book --</option>
        <?php
          $result = $con->query("SELECT title FROM books");
          while ($row = $result->fetch_assoc()) {
            echo "<option value=\"" . htmlspecialchars($row['title']) . "\">" . htmlspecialchars($row['title']) . "</option>";
          }
        ?>
      </select>

      <button type="submit">Borrow</button>
    </form>
  </div>

</body>
</html>
