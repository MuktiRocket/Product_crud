<?php
$id = '';
$get_id = '';
$imagename = '';
$image = '';
$description = '';
$errors = [];
$newimage = '';
$count = 0;
include_once("connection.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$products = $statement->fetch();


$title = $products['title'];
$description = $products['description'];
$price = $products['price'];
$newimage = $products['image'];

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
            width: 240px;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <h1>Update Product <b><?php echo $title ?></b></h1>
    <?php
    if (!empty($errors)) { ?>
        <?php
        foreach ($errors as $key) { ?>

            <div class="alert alert-danger"><?php echo $key ?></div>

        <?php } ?>
        </div>
    <?php }
    ?>
    <p>
        <a href="front_page.php" class="btn btn-sm btn-outline-danger">Back To Products</a>
    </p>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?> " method="POST" enctype="multipart/form-data">
        <div class=" form-group">
            <input type="hidden" class="form-control" name="get_id" value="<?php echo $id ?>">
            <?php if ($products['image']) { ?>
                <img src="<?php echo $products['image'] ?>" class="image">
            <?php } ?>
            <br>
            <label>Product Image</label>
            <br>
            <input type="file" name="image">

            <br>
        </div>
        <br>
        <div class="form-group">
            <label>Product Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
        </div>
        <br>
        <div class="form-group">
            <label>Product Description</label>
            <textarea class="form-control" name="description"><?php echo $description ?></textarea>
        </div><br>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" step=".01" class="form-control" name="price" value="<?php echo $price ?>">
            <span id="price"></span>
        </div>
        <br>
        <button type="submit" class="btn btn-success" name="sumbit">Submit</button>
        <br><br>

    </form>

</body>

</html>




<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
    }
    if (isset($_POST['get_id'])) {
        $get_id = $_POST['get_id'];
    }
    if (isset($_POST['description'])) {
        $description = $_POST['description'];
    }
    if (isset($_POST['price'])) {
        $price = $_POST['price'];
    }
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
    }


    if ($title === "") {
        array_push($errors, 'Need to Write Title');
    }

    if (!$price) {
        array_push($errors, 'Need to Write price');
    }


    if (empty($errors)) {
        $imagename = $products['image'];

        if (!empty($image['name'])) {
            $catchimage = $image['name'];
            print_r($catchimage);

            $imagename = 'xyz/' . $catchimage;
            move_uploaded_file($image['tmp_name'], $imagename);
        } else {

            $statement = $pdo->prepare("UPDATE `products` SET `title` = :title, `description` = :description, `price` = :price WHERE `id` = :id ");
            $statement->bindValue(':title', $title);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':id', $get_id);
            $statement->execute();

            $imagename = $newimage;

            header("Location: front_page.php");
            die;
        }


        $statement = $pdo->prepare("UPDATE `products` SET `title` = :title, `description` = :description, `price` = :price, `image`= :image WHERE `id` = :id ");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagename);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $get_id);
        $statement->execute();


        header("Location: front_page.php");
    }
}



function randomstring($n)
{
    $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($char) - 1);
        $str .= $char[$index];
    }
    return $str;
}
?>