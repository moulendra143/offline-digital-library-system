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
    $selectquery = "SELECT * FROM mech WHERE code LIKE ?";
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
        <title>pdf view</title>
        <link rel="stylesheet" href="./dcmestudents,css">
</head>
<body>
<section>
        <header>
            <div class="logo">
                <img src="http://gptplpt.000webhostapp.com/website/images/index_img/collegelogo.jpeg" height="100px",width=100px>
            </div>
            <div class="name">
                <p>
                    <a class="govt"><b>Government Polytechnic,<small><sub>Pillaripattu</sub></small></b></a>
                    <a class="pillari"></a>
                   <a href="./title.html"><i class="fa fa-bars"></i></a> 
                </p>
                
            </div>
            <div class="scroll">
            <marquee>Books</marquee>
            </div>
        </header>
</section>
</body>
</html>


            

    <?php if (!empty($results)) : ?>
        <ul>
            <?php foreach ($results as $row) : ?>
                <li>
                  <table border=2>
                    <th> s.no</th>
                    <th>code</th>
                    <th>file name</th>
                    <tr>
                    <td><?php echo '1'; ?></td>
                    <td><h3><?php echo htmlspecialchars($row['code']); ?></h3></a></td>
                  <td>  <a href="./pdf/<?php echo htmlspecialchars($row['filename']); ?>"><h3><?php echo htmlspecialchars($row['filename']); ?></h3></a></td>
                    <!-- Add more fields as needed -->
                </li>
                <style>
                    table{
                        font-size: 20px;
                        margin-top: 20px;
                        margin-left: 470px;
                    }
                    table th{
                     padding:20px 20px 20px 20px;
                      color:chocolate
                    }
                    table td{
                      padding: 10px 30px 10px 10px;;
                    }
                    table a{
                        text-decoration:none; 
                    }
                    table a:hover{
                        text-decoration:underline;
                        cursor:pointer;
                        color:#ed1e79;
                    }
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No results found for "<?php echo htmlspecialchars($searchQuery); ?>"</p>
    <?php endif; ?>

</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>

