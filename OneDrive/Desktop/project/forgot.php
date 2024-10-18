<?php
// Your database connection code here
$conn = mysqli_connect('localhost', 'root', '', 'library');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Check if the email exists in the database
    $checkemailQuery = "SELECT * FROM admin WHERE email = '$email'";
    $result = mysqli_query($conn, $checkemailQuery);

    if ($result && mysqli_num_rows($result) == 1) {
        // Generate a unique token and insert it into the database
        $token = bin2hex(random_bytes(16)); // Generate a random token
        $insertTokenQuery = "UPDATE admin SET reset_token = '$token' WHERE email = '$email'";
        mysqli_query($conn, $insertTokenQuery);

        // Send a reset link to the user's email
        $resetLink = "https://yourwebsite.com/reset_password.php?token=$token";
        $to = $email;
        $subject = "Password Reset";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = "From: moulendramoulireddy@gmail.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "Password reset link has been sent to your email.";
        } else {
            echo "Error sending the password reset link.";
        }
    } else {
        echo "Email not found.";
    }
}

// Close the database connection
mysqli_close($conn);
?>