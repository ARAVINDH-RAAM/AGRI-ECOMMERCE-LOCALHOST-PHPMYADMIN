<?php

session_start();

include('../includes/connect.php');

if (!isset($_SESSION['adminfirstname'])) {
    header("Location: ../admin/adminlogin.php"); 
    exit();
}

$select_query = "SELECT * FROM `user`";
$result_query = mysqli_query($con, $select_query);

if (!$result_query) {
    die("Error fetching user info: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">User Information</h3>
        <table class="table table-bordered table-light">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date Registered</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                while ($row = mysqli_fetch_assoc($result_query)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['userid']) . "</td>
                        <td>" . htmlspecialchars($row['firstname']) . "</td>
                        <td>" . htmlspecialchars($row['lastname']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
