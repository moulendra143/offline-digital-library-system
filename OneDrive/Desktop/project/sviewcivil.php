<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "library"; 

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve PDF data from the database
$selectquery = "SELECT id, subject, code, filename, publisher FROM civil"; // Include all the necessary columns in the query
$result = mysqli_query($con, $selectquery);

if (!$result) {
    die("Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dcme</title>
    <link rel="stylesheet" href="./viewpdf.css">
</head>
<body>
    <section>
        <header>
            <div class="logo">
                <img src="http://gptplpt.000webhostapp.com/website/images/index_img/collegelogo.jpeg" height="100px" width="100px">
            </div>
            <div class="name">
                <p>
                    <a class="govt"><b>Government Polytechnic,<small><sub>Pillaripattu</sub></small></b></a>
                    <a class="pillari"></a>
                   <a href="./title.html"><i class="fa fa-bars"></i></a> 
                </p>
            </div>
            <div class="scroll">
                <marquee>civil branch</marquee>
            </div>
        </header>
        <!-- Add the search bar form -->
        <div class="search-bar" style="padding-left:1200px">
            <form method="GET" action="civilsearch.php">
                <input type="text" name="query" placeholder="Search using subject name">
                <input type="submit" value="Search">
            </form>
        </div>

        <table border="2">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>File Name</th>
                    <th>Publisher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $i++;
                    $subject = $row['subject'];
                    $code = $row['code'];
                    $filename = $row['filename'];
                    $publisher = $row['publisher'];
                    $pdfPath = "./pdf/$filename";
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $subject; ?></td>
                        <td><?php echo $code; ?></td>
                        <td><?php echo $filename; ?></td>
                        <td><?php echo $publisher; ?></td>
                        <td><a href="<?php echo $pdfPath; ?>" target="_blank">View PDF</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
