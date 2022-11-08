<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <title id="title">Category</title>
    <link rel = "icon" href ="img/logo.jpg" type = "image/x-icon">
    <style>
    html {
        background-color: #00cccc;
        color: #FFFFFF;
    }

    .jumbotron {
        padding: 2rem 1rem;
    }
    #container {
        min-height : 570px;
    }
    </style>
</head>
<body>
<div class="bg-image" style="background-image:url(img/background.png);height: 1600px;">
    <?php include 'customers/header.php';?>
    <?php include 'customers/navbar.php' ?>

    <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE categorieId = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['categorieName'];
            $catdesc = $row['categorieDesc'];
        }
    ?>
  
    <div class="container my-3" id="container"><br>
        <div class="col-lg-4 text-center my-3" style="margin:auto;">     
            <h2 class="text-center" style="color: #000000;"><span id="catTitle">Items</span></h2><br>
        </div>
        <div class="row"><br>
        <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `product` WHERE productCategorieId = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $productId = $row['productId'];
                $productName = $row['productName'];
                $productPrice = $row['productPrice'];
                $productDesc = $row['productDesc'];
            
                echo '<div class="col-sm-3 col-md-4">
                        <div class="card mx-2" style="width: 10cm;">
                            <img src="img/product-'.$productId. '.png" class="card-img-top" alt="Reload this page" width="249px" height="270px">
                            <div class="card-body ">
                                <h5 class="card-title">' . substr($productName, 0, 20). '...</h5>
                                <h6 style="color: #ff0000">MYR. '.$productPrice. '/-</h6>
                                <p class="card-text">' . substr($productDesc, 0, 29). '...</p>   
                                <div class="row justify-content-center">';
                                if($loggedin){
                                    $quaSql = "SELECT `itemQuantity` FROM `viewcart` WHERE productId = '$productId' AND `userId`='$userId'";
                                    $quaresult = mysqli_query($conn, $quaSql);
                                    $quaExistRows = mysqli_num_rows($quaresult);
                                    if($quaExistRows == 0) {
                                        echo '<form action="customers/manageCart.php" method="POST">
                                              <input type="hidden" name="itemId" value="'.$productId. '">
                                              <button type="submit" name="addToCart" class="btn btn-primary mx-2">Add to Cart</button>';
                                    }else {
                                        echo '<a href="viewCart.php"><button class="btn btn-primary mx-2">Go to Cart</button></a>';
                                    }
                                }
                                else{
                                    echo '<button class="btn btn-primary mx-2" data-toggle="modal" data-target="#loginModal">Add to Cart</button>';
                                }
                            echo '</form>                            
                                <a href="viewproduct.php?productid=' . $productId . '" class="mx-2"><button class="btn btn-primary">Quick View</button></a> 
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            if($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <p class="display-4">Sorry, Wrong page/category.</p>
                    </div>
                </div> ';
            }
            ?>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>         
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
    <script> 
        document.getElementById("title").innerHTML = "<?php echo $catname; ?>"; 
        document.getElementById("catTitle").innerHTML = "<?php echo $catname; ?>"; 
    </script>

</div>
</body>
</html>