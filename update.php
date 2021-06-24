<?php
$id = '';
$get_id = '';
$imagename = '';

$errors = [];
include_once("connection.php");
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$products = $statement->fetch();


$title = $products['title'];
$description = $products['description'];
$price = $products['price'];
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
    <h1>Update Product <b><?php echo $products['title'] ?></b></h1>
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
            <textarea class="form-control" name="description" value="<?php echo $description ?>"></textarea>
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
    $image = isset($_FILES['image']);
    // if ($title === "") {
    //     array_push($errors, 'Need to Write Title');
    // }

    // if (!$price) {
    //     array_push($errors, 'Need to Write price');
    // }
    // if (!is_dir('MYimages')) {
    //     mkdir('MYimages');
    // }


    // if ($image) {
    //     if ($products['image']) {
    //         unlink($products['image']);
    //     }
    //     $imagename = 'MYimages/' . randomString(5) . '/' . $image['name'];
    //     mkdir(dirname($imagename));
    //     move_uploaded_file($image['tmp_name'], $imagename);
    // }

    // if (empty($errors)) {

    // $imagename = $products['image'];

    // if ($image && $image['tmp_name']) {

    //     if ($products['image']) {
    //         unlink($products['image']);
    //     }
    //     $imagename = '';

    //     $imagename = 'MYimages/' . randomstring(5) . '/' . $image['name'];
    //     mkdir(dirname($imagename));
    //     move_uploaded_file($image['tmp_name'], $imagename);
    // }
    // $statement = $pdo->prepare("UPDATE `products` (title, image, description, price)
    // VALUES(:title, :image, :description, :price) WHERE `:id`=$id");
    // echo $id;
    // die;
    $statement = $pdo->prepare("UPDATE `products` SET `title` = :title, `description` = :description, `price` = :price WHERE `id` = :id ");
    // print_r($statement);
    // die;
    $statement->bindValue(':title', $title);
    //$statement->bindValue(':image', $imagename);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':id', $get_id);


    $statement->execute();
    // header("Location: http://localhost/Project_training/front_page.php");
}
// }



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