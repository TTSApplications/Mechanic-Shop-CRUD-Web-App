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
        <script>
            $(document).ready(function () {
                $("#myInput").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#orderTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>

</head>

<body>

    <!-- NavBar -->

    <nav class="navbar navbar-expand-md navbar-light bg-light">

        <div class="container">
            <a class="navbar-brand my-auto" href="index.html">
                <h2 class="d-inline-block mx-2 mb-0">Straight Auto</h2>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="nav nav-tabs navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/brownlizardindex.php">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/carsindex.php">Vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/ordersindex.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/notesindex.php">Notes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5 table-responsive">

        <h2>Orders</h2>

        <!-- <a class="btn btn-primary" href="/orderscreate.php" role="button">New Order</a> -->

        <!-- Search Input Field -->
        <div class="form-group">
            <br>
            <input type="text" id="myInput" placeholder="Type Search Here..." class="form-control">
        </div>

        <br>

        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Cust. ID</th>
                    <th>Vehicle ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <!-- <th>Approved</th>
                    <th>Finished</th> -->
                    <th colspan="2">Parts</th>
                    <th>Date Created</th>
                    <th>Date Begun</th>
                    <th>Date Completed</th>
                    <th colspan="6">Description</th>
                    <th>Actions</th>

                </tr>
            </thead>
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
                $sql = "SELECT * FROM order_table ORDER BY orderID DESC";
                $result = $connection->query($sql);
                $row = $result->fetch_assoc();

                // If we do not have any data, then re-direct user to view table
                if (!$row) {
                    header("location: /brownlizardindex.php");
                    exit;
                }

                // Store the data from the database into these variables
                $orderID = $row["orderID"];
                $carID = $row["carID"];
                $title = $row["title"];
                $description = $row["description"];
                $status = $row["status"];
                $approved = $row["approved"];
                $finished = $row["finished"];
                $dateCreated = $row["dateCreated"];
                $dateBegun = $row["dateBegun"];
                $dateCompleted = $row["dateCompleted"];
                $parts = $row["parts"];

                $firstAssoc = 1;


                // Read the data from each row
                while ($firstAssoc == 1 || $row = $result->fetch_assoc()) {
                    // 'echo' allows us to print each row into the HTML table
                    // '?id=$row[customerID], in which the 'id' allows the edit/delete
                    // file to know which client we need to edit/delete.
                    $firstAssoc = 0;
                    echo "
                    <tr>
                        <td>$row[orderID]</td>
                        <td>$row[customerID]</td>
                        <td>$row[carID]</td>
                        <td>$row[title]</td>";

                    if ($row["status"] == 1) {
                        echo "<td>Approved</td>";
                    } else if ($row["status"] == 2) {
                        echo "<td>Pending</td>";
                    } else if ($row["status"] == 3) {
                        echo "<td>Cancelled</td>";
                    } else if ($row["status"] == 4) {
                        echo "<td>Finished</td>";
                    } else {
                        echo "<td>ERROR</td>";
                    }

                    echo "
                        
                        <td colspan='2'>$row[parts]</td>
                        <td>$row[dateCreated]</td>
                        <td>$row[dateBegun]</td>
                        <td>$row[dateCompleted]</td>
                        <td colspan='6'>$row[description]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/ordersedit.php?orderID=$row[orderID]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/ordersdelete.php?orderID=$row[orderID]'>Delete</a>
                        </td>
                    </tr>
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