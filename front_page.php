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

        .imagesize {
            width: 75px;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <h1>products CRUD</h1>
    <p>
        <a href="create.php" class="btn btn-lg btn-success">Create Product</a>
    </p>
    <form action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search For Products" name="search" value="<?php $search = '';
                                                                                                            echo $search ?>">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>
    <a href="front_page.php" style="display: inline-block;" class="btn btn-outline-secondary">Reset</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Create Date</th>
                <th scope="col">Action </th>

            </tr>
        </thead>
        <tbody>
            <?php
            include_once('connection.php');
            $search = $_GET['search'] ?? '';
            if ($search) {
                $statement = $pdo->prepare("SELECT * FROM products WHERE title LIKE :title ORDER BY price , create_date DESC");
                $statement->bindValue(':title', "%$search%");
            } else {
                $statement = $pdo->prepare("SELECT * FROM products ORDER BY price , create_date DESC");
                $statement->execute();
            }
            $i = 1;
            $statement->execute();
            $product = $statement->fetchAll();
            foreach ($product as $key) { ?>
                <tr>
                    <div id="iterate_<?php $i ?>">
                        <th scope="row"><?php echo $i++ ?></th>


                        <td><img src="<?php echo $key['image'] ?>" class="imagesize"></td>


                        <td><?php echo $key['title'] ?></td>


                        <td><?php echo 'Rs. ' . $key['price'] ?></td>


                        <td><?php $dateTime = explode('-', $key['create_date']);
                            $uploadDate =  explode(' ', $dateTime[2]);
                            $inDays = date('d') - $uploadDate[0];
                            if ($inDays == 0) {
                                echo 'Today';
                            } else {
                                echo $inDays . ' days ago';
                            }
                            ?></td>


                        <td>
                            <form action="view.php" style="display: inline-block;" method="POST">
                                <input type="hidden" name="id" value="<?php echo $key['id'] ?>">
                                <button type="submit" class="btn btn-success">View</button>
                            </form>

                            <form action="update.php" style="display: inline-block;" method="GET">
                                <input type="hidden" name="id" value="<?php echo $key['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success">Edit</button>
                            </form>

                            <form action="delete.php" style="display: inline-block;" method="POST">
                                <input type="hidden" name="id" value="<?php echo $key['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>

                    </div>
                </tr>

            <?php }
            ?>

        </tbody>
    </table>

</body>

</html>