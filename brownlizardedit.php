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
        header("location: /brownlizardindex.php");
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

} else {
    // POST method: Update the client data

    // Read the data from the form
    $custID = addslashes($_POST["customerID"]);
    $firstName = addslashes($_POST["firstName"]);
    $lastName = addslashes($_POST["lastName"]);
    $phone = addslashes($_POST["phone"]);
    $email = addslashes($_POST["email"]);
    $address = addslashes($_POST["address"]);

    // Check to make sure we have no empty fields, using a do-while loop
    do {

        if (empty($custID) || empty($firstName) || empty($lastName) || empty($phone)) {
            $errorMessage = "All the fields are required (Missing Field)";
            break;
        }

        // The SQL query to update the fields
        $sql = "UPDATE customer_table " .
            "SET firstName = '$firstName', lastName = '$lastName', phone = '$phone', email = '$email', address = '$address'" .
            "WHERE customerID = $custID";

        $result = $connection->query($sql);

        // If we have any errors, display error message and exit while loop
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $custID = "";
        $firstName = "";
        $lastName = "";
        $phone = "";
        $email = "";
        $address = "";

        $successMessage = "Client added successfully";

        // Re-direct user to the Customer Table view
        header("location: /brownlizardindex.php");
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

        <h2>Edit Client</h2>

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
            <input type="hidden" name="customerID" value="<?php echo $custID; ?>">

            <!-- Input Fields -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
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
                    <a class="btn btn-outline-primary" href="/brownlizardindex.php" role="button">Cancel</a>
                </div>
            </div>

        </form>
    </div>

</body>

</html>