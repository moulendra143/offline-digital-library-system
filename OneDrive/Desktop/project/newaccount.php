<?php
$conn=mysqli_connect('localhost','root','','library');
if(!$conn){
  die("connection failed".mysqli_connect());
}
$username = $_POST["username"];
$email = $_POST['email'];
$password = $_POST['password'];
$clgname = $_POST['clgname'];

$sql = "INSERT INTO student(username, email, password, clgname) VALUES ('$username', '$email', '$password','$clgname')";
if (mysqli_query($conn, $sql)) {
    echo "<script>
    alert('account created');
    </script>";
} 
else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
header("location:student.html");
mysqli_close($conn);
?>