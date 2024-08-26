<?php

session_start();

include('../includes/connect.php');

if (!isset($_SESSION['userid'])) {
    header("Location: ../userdetails/userlogin.php");
    exit();
}

$userid = mysqli_real_escape_string($con, $_SESSION['userid']);
$select_query = "SELECT * FROM `orders` WHERE `userorderid` = '$userid' ORDER BY `orderdate` DESC";
$result_query = mysqli_query($con, $select_query);

if (!$result_query) {
    die("Error fetching orders: " . mysqli_error($con));
}

$orders_by_date = [];
while ($row = mysqli_fetch_assoc($result_query)) {
    $orderdate = $row['orderdate'];
    $itemname = $row['ordertitle'];
    $itemprice = $row['orderprice'];
    $itemimage = $row['orderimage'];
    $itemdescription = $row['orderdescription'];
    $itemstatus = $row['orderstatus'];

    if (!isset($orders_by_date[$orderdate])) {
        $orders_by_date[$orderdate] = [];
    }

    if (!isset($orders_by_date[$orderdate][$itemname])) {
        $orders_by_date[$orderdate][$itemname] = [
            'itemprice' => $itemprice,
            'itemimage' => $itemimage,
            'itemdescription' => $itemdescription,
            'itemstatus' => $itemstatus,
            'quantity' => 0,
        ];
    }
    $orders_by_date[$orderdate][$itemname]['quantity']++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .logo {
            max-height: 50px;
            width: auto;
        }
        .quantity-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: black;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 14px;
        }
        .card {
            margin-bottom: 1rem;
            border-radius: 10px;
            overflow: hidden;
        }
        .card-img-wrapper {
            width: 220px;
            height: 220px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-footer {
            background-color: #f8f9fa;
        }
        .date-card {
            border: 5px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .date-header {
            
            background-color:#6c757d;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <img src="../agrisiteimages/logo.jpg" alt="logo" class="logo">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=aravindat2003@gmail.com&su=Inquiry%20About%20Your%20Product&body=Hello,%20I%20would%20like%20more%20information%20about%20your%20product.">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="bg-light p-4 mb-4 rounded">
        <h3 class="text-center">Order Confirmation</h3>
        <p class="text-center">Thank you for your order! Here are the details:</p>
    </div>

    <?php foreach ($orders_by_date as $orderdate => $orders): ?>
        <?php 
        $totalForDate = array_sum(array_map(function($item) {
            return $item['itemprice'] * $item['quantity'];
        }, $orders)); 
        ?>
        <div class="date-card shadow-sm">
            <div class="date-header">
                <?php echo htmlspecialchars(date("F j, Y", strtotime($orderdate))); ?>
                <span class="text-light">- Total: ₹ <?php echo number_format($totalForDate, 2); ?></span>
            </div>
        
            <?php foreach ($orders as $itemname => $details): ?>
                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-md-3 d-flex justify-content-center align-items-center">
                            <div class="card-img-wrapper">
                                <img src="../adminarea/product_images/<?php echo htmlspecialchars($details['itemimage']); ?>" class="card-img" alt="<?php echo htmlspecialchars($itemname); ?>">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($itemname); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($details['itemdescription']); ?></p>
                                <p class="card-text">₹ <?php echo number_format($details['itemprice'], 2); ?></p>
                                <p class="card-text">Status: <?php echo htmlspecialchars($details['itemstatus']); ?></p>
                                <span class="quantity-badge">x<?php echo $details['quantity']; ?></span>
                            </div>
                            <div class="card-footer">
                                <p class="text-muted mb-0">Total: ₹ <?php echo number_format($details['itemprice'] * $details['quantity'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <div class="d-flex justify-content-between pt-3">
        <p class="fw-bold mb-0">Order Summary</p>
        <p class="text-muted mb-0"><span class="fw-bold">Total Amount:</span> ₹ <?php
            $totalAmount = array_sum(array_map(function($item) {
                return $item['itemprice'] * $item['quantity'];
            }, array_merge(...array_values($orders_by_date))));
            echo number_format($totalAmount, 2);
        ?></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
