
<?php
require("mysqli_connect.php");
session_start();
if(!isset($_GET["bid"])){
    if(!$_SESSION["bid"]){
        echo "<br>Session not set!!!!<br>";
    }
  }
else{
    $_SESSION["bid"] =  $_GET["bid"];
// echo "<br>Session set<br>";

$SESSION_ID = intval($_SESSION['bid']);

if($_SERVER['REQUEST_METHOD'] =='POST'){

    if(empty($_POST["cname"]) || empty($_POST["Contact"]) || empty($_POST["Email"]) || empty($_POST["Cardnum"])) {

        echo "<span style='color:red; font-size:2em'>Please fill all fields!!</span>";
    }
    else{
        $customer_name= $_POST["cname"];
        $Contact= $_POST["Contact"];
        $Email= $_POST["Email"];
        $Cardnum= $_POST["Cardnum"];
            // insert customer details----------------------------------------------------

     $customer_data=" INSERT INTO `customers`(`customer_id`, `customer_name`, `email`, `contact_number`,`card_number`)
      VALUES (null,'$customer_name','$Email','$Contact','$Cardnum')";
      $resultcustomer_data = @mysqli_query($dbc, $customer_data);
      $last_id = mysqli_insert_id($dbc);
    //   echo $last_id;
    // Get book details----------------------------------------------------
    
        $Order = "SELECT * FROM bookinventory WHERE product_id = {$SESSION_ID}";
        $getorder = @mysqli_query($dbc, $Order);
        $rows = @mysqli_fetch_array($getorder);
        $product_id = $rows["product_id"];
        $product_name = $rows["name"];
      
    // Insert in Order Table---------------------------------------------
            $invenorderQuery = "INSERT INTO bookinventoryorder (order_id, product_id,customer_id) 
            VALUES (null,'{$product_id}','{$last_id}')";

        $order_item = @mysqli_query($dbc,$invenorderQuery);
        $orderedItem = @mysqli_fetch_array($order_item);

        echo "  <br><b><span style='color:red;font-size:2em'>Your Order Book Name - ". $product_name ." is Booked !!</span>";
    // Update Quantiy of particular item in bookinventory table-----------------
        $updateQuery = "UPDATE bookinventory SET quantity = quantity - 1 WHERE product_id= {$SESSION_ID}";
        $update_table = @mysqli_query($dbc, $updateQuery);

        unset ($_SESSION['bid']);
        session_destroy();

    }
}
}   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Checkout</title>
</head>
<H1>Checkout Form</H1>
<body>
    <form role="form" action= "checkout.php?bid=<?php echo $SESSION_ID ;?>" method="post">
        <div class="form-group row">
            <label for="inputname" class="col-sm-2 col-form-label">customer name</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="" name="cname" placeholder="customer name">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputcontact" class="col-sm-2 col-form-label">Contact</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="" name="Contact" placeholder="Contact">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-4">
                <input type="email" class="form-control" id="" name="Email" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputcardnum" class="col-sm-2 col-form-label">Card Number</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="" name="Cardnum" placeholder="card number" maxlength="12">
            </div>
        </div>
        <div class="form-group row">
        <div class="offset-sm-2 col-sm-4 text-center">
          <input type="submit" value="Buy" name="submit" class="btn btn-primary"/>
        </div>
      </div>
       
    </form>


</body>
</html>
