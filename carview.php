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

    // If customer ID exists, then redirect to that user
    if (!isset($_GET["carID"])) {
        header("location: /carsindex.php");
        exit;
    }

    // Read data of client from the database
    $carID = $_GET["carID"];
    $custID = $_GET["customerID"];

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM car_table WHERE carID=$carID";
    $carResult = $connection->query($sql);
    $carRow = $carResult->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$carRow) {
        header("location: /clientview.php?customerID=$customerID");
        exit;
    } else {

        // Store the data from the database into these variables
        $customerID = $carRow["customerID"];
        $carID = $carRow["carID"];
        $make = $carRow["make"];
        $model = $carRow["model"];
        $year = $carRow["cYear"];
        $vin = $carRow["vin"];
        $engine = $carRow["engine"];
        $orderID = $carRow["orderID"];
        $carNote = $carRow["carNote"];

        $carFirstAssoc = 1;

    }

    // This is the code to load the Order Information

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM order_table WHERE carID=$carID";
    $orderResult = $connection->query($sql);
    $orderRow = $orderResult->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$orderRow) {
        // header("location: /clientview.php");
        // break;
    } else {

        // Store the data from the database into these variables
        $orderID = $orderRow["orderID"];
        $carID = $orderRow["carID"];
        $title = $orderRow["title"];
        $description = $orderRow["description"];
        $status = $orderRow["status"];
        // $approved = $orderRow["approved"];
        // $finished = $orderRow["finished"];
        $dateCreated = $orderRow["dateCreated"];
        $dateBegun = $orderRow["dateBegun"];
        $dateCompleted = $orderRow["dateCompleted"];
        $parts = $orderRow["parts"];

        $orderFirstAssoc = 1;
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

        <!-- Script using AJAX JQuery for Search Bar -->
        <!-- <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function(){
                var value = $(this).val().toLowerCase();
                $("#customerTable tr").filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script> -->

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

    <!-- Table for Client's Vehicles -->

    <div class="container my-5">

        <h2>Vehicle Info</h2>

        <a class="btn btn-primary" href="/clientview.php<?php echo "?customerID=$customerID" ?>" role="button">Back to
            Client</a>

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Engine</th>
                    <th>VIN</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // Read the data from each row
                //echo"<p> Death. </p>";
                while ($carFirstAssoc == 1 || $carRow = $carResult->fetch_assoc()) {
                    // 'echo' allows us to print each row into the HTML table
                    // '?id=$row[customerID], in which the 'id' allows the edit/delete
                    // file to know which client we need to edit/delete.
                    //echo"<p>This ran.</p>";
                    $carFirstAssoc = 0;
                    echo "
                    <tr>
                        <td>$carRow[cYear]</td>
                        <td>$carRow[make]</td>
                        <td>$carRow[model]</td>
                        <td>$carRow[engine]</td>
                        <td>$carRow[vin]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/carsedit.php?carID=$carRow[carID]'>Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='9' class = 'table-active'>$carRow[carNote]</td>
                    </tr>
                    ";
                }
                ?>

            </tbody>
        </table>

    </div>

    <!-- Table for Client's Orders -->

    <div class="container my-5">

        <h2>Vehicle Orders</h2>

        <?php echo "<a class='btn btn-primary' href='/vvorderscreate.php?customerID=$customerID&carID=$carID' role='button'>Add Order</a>" ?>

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
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
                            <a class='btn btn-primary btn-sm' href='/orderview.php?orderID=$orderRow[orderID]&customerID=$orderRow[customerID]&carID=$orderRow[carID]'>Info</a>
                            <a class='btn btn-danger btn-sm' href='/cvordersdelete.php?orderID=$orderRow[orderID]&customerID=$orderRow[customerID]&carID=$orderRow[carID]'>Delete</a>
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

    <!-- Footer -->
    <footer class="sticky-footer mt-auto  py-3 bg-dark">
        <div class="container text-center">
            <span class="text-white">Created by <a class="text-white" href="https://antoniolaplaca.com">Antonio
                    LaPlaca</a> with <a class="text-white" href="https://getbootstrap.com">Bootstrap</a> and <a
                    class="text-white" href="https://www.php.net/">PHP</a>. Check out my <a class="text-white"
                    href="https://github.com/ttsapplications">GitHub</a>.</span>
        </div>
    </footer>

</body>

</html>