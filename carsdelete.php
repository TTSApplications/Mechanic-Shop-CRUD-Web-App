<?php
// Check if this row contains the customerID
if (isset($_GET["carID"])) {

    $cID = $_GET["carID"];

    include 'config.php';






    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Delete the client row from the customer_table
    $sql = "DELETE FROM car_table WHERE carID=$cID";

    $connection->query($sql);

}

// Re-direct user to customer table view
header("location: /carsindex.php");
exit;

?>