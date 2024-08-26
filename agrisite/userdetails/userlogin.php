<?php

include('../includes/connect.php');

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['loginemail']);
    $password = $_POST['password'];

    $select_query = "SELECT * FROM `user` WHERE email = '$email'";
    $result_query = mysqli_query($con, $select_query);

    if (!$result_query) {
        die('Error: ' . mysqli_error($con));
    }

    if (mysqli_num_rows($result_query) > 0) {
        $row = mysqli_fetch_assoc($result_query);
        $db_password = $row['password'];

        if (password_verify($password, $db_password)) {
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['date'] = $row['date'];

            $userid = mysqli_real_escape_string($con, $_SESSION['userid']);
            $cart_query = "SELECT COUNT(*) AS total_quantity FROM `cartitems` WHERE `useridfk` = '$userid'";
            $cart_result = mysqli_query($con, $cart_query);

            if (!$cart_result) {
                die('Error: ' . mysqli_error($con));
            }

            $row_countforcart = mysqli_fetch_assoc($cart_result);
            $_SESSION['cartquantity'] = $row_countforcart['total_quantity'];

            echo "<script>alert('Login Successful! Welcome " . $_SESSION['firstname'] . "');</script>";

            header("Location: ../index.php");
            exit();
        } else {
          
            echo "<script>alert('Incorrect Password');</script>";
        }
    } else {
       
        echo "<script>alert('Email not found');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        
        .form-container {
            max-width: 600px;
            margin: 20px auto; 
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-row {
            margin-bottom: 15px; 
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            margin-top: 10px; 
        }

        .navbar .logo {
            max-height: 50px;
        }

        .navbar {
            margin-bottom: 20px; 
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
    </div>
    <h3 class="text-center mt-3 pt-1">User Login</h3>
    <div class="container form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row mb-3">
                <div class="form-group col-md-6">
                    <label for="inputEmail">Email</label>
                    <input type="email" name="loginemail" class="form-control" id="inputEmail" placeholder="Email" required="required">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required="required">
                </div>
            </div>
            <div class="button-container">
                <button type="submit" name="login" class="btn btn-secondary px-2 mx-1" style="width: 100px;" value="Submit">Login</button>
                <a class="btn btn-bg" href="./userregistration.php">New User</a>

            </div>
        </form>
    </div>









    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
