<?php
$conn = mysqli_connect('localhost', 'root', '', 'library');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = mysqli_real_escape_string($conn, $_POST['email']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

$sql = "INSERT INTO feedback (email, name, feedback) VALUES ('$email', '$name', '$feedback')";

if (mysqli_query($conn, $sql)) {
    echo "<script>
    alert('Feedback sent successfully');
    window.location.href = 'contact.html';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>