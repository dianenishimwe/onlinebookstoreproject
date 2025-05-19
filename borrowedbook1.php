<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Borrowed Books</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      padding: 2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 1rem;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #004080;
      color: white;
    }

    form {
      display: inline;
    }

    button {
      background-color: #c0392b;
      color: white;
      border: none;
      padding: 0.4rem 0.8rem;
      cursor: pointer;
      border-radius: 4px;
    }

    button:hover {
      background-color: #a93226;
    }
  </style>
</head>
<body>

  <h2>Borrowed Books</h2>

  <table>
    <tr>
      <th>Title</th>
      <th>Student</th>
      <th>Borrowed At</th>
      <th>Action</th>
    </tr>

    <?php
      $result = $con->query("SELECT * FROM borrowed_books");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['borrow_date']) . "</td>";
        echo "<td>
                <form method='post' action='returnbook.php'>
                  <input type='hidden' name='title' value='" . htmlspecialchars($row['title']) . "'>
                  <input type='hidden' name='student_name' value='" . htmlspecialchars($row['student_name']) . "'>
                  <button type='submit'>Return</button>
                </form>
              </td>";
        echo "</tr>";
      }
    ?>
  </table>

</body>
</html>
