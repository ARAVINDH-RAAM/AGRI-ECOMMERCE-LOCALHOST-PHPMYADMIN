<?php
include('../includes/connect.php');
session_start();

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$product_title = $product_description = $product_image1 = $product_price = '';

if ($product_id > 0) {
  
    $query = "SELECT * FROM `products` WHERE `product_id` = $product_id";
    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $product_title = $product['product_title'];
        $product_description = $product['product_description'];
        $product_image1 = $product['product_image1'];
        $product_price = $product['product_price'];

    } else {
        echo "<p>Product not found!</p>";
        exit;
    }
} else {
    echo "<p>Invalid product ID!</p>";
    exit;
}
$item_added = false;
if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];

        $insert_query = "INSERT INTO cartitems (itemname, itemprice, itemimage, itemdescription, useridfk) 
                         VALUES ('$product_title', '$product_price', '$product_image1', '$product_description','$userid')";
        
        if (mysqli_query($con, $insert_query)) {
            $item_added = true;
            $userid = mysqli_real_escape_string($con, $_SESSION['userid']);
            $cart_query = "SELECT COUNT(*) AS total_quantity FROM `cartitems` WHERE `useridfk` = '$userid'";
            $cart_result = mysqli_query($con, $cart_query);

            if (!$cart_result) {
                die('Error: ' . mysqli_error($con));
            }

            $row_countforcart = mysqli_fetch_assoc($cart_result);
            $_SESSION['cartquantity'] = $row_countforcart['total_quantity'];

        } else {
            echo "<p>Error adding item to cart: " . mysqli_error($con) . "</p>";
        }
    } else {
        header("Location: ../userdetails/userlogin.php"); 
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product_title); ?> - Product Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
    <style>
        .card-img-wrapper {
            width: 640px; 
            height: 360px; 
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
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

    <div class="container mt-5 py-5">
        <div class="row">
            <div class="col-md-6">
                
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1750" data-bs-pause="hover">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <div class="card-img-wrapper">
                            <img src="../adminarea/product_images/<?php echo htmlspecialchars($product_image1); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($product_title); ?>">
                        </div>
                        </div>
                        <?php if ($product['product_image2']): ?>
                            <div class="carousel-item">
                            <div class="card-img-wrapper">
                                <img src="../adminarea/product_images/<?php echo htmlspecialchars($product['product_image2']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($product_title); ?>">
                            </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($product['product_image3']): ?>
                            <div class="carousel-item">
                            <div class="card-img-wrapper">
                                <img src="../adminarea/product_images/<?php echo htmlspecialchars($product['product_image3']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($product_title); ?>">
                        </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product_title); ?></h1>
                <p class="lead"><?php echo htmlspecialchars($product_description); ?></p>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($product_price); ?></p>
                <div class="d-flex">
                    <form method="post">
                        <?php if (isset($_SESSION['firstname'])){
                                echo "<button type='submit' name='add_to_cart' class='btn btn-dark me-2'>Add to Cart</button>";
                        }else{
                            echo "<a href='../userdetails/userlogin.php' class='btn btn-dark me-2'>Add to Cart</a>";
                        }
                        ?>
                            
                        
                    </form>
                    
                    <a href="../index.php" class="btn btn-secondary me-2">Shop More</a>
                    <?php 
                    if($item_added){
                        echo "<a href='./userscart.php' class='btn btn-secondary'>Go to Cart</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
