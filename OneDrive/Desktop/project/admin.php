<?php
// Start the session
session_start();

// Database connection parameters
$servername = "localhost"; // Corrected the servername
$username = "root";
$password = "";
$dbname = "library";

// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Store a session variable to indicate successful login
        $_SESSION["loggedin"] = true;

        // Redirect to the desired page after successful login
        header("Location: home.html");
        exit;
    } else {
        $loginError = "Invalid username or password";
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

