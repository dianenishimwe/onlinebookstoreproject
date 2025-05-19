
<?php
       // Create connection
$con=mysqli_connect("localhost","root","","bookstore");
       // Check connection
if ($con)
{ 
    echo"connection well";
}


// escape variables for security
$firstname = mysqli_real_escape_string($con, $_POST['first']);
$lastname = mysqli_real_escape_string($con, $_POST['last']);
$telephone = mysqli_real_escape_string($con, $_POST['tel']);
$department = mysqli_real_escape_string($con, $_POST['depa']);
$username = mysqli_real_escape_string($con, $_POST['user']);
$password = mysqli_real_escape_string($con, $_POST['pass']);


      $sql="INSERT INTO users (firstname, lastname, telephone,department,username,password)
      VALUES ('$firstname', '$lastname', '$telephone','$department','$username','$password')";
if (!mysqli_query($con,$sql)) {
       die('Error: ' . mysqli_error($con));
}
       echo "1 record added";mysqli_close($con);?>
