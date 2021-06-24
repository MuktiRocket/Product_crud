<?php

include_once("connection.php");


$id = $_POST['id'];

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$products = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" integrity="undefined" crossorigin="anonymous">
    <style>
        body {
            padding: 50px;
        }


        .image {
            width: 350px;
        }

        .heading {
            text-align: center;
        }

        .form {
            text-align: center;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <h1 class=heading>Product Details</h1>

    <br><br>

    <form action="" method="POST" enctype="multipart/form-data" class="form">
        <div class=" form-group">

            <?php if ($products['image']) { ?>
                <img src="<?php echo $products['image'] ?>" class="image">
            <?php } ?>
            <br>
            <label>Product Image</label>
            <br>
            <br>
            <br>
            <div class="form-group">
                <label>Product Title</label><br>
                <label><b><?php echo $products['title'] ?></b></label>
                <br>
                <div class="form-group">
                    <label>Product Description</label><br>
                    <label><b><?php echo $products['description'] ?></b></label>
                </div><br>
                <div class="form-group">
                    <label>Product Price</label><br>
                    <label><b><?php echo 'Rs. ' . $products['price'] ?></b></label>
                </div>
                <br>
                <a href="front_page.php" class="btn btn-primary pull-right">Back</a>

    </form>

</body>

</html>