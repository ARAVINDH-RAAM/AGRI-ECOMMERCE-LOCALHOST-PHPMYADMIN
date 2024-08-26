<?php
include('../includes/connect.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_POST['register'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    if($firstname == '' || $lastname == '' || $email == '' || $password == ''){
        echo "<script>alert('Please fill all the fields')</script>";
        exit();
    } else {
        echo "<script>console.log('All fields are filled.');</script>";
       
        $select_query = "SELECT * FROM `admin` WHERE adminemail = '$email'";
        $selectquery_result = mysqli_query($con, $select_query);

        if (!$selectquery_result) {
            die("Error in select query: " . mysqli_error($con));
        }

        $count = mysqli_num_rows($selectquery_result);

        if($count > 0){
            echo "<script>alert('Already Registered with this email')</script>";
        } else {
            echo "<script>console.log('Email is not registered yet.');</script>";
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_user = "INSERT INTO `admin` (firstname, lastname, adminemail, adminpassword, date) 
                            VALUES ('$firstname', '$lastname', '$email', '$hashed_password', NOW())";
            $result_query = mysqli_query($con, $insert_user);

            if($result_query){
                echo "<script>alert('Registration Successful')</script>";
            } else {
                echo "<script>alert('Registration Failed: " . mysqli_error($con) . "')</script>";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
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
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../index.php">Products</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./adminlogin.php">Login</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=aravindat2003@gmail.com&su=Inquiry%20About%20Your%20Product&body=Hello,%20I%20would%20like%20more%20information%20about%20your%20product.">Contact</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
    </div>
    <h3 class="text-center mt-3 pt-1">Admin Registration</h3>
    <div class="container form-container">
    <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" name="firstname" class="form-control" id="inputFirstName" placeholder="First Name" required="required">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" name="lastname" class="form-control" id="inputLastName" placeholder="Last Name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" required="required">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required="required">
                </div>
            </div>
            
            <button type="submit" name="register" class="btn btn-primary" value="Submit">Register</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
