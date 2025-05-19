

<?php
// Show errors (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to DB
$con = mysqli_connect("localhost", "root", "", "bookstore");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if login form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username'] ?? '');
    $password = mysqli_real_escape_string($con, $_POST['password'] ?? '');

    // Check credentials
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        // Optional: Start a session
        // session_start();
        // $_SESSION['username'] = $username;

        
        header("Location: welcome.html");
        exit(); // Important to stop the script after redirection
    } else {
        echo "❌ Invalid username or password!";
    }

    mysqli_close($con);
}
?>
