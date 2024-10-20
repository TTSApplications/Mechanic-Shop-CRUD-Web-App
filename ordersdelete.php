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

}

// Re-direct user to customer table view
header("location: /ordersindex.php");
exit;

?>