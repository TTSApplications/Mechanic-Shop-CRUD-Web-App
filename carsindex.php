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
                    $("#carTable tr").filter(function () {
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
                        <a class="nav-link active" href="/carsindex.php">Vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ordersindex.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/notesindex.php">Notes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">

        <h2>Vehicles</h2>

        <!-- <a class="btn btn-primary" href="/carscreate.php" role="button">New Vehicle</a> -->

        <!-- Search Input Field -->
        <div class="form-group">
            <br>
            <input type="text" id="myInput" placeholder="Type Search Here..." class="form-control">
        </div>

        <br>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Vehicle ID</th>
                    <th>customerID</th>
                    <th>Year</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Engine</th>
                    <th>VIN</th>
                    <th>Latest Order ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="carTable">

                <?php
                include 'config.php';






                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all the rows from the database table
                $sql = "SELECT * FROM car_table ORDER BY carID DESC";
                $result = $connection->query($sql);

                // Check if query executed correctly
                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                // Read the data from each row
                while ($row = $result->fetch_assoc()) {
                    // 'echo' allows us to print each row into the HTML table
                    // '?id=$row[customerID], in which the 'id' allows the edit/delete
                    // file to know which client we need to edit/delete.
                
                    echo "
                    <tr>
                        <td>$row[carID]</td>
                        <td>$row[customerID]</td>
                        <td>$row[cYear]</td>
                        <td>$row[make]</td>
                        <td>$row[model]</td>
                        <td>$row[engine]</td>
                        <td>$row[vin]</td>
                        
                        <td>$row[orderID]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/carsedit.php?carID=$row[carID]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/carsdelete.php?carID=$row[carID]'>Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='9' class = 'table-active'>$row[carNote]</td>
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