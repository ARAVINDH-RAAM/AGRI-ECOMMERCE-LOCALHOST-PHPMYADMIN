<?php

session_start();

include('../includes/connect.php');

if (!isset($_SESSION['adminfirstname'])) {
    header("Location: ../admin/adminlogin.php"); 
    exit();
}

$select_query = "
    SELECT orders.orderid, user.firstname, orders.ordertitle, orders.orderprice, orders.orderdate, orders.orderstatus
    FROM `orders`
    JOIN `user` ON orders.userorderid = user.userid
";
$result_query = mysqli_query($con, $select_query);

if (!$result_query) {
    die("Error fetching orders: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Admin Information</h3>
        <table class="table table-bordered table-light">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Order Name</th>
                    <th scope="col">Order Price</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
               
                while ($row = mysqli_fetch_assoc($result_query)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['orderid']) . "</td>
                        <td>" . htmlspecialchars($row['firstname']) . "</td>
                        <td>" . htmlspecialchars($row['ordertitle']) . "</td>
                        <td>₹" . number_format($row['orderprice'], 2) . "</td>
                        <td>" . htmlspecialchars($row['orderdate']) . "</td>
                        <td>" . htmlspecialchars($row['orderstatus']) . "</td>
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
