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
                $("#orderTable tr").filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script> -->

</head>

<body class="bg-dark">

    <!-- NavBar -->

    <nav class="navbar navbar-expand-md navbar-light bg-light">

        <div class="container">
            <a class="navbar-brand my-auto" href="/mechanicview.php">
                <h2 class="d-inline-block mx-2 mb-0">Straight Auto</h2>
            </a>
        </div>
    </nav>

    <div class="container my-5 table-responsive">

        <h2 class="text-white">Mechanic View</h2>

        <br>

        <table class="table table-striped table-hover align-middle">
            <tbody id="orderTable">

                <?php
                include 'config.php';



                


                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all the rows from the database table
                $sql = "SELECT * FROM order_table WHERE status = 1";
                $result = $connection->query($sql);
                $row = $result->fetch_assoc();

                // If we do not have any data, then re-direct user to view table
                if (!$row) {
                    // header("location: /brownlizardindex.php");
                    exit;
                }

                // Store the data from the database into these variables
                $orderID = $row["orderID"];
                $carID = $row["carID"];
                $title = $row["title"];
                $description = $row["description"];
                $approved = $row["approved"];
                $finished = $row["finished"];
                $dateCreated = $row["dateCreated"];
                $dateBegun = $row["dateBegun"];
                $dateCompleted = $row["dateCompleted"];
                $parts = $row["parts"];

                $orderFirstAssoc = 1;

                // Read the data from each row
                while ($orderFirstAssoc == 1 || $row = $result->fetch_assoc()) {
                    // 'echo' allows us to print each row into the HTML table
                    // '?id=$row[customerID], in which the 'id' allows the edit/delete
                    // file to know which client we need to edit/delete.
                
                    $orderFirstAssoc = 0;

                    echo "
                    <div class='container mb-3'>
                        <div class='row row-cols-1 row-cols-md-3 g-4'>
                            <div class='col'>
                            <div class='card bg-light-gradient'>
                                <a href='https://github.com/TTSApplications/Pollution_NY_Area/blob/master/Pollution_in_NY_Area.pdf' title='Read the Project' role='button'>
                                <!-- <img src='/img/nyProject.png' class='card-img-top' alt='Image of a Map with Clustering Regions'> --!>
                                <div class='card-body'>
                                <h5 class='card-title'>$row[title]</h5>
                                <p class='card-text'>$row[description]</p>
                                <br>
                                <a href='/mvinfo.php?carID=$row[carID]&orderID=$row[orderID]' class='btn btn-primary'>See Details</a>
                                </div>
                                </a>
                            </div>
                            </div>
                        
                        </div>
                        </div>
                    </div>
                    ";
                }
                ?>

            </tbody>
        </table>

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