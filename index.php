<?php
require('mysqli_connect.php');
session_start();
$query = "SELECT * FROM bookinventory";
$result = @mysqli_query($dbc, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Book Store</title>
</head>
<body>
    <main>
        <div class="row">
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <div class="col-md-3 single-book-in-grid">
                    <img src='uploads/<?php echo $row['image']; ?>' width="100" height="100">
                    <h3>
                        <?php echo $row['name']; ?>
                    </h3>
                    <p>
                        <?php echo $row['detail']; ?>
                    </p>
                    <p> <?php echo $row['price']; ?></p>
                    <p><?php echo $row['quantity']; ?></p>
                    <a href='checkout.php?bid=<?php echo $row['product_id']; ?>'>
                        Add to Cart</a>
                </div>
            <?php   }
            ?>
        </div>
    </main>
</body>
</html>