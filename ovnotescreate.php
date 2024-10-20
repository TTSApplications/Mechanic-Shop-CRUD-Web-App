<!-- The PHP code that allows us to read the submitted data -->
<?php

include 'config.php';






// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$orderID = "";
$person = "";
$note = "";

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

}

// Check if the data has been transmitted using the 'POST' method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderID = addslashes($_POST["orderID"]);
    $person = addslashes($_POST["person"]);
    $note = addslashes($_POST["note"]);

    // Perform checks to ensure fields are not empty/meet requirements etc.
    // Uses a while loop that is only executed one time.
    do {
        if (empty($orderID) || empty($person) || empty($note)) {
            $errorMessage = "All the fields are required (Missing Field)";
            break;
        }

        // Add new client to database
        $sql = "INSERT INTO note_table (orderID, person, note)" .
            "VALUES ('$orderID', '$person', '$note')";

        $result = $connection->query($sql);

        // If we have any errors, display error message and exit while loop
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Note added successfully";

        // Re-direct user to the Notes Table view
        header("location: /orderview.php?orderID=$orderID&carID=$carID&customerID=$customerID");
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

        <h2>New Note</h2>

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

            <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Person</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="person" value="<?php echo $person; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Note</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="note" value="<?php echo $note; ?>">
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
                    <?php echo "<a class='btn btn-outline-primary' href='/orderview.php?orderID=$orderID&carID=$carID&customerID=$customerID' role='button'>Cancel</a>" ?>
                </div>
            </div>

        </form>
    </div>

</body>

</html>