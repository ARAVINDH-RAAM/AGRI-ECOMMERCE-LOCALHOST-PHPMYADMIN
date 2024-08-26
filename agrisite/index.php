<?php
session_start();

include('./includes/connect.php');


$cartquantity = isset($_SESSION['cartquantity']) ? $_SESSION['cartquantity'] : 0;

$searchvalue = '';
$search_results = [];
$searchPerformed = false;

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $searchvalue = mysqli_real_escape_string($con, $_POST['search']);
    $searchPerformed = true; 

    $select_queryforsearch = "SELECT * FROM `products` WHERE `product_title` LIKE '%$searchvalue%' ORDER BY `product_title`";
    $result_queryforsearch = mysqli_query($con, $select_queryforsearch);

    if ($result_queryforsearch) {
        while ($rowforsearch = mysqli_fetch_assoc($result_queryforsearch)) {
            $search_results[] = $rowforsearch;
        }
    } else {
        echo "Error: " . mysqli_error($con);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agri E-Commerce Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='//fonts.googleapis.com/css?family=Signika+Negative:300,400,600' rel='stylesheet' type='text/css'>
    
    <style>
        * {
  box-sizing: border-box;
}

.body {
  padding: 0;
  margin: 0;
  font-family: "Montserrat", sans-serif;
  font-weight: 300;
  height: 70vh;
  overflow: hidden;
  background-color: #f5f5f5; 
  margin-bottom: 10px;
  margin-top: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container {
  display: flex;
  height: 100%;
  width: 100%;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

.container.grid, .container.columns {
  align-content: stretch;
  align-items: stretch;
  flex-wrap: wrap;
}

.letter {
  text-align: center;
  color: #333; 
  font-size: 10vmax;
  font-weight: 400;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2px 6px;
}

.container.grid .letter {
  flex-basis: 50%;
}

.container.columns .letter {
  flex-basis: 25%;
}

.for, .gsap {
  font-size: 5vmax;
  color: #333; 
}

.for {
  padding: 2px 1.6vmax;
  font-weight: 300;
  display: none;
}

.gsap {
  padding: 2px 0;
  font-weight: 600;
  display: none;
}

.container.final .for, .container.final .gsap {
  display: block;
}

.F {
  background: #a2d9a2; 
}

.l {
  background: #c1e1c1; 
}

.i {
  background: #a2c2e2; 
}

.p {
  background: #e2c1e2; 
}

.container.plain .letter {
  background: transparent;
  color: #333; 
  padding: 0;
}

.logo {
  position: relative;
  width: 70px;
  margin: auto;
  padding: 2px;
}
nav.searchandlogo {
    position: sticky;
    top: 0;
    z-index: 1000;
  }
  html, body {
    height: 100%;
    margin: 0;
}
.content {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.footer {
    margin-top: auto;
}
.footertext{
    color: white;
}

    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark searchandlogo">
            <div class="container-fluid">
                <img src="./agrisiteimages/logo.jpg" alt="logo" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#product" id="scrollLink">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart/orderconfirmation.php">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="userdetails/userregistration.php">Register</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=aravindat2003@gmail.com&su=Inquiry%20About%20Your%20Product&body=Hello,%20I%20would%20like%20more%20information%20about%20your%20product." target="_blank">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href='./cart/userscart.php'><i class='fa-solid fa-cart-plus'></i>
                            <sup><?php echo $cartquantity; ?></sup>
                            </a>
                        </li>
                    </ul>
                    <form action="" method="post" enctype="multipart/form-data" class="d-flex">
                        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search" value="<?php echo htmlspecialchars($searchvalue); ?>">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <ul class="navbar-nav me-auto">
        <?php
        if (isset($_SESSION['firstname'])) {
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="#">Welcome, ' . htmlspecialchars($_SESSION['firstname']) . '</a>';
            echo '</li>';
        } else {
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="#">Welcome Guest User</a>';
            echo '</li>';
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="userdetails/userlogin.php">Login</a>';
            echo '</li>';
        }
        ?>
    </ul>
    <ul class="navbar-nav ms-auto">
        <?php
        if (isset($_SESSION['firstname'])) {
            echo '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ACCOUNT
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="userdetails/userinformation.php">My Account</a></li>
                    <li><a class="dropdown-item" href="cart/userscart.php">My Cart</a></li>
                    <li><a class="dropdown-item" href="cart/orderconfirmation.php">My Orders</a></li>
                    <li><a class="dropdown-item" href="userdetails/logout.php">Logout</a></li>
                </ul>
            </li>';
        }
        ?>
    </ul>
</nav>

        <div class="bg-light">
            <h3 class="text-center">Welcome to our Store!!!</h3>
            <p class="text-center">Discover a wide range of Agricultural Products</p>
        </div>


        <div class="body">
<div class="container final body">
	<div class="letter F">A</div>
	<div class="letter l">G</div>
	<div class="letter i">R</div>
	<div class="letter p">I</div>
	<div class="for">E-Commerce</div>
	<div class="gsap">SITE</div>
</div>
</div>


        <div class="row px-5 my-5" id="product">
        <?php
            if (empty($search_results)) {
                echo "<h3 class='text-center mt-5 pt-4'>No products found !!</h3>";
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
                    $product_id = $product['product_id'];
                    $product_title = $product['product_title'];
                    $product_description = $product['product_description'];
                    $product_image1 = $product['product_image1'];
                    $product_price = $product['product_price'];
                    
                    echo "
<div class='col-md-3 px-4 mb-5'>
    <div class='card' style='width: 18rem; height: 30rem; overflow: hidden;'>
        <a href='./cart/productinfo.php?id=$product_id' class='text-decoration-none text-dark'>
            <img src='./adminarea/product_images/$product_image1' class='card-img-top' alt='$product_title' style='height: 12rem; object-fit: cover;'>
            <div class='card-body'>
                <h5 class='card-title text-truncate'>$product_title</h5>
                <p class='card-text' style='max-height: 6rem; overflow: hidden; text-overflow: ellipsis;'>$product_description</p>
            </div>
        </a>
        <div class='card-body d-flex justify-content'>
            <a href='./cart/productinfo.php?id=$product_id' class='btn btn-outline-secondary' style='height: 2.5rem; width: 45%;'>Add to Cart</a>
        </div>
    </div>
</div>
";



                }
            }
            ?>
        </div>
    </div>
    <div class="bg-dark P-3 text-center">
        <p class="footertext">Done By: ARAVINDH RAAM</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <script src='https://assets.codepen.io/16327/gsap-latest-beta.min.js'></script>
    <script src='https://assets.codepen.io/16327/Flip.min.js'></script><script  src="./script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchPerformed = '<?php echo !empty($searchvalue) ? 'true' : 'false'; ?>';
    if (searchPerformed === 'true') {
        const productSection = document.getElementById('product');
        if (productSection) {
            productSection.scrollIntoView(true);
        }
    }
});


  document.getElementById("scrollLink").addEventListener("click", function(e) {
    e.preventDefault(); 

    const target = document.getElementById("product");
    const navbarHeight = document.querySelector('.navbar').offsetHeight; 
    
    window.scrollTo({
      top: target.offsetTop - navbarHeight, 
      behavior: "smooth" 
    });
  });
</script>

</body>
</html>
