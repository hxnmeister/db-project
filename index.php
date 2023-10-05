<?php 
    require_once './connect.php';
    require_once './Message.php';
    use db\Message;
    session_start();
?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <title>Database SQL</title>
        </head>
        <body>
            <h1>CRUD authors</h1>

            <?php
                Message::show();
                
                if(isset($_POST['add']))
                {
                    $name = $_POST['name'] ?? '';

                    if(empty($name))
                    {
                        header('Location: ./create-author.php');
                    }
                    else
                    {
                        // $stmt = $pdo->prepare("insert into authors(name) values (?)"); 
                        // $stmt->execute([$name]);

                        $stmt = $pdo->prepare("insert into authors(name) values (:name)");
                        $stmt->execute(['name' => $name]);

                        header('Location: ./index.php');
                    }
                }
                elseif(isset($_POST['delete']))
                {
                    $stmt = $pdo->prepare("delete from authors where id=:authorId");
                    $stmt->execute(['authorId' => $_GET['id']]);
                }

                $stmt = $pdo->query('select * from authors');
                $authors = $stmt->fetchAll();

                // echo '<pre>'.print_r($stmt, true).'</pre>';
                // echo '<pre>'.print_r($authors, true).'</pre>';
            ?>

            <div class="container">
                <a href="create-author.php">Create</a>

                <table class="table">
                    <?php foreach($authors as $author): ?>
                        <tr>
                            <td><?= $author->id ?></td>
                            <td><?= $author->name ?></td>
                            <td><?php array_map(function($title) { echo $title; },$pdo->query('select title from books where author_id='.$author->id)->fetchAll(PDO::FETCH_COLUMN))?></td>
                            <td class="float-end d-flex">
                                <a href="./edit-author.php?id=" class="btn btn-outline-secondary me-1">
                                    <img src="./images/edit-icon.png" alt="edit"> 
                                </a>
                                <form action="./index.php?id=<?= $author->id ?>" method="post">
                                    <button class="btn btn-outline-danger" name="delete">
                                        <img src="./images/delete-icon.png" alt="delete">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </body>
    </html>