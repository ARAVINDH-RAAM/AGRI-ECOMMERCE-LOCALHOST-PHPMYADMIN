<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a href="index.php"> <img src="../agrisiteimages/logo.jpg" alt="" class="logo"></a>
                <?php
if (isset($_SESSION['adminfirstname'])) {
    echo "<nav class='navbar navbar-expand-lg'>
    <ul class='navbar-nav'>
        <li class='nav-item'>
            <a class='nav-link text-light'>Welcome, " . htmlspecialchars($_SESSION['adminfirstname']) . "</a>
        </li>
    </ul>
    </nav>";
}else{
    echo "<nav class='navbar navbar-expand-lg'>
    <ul class='navbar-nav'>
        <li class='nav-item'>
            <a class='nav-link text-light'>Welcome Guest</a>
        </li>
    </ul>
    </nav>";
}
?>
            </div>
        </nav>

        <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>

        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-5">
                    <p class="text-light text-center">Admin Name</p>
                    <?php
                        echo "<p class='text-light text-center'>" . htmlspecialchars($_SESSION['adminfirstname']) . "</p>";
                    ?>
                    
                </div>
                <div class="button text-center">
                    <button class="m-3"><a href="admindashboard.php?insertproducts" class="nav-link text-secondary bg-light m-1 p-2">Insert Products</a></button>
                    <button class="m-3"><a href="admindashboard.php?adminproduct" class="nav-link text-secondary bg-light m-1 p-2">View Products</a></button>
                    <button class="m-3"><a href="admindashboard.php?alladmin" class="nav-link text-secondary bg-light m-1 p-2">All Admins</a></button>
                    <button class="m-3"><a href="admindashboard.php?adminaccinfo" class="nav-link text-secondary bg-light m-1 p-2">Admin Account Info</a></button>
                    <button class="m-3"><a href="admindashboard.php?allorders" class="nav-link text-secondary bg-light m-1 p-2">All Orders</a></button>
                    <button class="m-3"><a href="admindashboard.php?allusers" class="nav-link text-secondary bg-light m-1 p-2">List Users</a></button>
                    <?php
                        if (isset($_SESSION['adminfirstname'])) {
                            echo "<button class='m-3'><a href='../admin/adminlogout.php' class='nav-link text-secondary bg-light m-1 p-2'>Logout</a></button>";
                        }
                        else{
                            echo "<button class='m-3'><a href='../admin/adminlogin.php' class='nav-link text-secondary bg-light m-1 p-2'>Login</a></button>";
                        }
                    ?>
                    
                
                </div>
            </div>
        </div>

    </div>

    <div class="container">
        <?php
            if(isset($_GET['insertproducts']))
            {
                include('insertproducts.php');
            }
            if(isset($_GET['adminproduct']))
            {
                include('adminproduct.php');
            }
            if(isset($_GET['alladmin']))
            {
                include('alladmin.php');
            }
            if(isset($_GET['allusers']))
            {
                include('allusers.php');
            }
            if(isset($_GET['adminaccinfo']))
            {
                include('adminaccinfo.php');
            }
            if(isset($_GET['allorders']))
            {
                include('allorders.php');
            }
        ?>
    </div>

    <div class="bg-dark P-3 text-center">
        <p class="footertext">Done By: ARAVINDH RAAM</p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>