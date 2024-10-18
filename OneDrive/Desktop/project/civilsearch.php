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

// Initialize variables
$searchQuery = "";
$results = [];

// Check if the form was submitted
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Perform a database query based on the search query
    // Modify the query according to your database structure and search criteria
    $selectquery = "SELECT * FROM civil WHERE subject LIKE ?";
    $stmt = mysqli_prepare($con, $selectquery);
    $searchParam = "%" . $searchQuery . "%";
    mysqli_stmt_bind_param($stmt, "s", $searchParam);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch results for later use
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }
}
?>

<html>
    <head>
        <title>PDF View</title>
        <link rel="stylesheet" href="./dcmestudents,css">
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
                    <marquee>Admin Page</marquee>
                </div>
            </header>
        </section>
        <?php if (!empty($results)) : ?>
            <table border="2">
                <thead>
                    <th>S.No</th>
                    <th>Code</th>
                    <th>File Name</th>
                </thead>
                <tbody>
                    <?php foreach ($results as $i => $row) : ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['code']); ?></td>
                            <td><a href="./pdf/<?php echo htmlspecialchars($row['filename']); ?>"><?php echo htmlspecialchars($row['filename']); ?></a></td>
                            <!-- Add more fields as needed -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No results found for "<?php echo htmlspecialchars($searchQuery); ?>"</p>
        <?php endif; ?>
    </body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
