<?php
// Establish a database connection (you need to fill in the appropriate details)
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "library"; 

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve PDF data from the database
$selectquery = "SELECT id, code, filename FROM generalbooks"; // Include 'code' column in the query
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
            <marquee>Dcme branch</marquee>
            </div>
        </header>
          <!-- Add the search bar form -->
          <div class="search-bar" style="padding-left:1200px">
            <form method="" action="pdfgeneralbook.php"> <!-- Create a PHP file 'search.php' to handle the search -->
                <input type="text" name="query" placeholder="Search using sub code">
                <input type="submit" value="Search">
            </form>
        </div>

        <table border="2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject Code</th>
                    <th>File Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $i++;
                    $code = $row['code']; // Retrieve 'code' from the database
                    $filename = $row['filename'];
                    $pdfPath = "./pdf/$filename";
                 
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $code; ?></td>
                        <td><?php echo $filename; ?></td>
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
