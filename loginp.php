

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
		.log{
			background-image: url(ict.jpg);
			background-size: cover;
			background-position: center;
			border: 10px grey;
			border-radius: 10px;
			margin-top: -1.8rem;
			height:398px;
			margin-right: -2px;
			width: 307px;
			margin-left: -17px;

		}
		.reg{
			background-image: url(ict.jpg);
				background-size: cover;
				background-position: center;
				border: 10px grey;
			border-radius: 10px;
			margin-top: -1.8rem;
			height:398px;
			margin-right: -17px;

		}
		.input{
		
			border: 10px solid silver;
			margin-left: 10px;
			margin-right: 10px;
			margin-bottom: 25px;
		
		}
		.input2{
		
			border: 10px solid silver;
			margin-left: 10px;
			margin-right: 10px;
			margin-bottom: 20px;
		
		}

		td{
			vertical-align: top;
			margin-top: 2rem;

		}
		
		.form-box{
		margin: auto;
		}
		.table{
			border-top: 15px solid grey;
			border-left: 15px solid grey;
	
			border-width: 15px;
			width: 658px;
			height: 423px;
			margin-top: 3rem;

		}
		body{
			margin: 0;
		}


	</style>
</head>
<body>
	<center>
		<div class="table">
<table>
	<tr>
		<td>
<pre>
	<div class="log">
		<div class="form-box">
<form action="login.php" method="post">
<h1>  User please login!!</h1>
<hr style="margin-left: 5px; margin-right: 5px;">
<div class="input">
 User-Name:<input type="text" name="username">

  Password:<input type="password" name="password">

    <button type="submit">Login</button>     <button type="cancel">Cancel</button>
  </div>
			</form></div></div></pre>
		</td>
        <?php
session_start();
include 'connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $con->prepare("SELECT * FROM admin WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_username'] = $admin['username'];
      header("Location: borrowed.php");
      exit;
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "Admin not found.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
</head>
<body bgcolor="grey">
  <h2>Admin Login</h2>
  <form method="post">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
  </form>
  <p style="color: red;"><?php echo $error; ?></p>
</body>
</html>

		<td>
			<pre>
				<div class="reg">
					<div class="form-box">
<form id="reg" style="color: black;" action="signup.php" method="POST">
<h1 style="margin-top: -1rem; ">please dear fill this form!!</h1>
<hr style="margin-left: 5px; margin-right: 5px;">
<div class="input2">
 FIRST-NAME: <input type="text" name="first" required>
  LAST-NAME: <input type="text" name="last" required>
  TELEPHONE: <input type="text" name="tel" required>
  department:<input type="text" name="depa" required>
  USER-NAME: <input type="text" name="user" required>
   PASSWORD: <input type="password" name="pass" required>

      <button type="submit">Signup</a></button>               <button type="cancel">Cancel</button>
			</div></form></div></div></pre>
		</td>
	</tr>
</table></div></center>
</body>
</html>




