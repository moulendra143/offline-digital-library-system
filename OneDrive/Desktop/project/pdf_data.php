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
            if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                // Insert data into the database using prepared statements to prevent SQL injection
                $insertquery = "INSERT INTO pdf_data (subject, filename, author, publisher) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $insertquery);
                
                if ($stmt) { // Check if the statement was prepared successfully
                    mysqli_stmt_bind_param($stmt, "ssss", $name, $file_name, $author, $publisher);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "File uploaded and data inserted successfully.";
                        header("location:viewpdf.php");
                        exit; // Terminate the script after redirection
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                    
                    // Close the prepared statement
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error preparing the SQL statement: " . mysqli_error($con);
                }
            } else {
                echo "Error moving the uploaded file to the directory.";
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
