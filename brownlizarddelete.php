<?php
// Check if this row contains the customerID
if (isset($_GET["customerID"])) {

    $custID = $_GET["customerID"];

    include 'config.php';






    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Delete the client row from the customer_table
    $sql = "DELETE FROM customer_table WHERE customerID=$custID";

    $connection->query($sql);

}

// Re-direct user to customer table view
header("location: /brownlizardindex.php");
exit;

?>