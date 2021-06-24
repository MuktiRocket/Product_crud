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
    </style>
    <title>Document</title>
</head>

<body>
    <h1>Create new Product</h1>



    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
        <div class=" form-group">
            <label>Product Image</label>
            <br>
            <input type="file" name="image">
        </div>
        <br>
        <div class="form-group">
            <label>Product Title</label>
            <input type="text" class="form-control" name="title">
        </div>
        <br>
        <div class="form-group">
            <label>Product Description</label>
            <textarea class="form-control" name="description"></textarea>
        </div><br>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" step=".01" class="form-control" name="price">
        </div><br>
        <div class="form-group">
            <label>Product Status</label>
            <input type="text" class="form-control" name="status"><br>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="sumbit">Submit</button>

    </form>
    <br>
    <a href="front_page.php"><button class="btn btn-secondary pull-right">Back</button></a>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include_once('connection.php');
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $date = date('Y-m-d H-i-s');
        $errors = [];
        $image = '';



        if ($title === "") {
            array_push($errors, 'Need to Write Title');
        }

        if (!$price) {
            array_push($errors, 'Need to Write price');
        }
        if (!is_dir('MYimages')) {
            mkdir('MYimages');
        }

        if (empty($errors)) {
            $imagename = '';
            $image = $_FILES['image'] ?? null;

            if ($image && $image['tmp_name']) {
                $imagename = 'MYimages/' . randomstring(5) . '/' . $image['name'];
                mkdir(dirname($imagename));
                move_uploaded_file($image['tmp_name'], $imagename);
            }

            $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
        VALUES(:title, :image, :description, :price, :date)");
            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $imagename);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', $date);
            $statement->execute();

            header("Location: http://localhost/Project_training/front_page.php");
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
    <?php
    if (!empty($errors)) { ?>
        <?php
        foreach ($errors as $key) { ?>

            <div class="alert alert-danger"><?php echo $key ?></div>

        <?php } ?>
        </div>
    <?php }
    ?>
</body>

</html>