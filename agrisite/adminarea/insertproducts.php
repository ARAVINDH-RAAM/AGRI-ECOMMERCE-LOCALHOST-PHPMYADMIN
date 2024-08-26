<?php
include('../includes/connect.php');
session_start();

if (!isset($_SESSION['adminfirstname'])) {
    header("Location: ../admin/adminlogin.php"); 
    exit();
}
if(isset($_POST['insertproduct'])){
    $product_title = $_POST['product_title'];
    $product_description = $_POST['description'];
    $product_keywords = $_POST['keywords'];
    $product_price = $_POST['price'];
    $product_status = 'true';

    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];

    $tempimage1 = $_FILES['image1']['tmp_name'];
    $tempimage2 = $_FILES['image2']['tmp_name'];
    $tempimage3 = $_FILES['image3']['tmp_name'];

    if($product_title=='' or $product_description=='' or $product_keywords=='' or $product_price=='' or $image1 == '' or $image2 == '' or $image3 == ''){
        echo "<script>alert('Please fill all the fields')</script>";
        exit();
    }
    else{
        move_uploaded_file($tempimage1,"./product_images/$image1");
        move_uploaded_file($tempimage2,"./product_images/$image2");
        move_uploaded_file($tempimage3,"./product_images/$image3");

        $insert_products="insert into `products` (product_title,product_description,product_keywords,product_image1,product_image2,product_image3,product_price,date,status) values ('$product_title','$product_description','$product_keywords','$image1','$image2','$image3','$product_price',NOW(),'$product_status')";
        $result_query = mysqli_query($con,$insert_products);
        if($result_query){
            echo "<script>alert('Data Added Successfully')</script>";
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
</head>
<body class>
    <div class="container mt-3">
        <h1 class="text-center ">Insert Products</h1>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter Product Name" autocomplete="off" required="required">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Enter Description" autocomplete="off" required="required">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="keywords" class="form-label">Product Keyword</label>
                <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Enter Product Keyword" autocomplete="off" required="required">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="image1" class="form-label">Product Image1</label>
                <input type="file" name="image1" id="image1" class="form-control" required="required">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="image2" class="form-label">Product Image2</label>
                <input type="file" name="image2" id="image2" class="form-control" required="required">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="image3" class="form-label">Product Image3</label>
                <input type="file" name="image3" id="image3" class="form-control" required="required">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="price" class="form-label">Product Price</label>
                <input type="text" name="price" id="price" class="form-control" placeholder="Enter Product Price" autocomplete="off" required="required">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insertproduct" class="btn btn-dark" value = "Submit">
            </div>

        </form>
    </div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>