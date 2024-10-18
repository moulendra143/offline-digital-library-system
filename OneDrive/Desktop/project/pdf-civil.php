<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = $_POST['subject'];
    $author = $_POST['author'];
    $code = $_POST['code'];
    $publisher = $_POST['publisher'];

    // Check if a file was uploaded
    if (isset($_FILES['pdf_file']['name'])) {
        $file_name = $_FILES['pdf_file']['name'];
        $file_tmp = $_FILES['pdf_file']['tmp_name'];

        // Check if the uploaded file is a PDF
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        if (strtolower($file_extension) == 'pdf') {
            // Move the uploaded file to a directory (create the directory if it doesn't exist)
            $upload_dir = "./pdf/"; // Change this to your desired directory
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            move_uploaded_file($file_tmp, $upload_dir . $file_name);

            // Insert data into the database using prepared statements to prevent SQL injection
            $insertquery = "INSERT INTO civil(subject, filename, author, code, publisher) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insertquery);
            mysqli_stmt_bind_param($stmt, "sssss", $name, $file_name, $author, $code, $publisher);

            if (mysqli_stmt_execute($stmt)) {
                echo "File uploaded and data inserted successfully.";
                header("location:view-ece.php");
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "File must be uploaded in PDF format!";
        }
    } else {
        echo "No file selected for upload.";
    }
}

mysqli_close($con);
?>

