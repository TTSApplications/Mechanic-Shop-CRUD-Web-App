<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MechanicShop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">

        <h2>List of Clients</h2>

        <a class="btn btn-primary" href="/brownlizardcreate.php" role="button">New Client</a>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include 'config.php';






                // Create connection
                $connection = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Read all the rows from the database table
                $sql = "SELECT * FROM customer_table";
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
                        <td>$row[customerID]</td>
                        <td>$row[firstName]</td>
                        <td>$row[lastName]</td>
                        <td>$row[phone]</td>
                        <td>$row[email]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/brownlizardedit.php?customerID=$row[customerID]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/brownlizarddelete.php?customerID=$row[customerID]'>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                ?>

            </tbody>
        </table>

    </div>
</body>

</html>