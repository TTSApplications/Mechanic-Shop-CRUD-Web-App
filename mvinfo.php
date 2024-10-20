<?php

include 'config.php';






// Create connection
$connection = new mysqli($servername, $username, $password, $database);

$carID = "";
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

    // If customer ID exists, then redirect to that user
    if (!isset($_GET["carID"])) {
        header("location: /mechanicview.php");
        exit;
    }

    // Read data of client from the database
    $carID = $_GET["carID"];

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM car_table WHERE carID=$carID";
    $carResult = $connection->query($sql);
    $carRow = $carResult->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$carRow) {
        header("location: /mechanicview.php");
        exit;
    } else {

        // Store the data from the database into these variables
        $customerID = $carRow["customerID"];
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

    // This is the code to load the Order Information

    if (!isset($_GET["orderID"])) {
        header("location: /mechanicview.php");
        exit;
    }

    // Read data of order from the database
    $orderID = $_GET["orderID"];

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM order_table WHERE orderID=$orderID";
    $orderResult = $connection->query($sql);
    $orderRow = $orderResult->fetch_assoc();

    // If we do not have any data, then re-direct user to view table
    if (!$orderRow) {
        // header("location: /clientview.php");
        // break;
    } else {

        // Store the data from the database into these variables
        $orderID = $orderRow["orderID"];
        $carID = $orderRow["carID"];
        $title = $orderRow["title"];
        $description = $orderRow["description"];
        $status = $orderRow["status"];
        $dateCreated = $orderRow["dateCreated"];
        $dateBegun = $orderRow["dateBegun"];
        $dateCompleted = $orderRow["dateCompleted"];
        $parts = $orderRow["parts"];

        $orderFirstAssoc = 1;
    }

    $orderID = $_GET["orderID"];

    // Read the row of the selected client from the database table
    $sql = "SELECT * FROM note_table WHERE orderID=$orderID ORDER BY date DESC";
    $noteResult = $connection->query($sql);
    $noteRow = $noteResult->fetch_assoc();

    if (!$noteRow) {
        // header("location: /mechanicview.php");
    } else {
        $note = $noteRow["note"];
        $date = $noteRow["date"];

        $noteFirstAssoc = 1;
    }

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

        <!-- Script using AJAX JQuery for Search Bar -->
        <!-- <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function(){
                var value = $(this).val().toLowerCase();
                $("#customerTable tr").filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script> -->

</head>

<body>

    <!-- NavBar -->

    <nav class="navbar navbar-expand-md navbar-light bg-light">

        <div class="container">
            <a class="navbar-brand my-auto" href="/mechanicview.php">
                <h2 class="d-inline-block mx-2 mb-0">Straight Auto</h2>
            </a>

        </div>
    </nav>

    <!-- Hero for Vehicle Information -->

    <div class="container my-5">

        <!-- <h2>Vehicle Info</h2> -->

        <!-- <a class="btn btn-primary" href="/clientview.php<_php echo "?customerID=$customerID"?>" role="button">Back to Client</a> -->

        <!-- <br> -->

        <table class="table table-striped table-hover">
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
                    <div id='hero' class='p-5 mb-4 bg-dark text-light'>
                        <div class='container py-5'>

                            <h1 class='display-5'>$carRow[cYear] $carRow[make] $carRow[model]</h1>
                            
                            <br>

                            <p class='col-md-8 fs-4'> Engine: $carRow[engine]</p>
                            
                            <br>

                            <p class='col-md-8 fs-4'> VIN: $carRow[vin]</p>

                            <br>

                            <p class='col-md-8 fs-4'> Vehicle Note: $carRow[carNote]</p>
                        </div>
                    </div>
                    ";
                }
                ?>

            </tbody>
        </table>

        <a class="btn btn-primary" href="/mechanicview.php" role="button">Back to Orders</a>

    </div>

    <!-- Hero for Order Information -->

    <div class="container my-5">

        <h2>Job Description</h2>

        <br>

        <table class="table table-striped table-hover">
            <tbody>
                <?php
                echo "
                    <div id='hero' class='p-5 mb-4 bg-dark text-light'>
                        <div class='container py-5'>

                            <h1 class='display-5'>$orderRow[title]</h1>
                            
                            <br>

                            <p class='col-md-8 fs-4'>$orderRow[description]</p>
                            
                            <br>

                            <p class='col-md-8 fs-4'> Parts: $orderRow[parts]</p>
                        </div>
                    </div>
                    ";

                ?>

            </tbody>
        </table>

    </div>

    <!-- Notes -->

    <div class="container my-5">

        <h2>Notes</h2>

        <a class="btn btn-primary" href="/mvnotescreate.php<?php echo "?carID=$carID&orderID=$orderID" ?>"
            role="button">Add Note</a>

        <!-- <br> -->

        <table class="table table-striped table-hover">
            <tbody>
                <div class='container mb-3'>
                    <div class='row row-cols-1 row-cols-md-3 g-4'>
                        <div class='col'>
                            <br>

                            <?php
                            // Read the data from each row
                            //echo"<p> Death. </p>";
                            while ($noteFirstAssoc == 1 || $noteRow = $noteResult->fetch_assoc()) {
                                // 'echo' allows us to print each row into the HTML table
                                // '?id=$row[customerID], in which the 'id' allows the edit/delete
                                // file to know which client we need to edit/delete.
                                //echo"<p>This ran.</p>";
                                $noteFirstAssoc = 0;
                                echo "
                    
                            <div class='card bg-light-gradient'>
                                <a href='https://github.com/TTSApplications/Pollution_NY_Area/blob/master/Pollution_in_NY_Area.pdf' title='Read the Project' role='button'>
                                <!-- <img src='/img/nyProject.png' class='card-img-top' alt='Image of a Map with Clustering Regions'> --!>
                                <div class='card-body'>
                                <h5 class='card-title'>$noteRow[person]</h5>
                                <br>
                                <p class='card-text'><b>Note:</b> $noteRow[note]</p>
                                <br>
                                <p class='card-text'>$noteRow[date]</p>
                                </div>
                                </a>
                            </div>
                            <!-- </div> --!>
                            <br>
                        
                        
                    ";
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </tbody>
        </table>

        <a class="btn btn-primary" href="/mechanicview.php" role="button">Back to Orders</a>

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