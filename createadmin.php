<?php
include 'connection.php';

$firstname = 'Admin';
$lastname = 'User';
$email = 'admin@example.com';
$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT); // securely hash the password

$stmt = $con->prepare("INSERT INTO admin (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $firstname, $lastname, $email, $username, $password);

if ($stmt->execute()) {
  echo "Admin created successfully.";
} else {
  echo "Error: " . $stmt->error;
}
?>
