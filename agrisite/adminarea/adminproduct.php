<?php

session_start();

include('../includes/connect.php');
$searchvalue = '';
$search_results = [];

if (!isset($_SESSION['adminfirstname'])) {
    header("Location: ../admin/adminlogin.php"); 
    exit();
}

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $searchvalue = mysqli_real_escape_string($con, $_POST['search']);
    
    $select_queryforsearch = "SELECT * FROM `products` WHERE `product_title` LIKE '%$searchvalue%' ORDER BY `product_title`";
    $result_queryforsearch = mysqli_query($con, $select_queryforsearch);
    
    if ($result_queryforsearch) {
        while ($rowforsearch = mysqli_fetch_assoc($result_queryforsearch)) {
            $search_results[] = $rowforsearch;
        }
    } else {
        echo "<h1>No product found</h1>";
    }
} else {
    $select_query = "SELECT * FROM `products` ORDER BY RAND()";
    $result_query = mysqli_query($con, $select_query);
    
    if ($result_query) {
        while ($row = mysqli_fetch_assoc($result_query)) {
            $search_results[] = $row;
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if (isset($_GET['removeproduct'])) {
    $product_id = $_GET['removeproduct'];

    $query = "SELECT product_image1, product_image2, product_image3 FROM `products` WHERE product_id='$product_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $image1 = $row['product_image1'];
        $image2 = $row['product_image2'];
        $image3 = $row['product_image3'];

        $upload_dir = realpath(__DIR__ . '/../adminarea/product_images/') . '/';

        if (file_exists($upload_dir . $image1)) {
            unlink($upload_dir . $image1);
        }
        if (file_exists($upload_dir . $image2)) {
            unlink($upload_dir . $image2);
        }
        if (file_exists($upload_dir . $image3)) {
            unlink($upload_dir . $image3);
        }

        $delete_query = "DELETE FROM `products` WHERE product_id='$product_id'";
        if (mysqli_query($con, $delete_query)) {
            echo "<script>alert('Product deleted successfully')</script>";
            header("Location: ../adminarea/admindashboard.php"); 
            exit();
        } else {
            echo "<script>alert('Error deleting product: " . mysqli_error($con) . "')</script>";
        }
    } else {
        echo "<script>alert('Error fetching product details: " . mysqli_error($con) . "')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agri E-Commerce Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            
            <form action="" method="post" class="d-flex">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search" value="<?php echo htmlspecialchars($searchvalue); ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <?php
            if (empty($search_results)) {
                echo "<h3 class='text-center mt-5 pt-4'>No products found!</h3>";
                echo "
                <div class='container mt-2'>
                    <div class='row justify-content-center'>
                        <div class='col-auto'>
                            <a href='index.php' class='btn btn-outline-secondary btn-lg'>Go to Home</a>
                        </div>
                    </div>
                </div>
                ";
            } else {
                foreach ($search_results as $product) {
                    $product_id = htmlspecialchars($product['product_id']);
                    $product_title = htmlspecialchars($product['product_title']);
                    $product_description = htmlspecialchars($product['product_description']);
                    $product_image1 = htmlspecialchars($product['product_image1']);
                    $product_price = htmlspecialchars($product['product_price']);
                    
                    echo "<div class='col-md-3 mb-4'>
                        <div class='card' style='width: 18rem;'>
                            <img src='product_images/$product_image1' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_description</p>
                                <a href='adminproduct.php?removeproduct=$product_id' class='btn btn-danger'>Remove</a>
                            </div>
                        </div>
                    </div>";
                }
            }
            ?>
        </div>
    </div>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
