<?php
session_start();
include('../includes/connect.php'); 

if (isset($_GET['removeuser'])) {
    
    $userid = mysqli_real_escape_string($con, $_SESSION['userid']);
    
    $delete_cart_query = "DELETE FROM `cartitems` WHERE `useridfk` = '$userid'";
    $cart_result = mysqli_query($con, $delete_cart_query);
    
    if ($cart_result) {
        
        $delete_user_query = "DELETE FROM `user` WHERE `userid` = '$userid'";
        $user_result = mysqli_query($con, $delete_user_query);

        if ($user_result) {
            
            session_destroy();
            echo "<script>alert('Account deleted successfully.'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Error deleting account: " . mysqli_error($con) . "'); window.location.href='userinformation.php';</script>";
        }
    } else {
        echo "<script>alert('Error deleting cart items: " . mysqli_error($con) . "'); window.location.href='userinformation.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar .logo {
            max-height: 50px; 
        }

        .navbar {
            margin-bottom: 20px; 
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
<div class="card text-center my-10">
  <div class="card-header">
    Welcome To Our Store
  </div>
  <div class="card-body">
    <h5 class="card-title">User Details</h5>
    <?php
        echo '<p class="card-text">First Name: ' . htmlspecialchars($_SESSION['firstname']) . '</p>';
        echo '<p class="card-text">Last Name: ' . htmlspecialchars($_SESSION['lastname']) . '</p>';
        echo '<p class="card-text">E-mail: ' . htmlspecialchars($_SESSION['email']) . '</p>';
        echo '<p class="card-text">Registered On: ' . htmlspecialchars($_SESSION['date']) . '</p>';
    ?>
    <a href="#" class="btn btn-danger" onclick="confirmDelete()">Remove Account</a>
  </div>
  <div class="card-footer text-muted">
    <a href="../index.php"><p>Go To Home</p></a>
  </div>
</div>

<script>
function confirmDelete() {
    if (confirm("Are you sure you want to delete your account?")) {
        window.location.href = "userinformation.php?removeuser";
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
