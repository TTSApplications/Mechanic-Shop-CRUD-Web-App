<?php

include 'config.php';






// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$carID = "";
$customerID = "";
$make = "";
$model = "";
$year = "";
$vin = "";
$engine = "";
$orderID = "";
$carNote = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the client data

    // If Vehicle ID exists, then redirect to that user
    if (!isset($_GET["orderID"])) {
        header("location: /ordersindex.php");
        exit;
    }
    if (!isset($_GET["customerID"])) {
        header("location: /customerindex.php");
        exit;
    }
    if (!isset($_GET["carID"])) {
        header("location: /customerindex.php");
        exit;
    }

    // Read data of client from the database
    $customerID = $_GET["customerID"];
    $orderID = $_GET["orderID"];
    $carID = $_GET["carID"];

    // This is the code to load the Order Information

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM order_table WHERE orderID=$orderID";
    $orderResult = $connection->query($sql);
    $orderRow = $orderResult->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$orderRow) {
        header("location: /carview.php?customerID=$customerID");
        exit;
    } else {

        // Store the data from the database into these variables
        $orderID = $orderRow["orderID"];
        $carID = $orderRow["carID"];
        $title = $orderRow["title"];
        $description = $orderRow["description"];
        $status = $orderRow["status"];
        $dateCreated = $orderRow["dateCreated"];
        $dateBegun = $orderRow["dateBegun"];
        $dateCompleted = $orderRow["dateCompleted"];
        $parts = $orderRow["parts"];

        $orderFirstAssoc = 1;

    }

    // Notes

    $person = "";
    $note = "";

    // Read the row of the selected order from the database table
    $sql = "SELECT * FROM note_table WHERE orderID=$orderID ORDER BY date DESC";
    $noteResult = $connection->query($sql);
    $noteRow = $noteResult->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$orderRow) {
        header("location: /carview.php?customerID=$customerID");
        exit;
    } else {

        $person = $noteRow["person"];
        $note = $noteRow["note"];
        $date = $noteRow["date"];

        $noteFirstAssoc = 1;

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MechanicShop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <scrip src="https://code.jquery.com/jquery-1.11.1.min.js">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

        <!-- Custom Styles and Overrides -->
        <link href="css/styles.css" rel="stylesheet">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@200;300;400;500;600;700&family=Patua+One&display=swap"
            rel="stylesheet">

</head>

<body>

    <!-- NavBar -->

    <nav class="navbar navbar-expand-md navbar-light bg-light">

        <div class="container">
            <a class="navbar-brand my-auto" href="index.html">
                <h2 class="d-inline-block mx-2 mb-0">Straight Auto</h2>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="nav nav-tabs navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/brownlizardindex.php">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/carsindex.php">Vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ordersindex.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/notesindex.php">Notes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Table for Client's Orders -->

    <div class="container my-5">

        <h2>Client Orders</h2>

        <?php echo "<a class='btn btn-primary' href='/carview.php?carID=$carID' role='button'>Back to Vehicle</a>" ?>

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Cust. ID</th>
                    <th>Vehicle ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th colspan="2">Parts</th>
                    <th>Date Created</th>
                    <th>Date Begun</th>
                    <th>Date Completed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // Read the data from each row
                //echo"<p> Death. </p>";
                while ($orderFirstAssoc == 1 || $orderRow = $orderResult->fetch_assoc()) {
                    // 'echo' allows us to print each row into the HTML table
                    // '?id=$row[customerID], in which the 'id' allows the edit/delete
                    // file to know which client we need to edit/delete.
                    //echo"<p>This ran.</p>";
                
                    $orderFirstAssoc = 0;

                    echo "
            <tr>
                <td>$orderRow[orderID]</td>
                <td>$orderRow[customerID]</td>
                <td>$orderRow[carID]</td>
                <td>$orderRow[title]</td>";

                    if ($orderRow["status"] == 1) {
                        echo "<td>Approved</td>";
                    } else if ($orderRow["status"] == 2) {
                        echo "<td>Pending</td>";
                    } else if ($orderRow["status"] == 3) {
                        echo "<td>Cancelled</td>";
                    } else if ($orderRow["status"] == 4) {
                        echo "<td>Finished</td>";
                    } else {
                        echo "<td>ERROR</td>";
                    }

                    echo "
                <td colspan='2'>$orderRow[parts]</td>
                <td>$orderRow[dateCreated]</td>
                <td>$orderRow[dateBegun]</td>
                <td>$orderRow[dateCompleted]</td>
                <td>
                    <a class='btn btn-primary btn-sm' href='/ordersedit.php?orderID=$orderRow[orderID]'>Edit</a>
                </td>
            </tr>
            <tr>
                <td colspan='12'>$orderRow[description]</td>
            </tr>
            ";
                }
                ?>

            </tbody>
        </table>

    </div>

    <!-- Notes Table -->

    <div class="container my-5">

        <h2>Notes</h2>

        <?php echo "<a class='btn btn-primary' href='/ovnotescreate.php?orderID=$orderID&carID=$carID&customerID=$customerID' role='button'>New Note</a>" ?>

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Person</th>
                    <th>Note</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="noteTable">

                <?php

                // Read the data from each row
                while ($noteFirstAssoc == 1 || $noteRow = $noteResult->fetch_assoc()) {
                    // 'echo' allows us to print each row into the HTML table
                    // '?id=$row[customerID], in which the 'id' allows the edit/delete
                    // file to know which client we need to edit/delete.
                
                    $noteFirstAssoc = 0;

                    echo "
                    <tr>
                        <td>$noteRow[person]</td>
                        <td>$noteRow[note]</td>
                        <td>$noteRow[date]</td>
                    </tr>
                    ";
                }
                ?>

            </tbody>
        </table>

    </div>