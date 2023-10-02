<!--
CREATE TABLE `order` (`
id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` varchar(255) NOT NULL, 
`number` varchar(10) NOT NULL,
`email` varchar(255) NOT NULL, 
`method` varchar(255) NOT NULL, 
`house_no` varchar(255) NOT NULL,
`street` varchar(100) NOT NULL,
`city` varchar(100) NOT NULL,
`state` varchar(100) NOT NULL,
`country` varchar(100) NOT NULL,
`pin_code` int(100) NOT NULL,
`total_products` varchar(255) NOT NULL, 
`total_price` varchar(255) NOT NULL);
-->
<?php
@include 'config.php';
if (isset($_POST['order_btn'])) {
   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $house_no = $_POST['house_no'];
   $city = $_POST['city'];
   $street = $_POST['street'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM cart");
   $total_price = 0;
   if (mysqli_num_rows($cart_query) > 0) {
      while ($product_item = mysqli_fetch_assoc($cart_query)) {
         $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ') ';
         $product_price = $product_item['price'] * $product_item['quantity'];
         $total_price += $product_price;
      }
   }
   $total_products = implode(', ', $product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, house_no, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$house_no','$street','$city','$state','$country','$pin_code','$total_products','$total_price')");
   if ($cart_query && $detail_query) {
      echo "
   <div class='order-message-container'>
   <div class='message-container'>
      <h3>thank you for shopping!</h3>
      <div class='order-detail'>
         <span>" . $total_products . "</span>
         <span class='total'> total : $" . $total_price . "/-  </span>
      </div>
      <div class='customer-details'>
         <p> your name : <span>" . $name . "</span> </p>
         <p> your number : <span>" . $number . "</span> </p>
         <p> your email : <span>" . $email . "</span> </p>
         <p> your address : <span>" . $house_no . ", " . $city . ", " . $country . " - " . $pin_code . "</span> </p>
         <p> your payment mode : <span>" . $method . "</span> </p>
      </div>
      <a href='esewa.php' class='btn'>Pay</a>
         <a href='checkout.php' class='btn'>continue shopping</a>
      </div>
   </div>
   ";
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>

<body>
   <div class="container">
      <section class="checkout-form">
         <h1 class="heading">complete your order</h1>
         <form action="" method="post">
            <div class="display-order">
               <?php
               $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
               $total = 0;
               $grand_total = 0;
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                     $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                     $grand_total = $total += $total_price;
                     ?>
                     <span>
                        <?= $fetch_cart['name']; ?>(
                        <?= $fetch_cart['quantity']; ?>)
                     </span>
                     <?php
                  }
               } else {
                  echo "<div class='display-order'><span>your cart is empty!</span></div>";
               }
               ?>
               <span class="grand-total"> grand total : $
                  <?= $grand_total; ?>/-
               </span>
            </div>
            <div class="flex">
               <div class="inputBox">
                  <span>your name</span>
                  <input type="text" placeholder="Name" name="name" required>
               </div>
               <div class="inputBox">
                  <span>your number</span>
                  <input type="number" placeholder="Phone Number" name="number" required>
               </div>
               <div class="inputBox">
                  <span>your email</span>
                  <input type="email" placeholder="Email" name="email" required>
               </div>
               <div class="inputBox">
                  <span>payment method</span>
                  <select name="method">
                     <option value="cash on delivery" selected>cash on devlivery</option>
                     <option value="credit cart">credit cart</option>
                     <option value="esewa">esewa</option>
                  </select>
               </div>
               <div class="inputBox">
                  <span>House Number</span>
                  <input type="text" placeholder="" name="house_no" required>
               </div>
               <div class="inputBox">
                  <span>City</span>
                  <input type="text" placeholder="" name="city" required>
               </div>
               <div class="inputBox">
                  <span>Street</span>
                  <input type="text" placeholder="" name="street" required>
               </div>
               <div class="inputBox">
                  <span>State</span>
                  <input type="text" placeholder="" name="state" required>
               </div>
               <div class="inputBox">
                  <span>country</span>
                  <input type="text" placeholder="" name="country" required>
               </div>
               <div class="inputBox">
                  <span>pin code</span>
                  <input type="text" placeholder="" name="pin_code" required>
               </div>
            </div>
            <input type="submit" value="order now" name="order_btn" class="btn">
         </form>
      </section>
   </div>
   <!-- custom js file link  -->
   <script src="script.js"></script>
</body>

</html>