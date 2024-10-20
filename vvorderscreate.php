<!-- The PHP code that allows us to read the submitted data -->
<?php

include 'config.php';






// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$orderID = "";
$customerID = "";
$carID = "";
$title = "";
$description = "";
$status = "";
// $approved = FALSE;
// $finished = FALSE;
// $dateCreated = "";
$dateBegun = "";
// $dateCompleted = "";
$parts = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the client data

    // If Vehicle ID exists, then redirect to that user
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
    $carID = $_GET["carID"];

}

// Check if the data has been transmitted using the 'POST' method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    // $dateCompleted = $_POST["dateCompleted"];
    $parts = addslashes($_POST["parts"]);

    // Perform checks to ensure fields are not empty/meet requirements etc.
    // Uses a while loop that is only executed one time.
    do {
        if (empty($customerID) || empty($carID) || empty($title) || empty($description) || empty($status)) {
            $errorMessage = "All the fields are required (Missing Field)";
            break;
        }

        // Add new client to database
        $sql = "INSERT INTO order_table (orderID, customerID, carID, title, description, status, dateBegun, parts)" .
            "VALUES ('$orderID', '$customerID', '$carID', '$title', '$description', $status, '$dateBegun', '$parts')";

        $result = $connection->query($sql);

        // If we have any errors, display error message and exit while loop
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Order added successfully";

        // Re-direct user to the Customer Table view
        header("location: /carview.php?customerID=$customerID&carID=$carID");
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

        <h2>New Order</h2>

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

            <!-- Input Fields -->

            <input type="hidden" name="customerID" value="<?php echo $customerID; ?>">

            <input type="hidden" name="carID" value="<?php echo $carID; ?>">

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
            <!-- <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date Completed (Leave Blank if N/A)</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="dateCompleted" value="<?php echo $dateCompleted; ?>">
                </div>
            </div> -->
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
                    <?php echo "<a class='btn btn-outline-primary' href='/carview.php?customerID=$customerID&carID=$carID' role='button'>Cancel</a>" ?>
                </div>
            </div>

        </form>
    </div>

</body>

</html>