<?php
// Check if this row contains the customerID
if (isset($_GET["orderID"])) {

    $orderID = $_GET["orderID"];

    include 'config.php';






    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Delete the client row from the customer_table
    $sql = "DELETE FROM order_table WHERE orderID=$orderID";

    $connection->query($sql);

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

}

// Re-direct user to customer table view
header("location: /carview.php?customerID=$customerID&carID=$carID");
exit;

?>