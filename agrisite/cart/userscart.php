<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include('../includes/connect.php');

if (!isset($_SESSION['userid'])) {
    header("Location: ../userdetails/userlogin.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['cartitemid'])) {
    $cartitemid = mysqli_real_escape_string($con, $_GET['cartitemid']);
    $userid = mysqli_real_escape_string($con, $_SESSION['userid']);
    
    $delete_query = "DELETE FROM `cartitems` WHERE `useridfk` = '$userid' AND `cartitemid` = '$cartitemid'";
    
    if (mysqli_query($con, $delete_query)) {
        echo "Item removed successfully<br>";
        
        $cart_query = "SELECT COUNT(*) AS total_quantity FROM `cartitems` WHERE `useridfk` = '$userid'";
        $cart_result = mysqli_query($con, $cart_query);
        if (!$cart_result) {
            die("Error counting cart items: " . mysqli_error($con));
        }
        
        $row_countforcart = mysqli_fetch_assoc($cart_result);
        $_SESSION['cartquantity'] = $row_countforcart['total_quantity'];

        header("Location: userscart.php");
        exit();
    } else {
        echo "Error removing item: " . mysqli_error($con);
    }
}

if (isset($_POST['checkout'])) {
    echo "Processing checkout<br>";

    $userid = mysqli_real_escape_string($con, $_SESSION['userid']);
    $total = 0;

    $select_query = "SELECT * FROM `cartitems` WHERE `useridfk` = '$userid'";
    $result_query = mysqli_query($con, $select_query);

    if (!$result_query) {
        die("Error fetching cart items: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_assoc($result_query)) {
        $itemname = $row['itemname'];
        $itemprice = $row['itemprice'];
        $itemimage = $row['itemimage'];
        $itemdescription = $row['itemdescription'];

        $insert_order_query = "INSERT INTO `orders` (userorderid, ordertitle, orderimage, orderdescription, orderprice) 
                               VALUES ('$userid', '$itemname', '$itemimage', '$itemdescription', '$itemprice')";
        
        if (!mysqli_query($con, $insert_order_query)) {
            die("Error inserting order: " . mysqli_error($con));
        } else {
            echo "Order for $itemname inserted successfully.<br>";
        }

        $total += $itemprice;
    }

    $clear_cart_query = "DELETE FROM `cartitems` WHERE `useridfk` = '$userid'";
    if (!mysqli_query($con, $clear_cart_query)) {
        die("Error clearing cart: " . mysqli_error($con));
    }

    $_SESSION['cartquantity'] = 0;
    header("Location: orderconfirmation.php");
    exit();
}


$userid = mysqli_real_escape_string($con, $_SESSION['userid']); 
$select_query = "SELECT * FROM `cartitems` WHERE `useridfk` = '$userid'";
$result_query = mysqli_query($con, $select_query);

if (!$result_query) {
    die("Error fetching cart items: " . mysqli_error($con));
}

$cart_items = [];
$total = 0; 
while ($row = mysqli_fetch_assoc($result_query)) {
    $cartitemid = $row['cartitemid'];
    $itemname = $row['itemname'];
    $itemprice = $row['itemprice'];
    $itemimage = $row['itemimage'];
    $itemdescription = $row['itemdescription'];
    
    if (!isset($cart_items[$itemname])) {
        $cart_items[$itemname] = [
            'itemprice' => $itemprice,
            'itemimage' => $itemimage,
            'itemdescription' => $itemdescription,
            'quantity' => 0,
            'cartitemids' => []
        ];
    }
    $cart_items[$itemname]['quantity']++;
    $cart_items[$itemname]['cartitemids'][] = $cartitemid;
    $total += $itemprice; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .logo {
            max-height: 50px; 
            width: auto;
        }
        .quantity-badge {
            position: absolute;
            top: 0px;
            right: 0px;
            background-color: black;
            color: white;
            border-radius: 50%;
            padding: 15px 20px;
            font-size: 19px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
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
        
        <div class="bg-light">
            <h3 class="text-center">Your Shopping Cart</h3>
            <p class="text-center">Review and manage your selected items</p>
        </div>
        <div class="row px-3">
        <?php
        foreach ($cart_items as $itemname => $details) {
            $itemprice = $details['itemprice'];
            $itemimage = $details['itemimage'];
            $itemdescription = $details['itemdescription'];
            $quantity = $details['quantity'];
            $cartitemids = $details['cartitemids'];
            $total_item_price = $itemprice * $quantity;

            echo "<div class='col-md-3 mb-2'>
                <div class='card' style='width: 18rem;'>
                    <img src='../adminarea/product_images/$itemimage' class='card-img-top' alt='$itemname'>
                    <div class='card-body'>
                        <h5 class='card-title'>$itemname</h5>
                        <p class='card-text'>$itemdescription</p>
                        <h5 class='card-title'>₹ $itemprice</h5>
                        <span class='quantity-badge'>✘$quantity</span>
                        <a href='./userscart.php?action=remove&cartitemid=" . urlencode($cartitemids[0]) . "' class='btn btn-dark'>Remove</a>
                    </div>
                </div>
            </div>";
        }
        ?>
        </div>
        <div class="row px-3">
            <div class="col-md-12">
                <div class="card bg-secondary text-white rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Subtotal</p>
                            <p class="mb-2">₹ <?php echo number_format($total, 2); ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <p class="mb-2">Total</p>
                            <p class="mb-2">₹ <?php echo number_format($total, 2); ?></p>
                        </div>
                        <hr class="my-4">
                        <form method="post" action="">
                            <button type="submit" name="checkout" class="btn btn-dark btn-block btn-lg">
                                <div class="d-flex justify-content-between">
                                    <span>₹ <?php echo number_format($total, 2); ?></span>
                                    <span>Checkout <i class="fa-solid fa-long-arrow-alt-right ms-2"></i></span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
