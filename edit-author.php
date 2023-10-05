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
            <title>Edit Author</title>
        </head>
        <body>
            <h1>Editing Page</h1>
            <div class="container">
                <?php
                    Message::show();

                    $authorId = $_GET['id'] ?? -1;

                    if(isset($_POST['edited-name']))
                    {
                        $editedName = strip_tags(trim($_POST['edited-name'])) ?? '';

                        if(empty($editedName))
                        {
                            Message::set('Name cannot be empty!', 'danger');
                            header("Location: ./edit-author.php?id=$authorId");
                        }
                        elseif(preg_match('/^[A-Za-z\s`]+$/', $editedName))
                        {
                            $stmt = $pdo->prepare("update authors set name=:editedName where id=:authorId");
                            $stmt->execute(['editedName' => $editedName, 'authorId' => $authorId]);

                            Message::set('The changes have been applied!');
                            header('Location: ./index.php');
                        }
                        else
                        {
                            Message::set('Changes have not been applied!', 'danger');
                            header("Location: ./edit-author.php?id=$authorId");
                        }
                    }

                    if($authorId < 0):
                        echo "<h2>Hello, this page is currently empty =(</h2>";
                        echo "<h3>Interesting how did you get here <img src=\"./images/thinking-face-icon.png\"></h3>";
                    else:
                ?>
                    <form method="post">
                        <input type="text" name="edited-name" class="form-control">
                        <button class="btn btn-outline-success mt-3">Confirm</button>
                    </form>
                <?php
                    endif;
                ?>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </body>
    </html>
