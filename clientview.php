<?php

include 'config.php';






// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$custID = "";
$firstName = "";
$lastName = "";
$phone = "";
$email = "";
$address = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the client data

    // If customer ID exists, then redirect to that user
    if (!isset($_GET["customerID"])) {
        header("location: /carsindex.php");
        exit;
    }

    // Read data of client from the database
    $custID = $_GET["customerID"];

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM customer_table WHERE customerID=$custID";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$row) {
        header("location: /brownlizardindex.php");
        exit;
    }

    // Store the data from the database into these variables
    $firstName = $row["firstName"];
    $lastName = $row["lastName"];
    $phone = $row["phone"];
    $email = $row["email"];
    $address = $row["address"];

    $firstAssoc = 1;

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM car_table WHERE customerID=$custID";
    $carResult = $connection->query($sql);
    $carRow = $carResult->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$carRow) {
        // header("location: /clientview.php");
        // exit;
    } else {

        // Store the data from the database into these variables
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

    // // This is the code to load the Order Information

    // // Read the row of the selected client from the database table
    // $sql = "SELECT * FROM order_table WHERE carID=$carID";
    // $orderResult = $connection->query($sql);
    // $orderRow = $orderResult->fetch_assoc();

    // // If we do not have any data, then re-direct user to view table
    // if (!$orderRow){
    //     // header("location: /clientview.php");
    //     // break;
    // }else{

    // // Store the data from the database into these variables
    // $orderID = $orderRow["orderID"];
    // $carID = $orderRow["carID"];
    // $title = $orderRow["title"];
    // $description = $orderRow["description"];
    // $approved = $orderRow["approved"];
    // $finished = $orderRow["finished"];
    // $dateCreated = $orderRow["dateCreated"];
    // $dateBegun = $orderRow["dateBegun"];
    // $dateCompleted = $orderRow["dateCompleted"];
    // $parts = $orderRow["parts"];

    // $orderFirstAssoc = 1;
    // }




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

    <div class="container my-5">

        <h2>Client Info</h2>

        <a class="btn btn-primary" href="/brownlizardindex.php" role="button">Back to Clients</a>

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="customerTable">

                <?php
                // Read the data from each row
                //echo"<p> Death. </p>";
                while ($firstAssoc == 1 || $row = $result->fetch_assoc()) {
                    // 'echo' allows us to print each row into the HTML table
                    // '?id=$row[customerID], in which the 'id' allows the edit/delete
                    // file to know which client we need to edit/delete.
                    //echo"<p>This ran.</p>";
                    $firstAssoc = 0;
                    echo "
                    <tr>
                        <td>$row[customerID]</td>
                        <td>$row[firstName]</td>
                        <td>$row[lastName]</td>
                        <td>$row[phone]</td>
                        <td>$row[email]</td>
                        <td>$row[address]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/brownlizardedit.php?customerID=$row[customerID]'>Edit</a>
                        </td>
                    </tr>
                    ";
                }
                ?>

            </tbody>
        </table>

    </div>

    <!-- Table for Client's Vehicles -->

    <div class="container my-5">

        <h2>Client Vehicles</h2>

        <?php echo "
        <a class='btn btn-primary' href='/cvcarscreate.php?customerID=$custID' role='button'>Add a Vehicle</a>" ?>

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Vehicle ID</th>
                    <th>customerID</th>
                    <th>Year</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Engine</th>
                    <th>VIN</th>
                    <th>Latest Order ID</th>
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
                        <td>$carRow[carID]</td>
                        <td>$carRow[customerID]</td>
                        <td>$carRow[cYear]</td>
                        <td>$carRow[make]</td>
                        <td>$carRow[model]</td>
                        <td>$carRow[engine]</td>
                        <td>$carRow[vin]</td>
                        
                        <td>$carRow[orderID]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/carview.php?carID=$carRow[carID]&customerID=$custID[customerID]'>Info</a>
                            <a class='btn btn-danger btn-sm' href='/carsdelete.php?carID=$carRow[carID]'>Delete</a>
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