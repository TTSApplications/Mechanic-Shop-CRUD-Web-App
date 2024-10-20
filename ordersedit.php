<?php

include 'config.php';






// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$customerID = "";
$carID = "";
$title = "";
$description = "";
$status = "";
// $approved = FALSE;
// $finished = FALSE;
// $dateCreated = "";
$dateBegun = "";
$dateCompleted = "";
$parts = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the client data

    // If car ID exists, then redirect to that user
    if (!isset($_GET["orderID"])) {
        header("location: /ordersindex.php");
        exit;
    }

    // Read data of client from the database
    $orderID = $_GET["orderID"];

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM order_table WHERE orderID=$orderID";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$row) {
        header("location: /ordersindex.php");
        exit;
    }

    // Store the data from the database into these variables
    $customerID = $row["customerID"];
    $carID = $row["carID"];
    $title = $row["title"];
    $description = $row["description"];
    $status = $row["status"];
    // $approved = $row["approved"];
    // $finished = $row["finished"];
    // $dateCreated = $_POST["dateCreated"];
    $dateBegun = $row["dateBegun"];
    $dateCompleted = $row["dateCompleted"];
    $parts = $row["parts"];

} else {
    // POST method: Update the client data

    // Read the data from the form
    $orderID = addslashes($_POST["orderID"]);
    $customerID = addslashes($_POST["customerID"]);
    $carID = addslashes($_POST["carID"]);
    $title = addslashes($_POST["title"]);
    $description = addslashes($_POST["description"]);
    $status = addslashes($_POST["status"]);
    // $approved = $_POST["approved"];
    // $finished = $_POST["finished"];
    // $dateCreated = $_POST["dateCreated"];
    $dateBegun = addslashes($_POST["dateBegun"]);
    $dateCompleted = addslashes($_POST["dateCompleted"]);
    $parts = addslashes($_POST["parts"]);

    // Check to make sure we have no empty fields, using a do-while loop
    do {

        if (empty($customerID) || empty($carID) || empty($title) || empty($description) || empty($status)) {
            $errorMessage = "All the fields are required (Missing Field)";
            break;
        }

        // The SQL query to update the fields
        $sql = "UPDATE order_table " .
            "SET customerID = '$customerID', carID = '$carID', title = '$title', description = '$description', status = '$status', dateBegun = '$dateBegun', dateCompleted = '$dateCompleted', parts = '$parts' " .
            "WHERE orderID = $orderID";

        $result = $connection->query($sql);

        // If we have any errors, display error message and exit while loop
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        // $customerID = "";
        // $carID = "";
        // $title = "";
        // $description = "";
        // $status = "";
        // // $approved = 0;
        // // $finished = 0;
        // // $dateCreated = "";
        // $dateBegun = "";
        // $dateCompleted = "";
        // $parts = "";

        $successMessage = "Order added successfully";

        // Re-direct user to the Customer Table view
        header("location: /ordersindex.php");
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

        <h2>Edit Order</h2>

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

            <!-- Hidden input that stores ID of order -->
            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">

            <!-- Input Fields -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Customer ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="customerID" value="<?php echo $customerID; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Vehicle ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="carID" value="<?php echo $carID; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <!-- <div class="input-group-prepend"> -->
                <label class="col-sm-3 col-form-label">Status</label>
                <!-- </div> -->
                <select class="custom-select col-sm-6" name="status">
                    <option selected class="form-control" name="status" value="">Choose...</option>
                    <option class="form-control" name="status" value="1">Approved</option>
                    <option class="form-control" name="status" value="2">Pending</option>
                    <option class="form-control" name="status" value="3">Cancelled</option>
                    <option class="form-control" name="status" value="4">Finished</option>
                </select>
            </div>
            <!-- <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Approved (TRUE/FALSE)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="approved" value="<?php echo $approved; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Finished (TRUE/FALSE)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="finished" value="<?php echo $finished; ?>">
                </div>
            </div> -->
            <!-- <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date Created</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="dateCreated" value="<?php echo $dateCreated; ?>">
                </div>
            </div> -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date Begun (Leave Blank if N/A)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="dateBegun" value="<?php echo $dateBegun; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date Completed (Leave Blank if N/A)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="dateCompleted" value="<?php echo $dateCompleted; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Parts (Leave Blank if N/A)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="parts" value="<?php echo $parts; ?>">
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
                    <a class="btn btn-outline-primary" href="/ordersindex.php" role="button">Cancel</a>
                </div>
            </div>

        </form>
    </div>

</body>

</html>