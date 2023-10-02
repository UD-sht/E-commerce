<?php 
include 'config.php';
if (isset($_POST['add_to_cart'])){
   $product_name= $_POST['product_name'];
   $product_price= $_POST['product_price'];
   $product_image= $_POST['product_image'];
   $product_quantity= 1;
   $select_cart=mysqli_query($conn, "select * from cart where name='$product_name'");
   if(mysqli_num_rows($select_cart)>0){
      $message[]='Product already added to cart';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO cart(name,price,image,quantity) VALUES
      ('$product_name','$product_price','$product_image','$product_quantity')");
   }
}
if (isset($_POST['add_to_wishlist'])){
   $product_name= $_POST['product_name'];
   $product_price= $_POST['product_price'];
   $product_image= $_POST['product_image'];
   $product_quantity= 1;
   $select_cart=mysqli_query($conn, "select * from wishlist where name='$product_name'");
   if(mysqli_num_rows($select_cart)>0){
      $message[]='Product already added to wishlist';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO wishlist(name,price,image,quantity) VALUES
      ('$product_name','$product_price','$product_image','$product_quantity')");
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>

<body>
   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
      }
   }
   ?>
   <div class="container">
      <section class="products">
         <h1 class="heading">latest products</h1>
               <div class="box-container">
                  <?php
                  $select_product= mysqli_query($conn, "SELECT * FROM product ");
                  if(mysqli_num_rows($select_product)>0){
                     while($fetch_product=mysqli_fetch_assoc($select_product)) {
                        
                  ?>
                        <form action="" method="post">
                           <div class="box">
                              <img width="300" height="300" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                              <h3>
                                 <?php echo $fetch_product['name']; ?>
                              </h3>
                              <div class="price">Rs.
                                 <?php echo $fetch_product['price']; ?>/-
                              </div>
                              <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                              <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                              <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                              <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                              <input type="submit" class="btn" value="add to wishlist" name="add_to_wishlist">
                           </div>
                        </form>
                  <?php
                     }
                  }
                  ?>
               </div>
               <div >
            <a href="mycart.php" class="btn">Cart</a>
            <a href="wishlist.php" class="btn">Wishlist</a>
         </div>
            </section>
   </div>