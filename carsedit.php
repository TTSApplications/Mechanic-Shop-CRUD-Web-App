<?php

include 'config.php';






// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$cID = "";
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

    // If car ID exists, then redirect to that user
    if (!isset($_GET["carID"])) {
        header("location: /carsindex.php");
        exit;
    }

    // Read data of client from the database
    $cID = $_GET["carID"];

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM car_table WHERE carID=$cID";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$row) {
        header("location: /carsindex.php");
        exit;
    }

    // Store the data from the database into these variables
    $customerID = $row["customerID"];
    $make = $row["make"];
    $model = $row["model"];
    $year = $row["cYear"];
    $vin = $row["vin"];
    $engine = $row["engine"];
    $orderID = $row["orderID"];
    $carNote = $row["carNote"];

} else {
    // POST method: Update the client data

    // Read the data from the form
    $cID = addslashes($_POST["carID"]);
    $customerID = addslashes($_POST["customerID"]);
    $make = addslashes($_POST["make"]);
    $model = addslashes($_POST["model"]);
    $year = addslashes($_POST["cYear"]);
    $vin = addslashes($_POST["vin"]);
    $engine = addslashes($_POST["engine"]);
    $orderID = addslashes($_POST["orderID"]);
    $carNote = addslashes($_POST["carNote"]);

    // Check to make sure we have no empty fields, using a do-while loop
    do {

        if (empty($cID) || empty($customerID) || empty($make) || empty($model) || empty($year)) {
            $errorMessage = "All the fields are required (Missing Field)";
            break;
        }

        // The SQL query to update the fields
        $sql = "UPDATE car_table " .
            "SET carID = '$cID', customerID = '$customerID', make = '$make', model = '$model', cYear = '$year', vin = '$vin', engine = '$engine', orderID = '$orderID', carNote = '$carNote' " .
            "WHERE carID = $cID";

        $result = $connection->query($sql);

        // If we have any errors, display error message and exit while loop
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $cID = "";
        $customerID = "";
        $make = "";
        $model = "";
        $year = "";
        $vin = "";
        $engine = "";
        $orderID = "";
        $carNote = "";

        $successMessage = "Vehicle added successfully";

        // Re-direct user to the Customer Table view
        header("location: /carsindex.php");
        exit;

    } while (false);

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
</head>

<body>

    <div class="container my-5">

        <h2>Edit Car</h2>

        <!-- Display Error Message if it's not empty -->
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">

            <!-- Hidden input that stores ID of client -->
            <input type="hidden" name="carID" value="<?php echo $cID; ?>">

            <!-- Input Fields -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Customer ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customerID" value="<?php echo $customerID; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Year</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="cYear" value="<?php echo $year; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Make</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="make" value="<?php echo $make; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Model</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="model" value="<?php echo $model; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Engine</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="engine" value="<?php echo $engine; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">VIN #</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="vin" value="<?php echo $vin; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Order ID (Leave Blank if None)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="orderID" value="<?php echo $orderID; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Vehicle Note</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="carNote" value="<?php echo $carNote; ?>">
                </div>
            </div>

            <!-- Display Success Message if it's not empty -->
            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <!-- Submit Button -->
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/carsindex.php" role="button">Cancel</a>
                </div>
            </div>

        </form>
    </div>

</body>

</html>