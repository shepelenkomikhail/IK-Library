<?php
session_start();
$json = file_get_contents("books.json");
$books = json_decode($json, true);
$userData = json_decode(file_get_contents("user.json"), true);
$isAuthenticated = isset($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>IK-Library | Home</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
<?php if ($isAuthenticated) : ?>
    <?php if($_SESSION['userid'] === 'admin') : ?>
        <header class="flex justify-between">
            <h1><a href="index.php">IK-Library</a> > Home</h1>
            <h1 class="font-bold text-2xl">Welcome <a href="user.php?<?=$_SESSION['userid']?>"><?=$_SESSION['userid']?>!</a></h1>
            <div class=" flex justify-end mr-5">
                <h1><a class="btn btn-primary mb-3 mr-3" href="add.php">Add</a></h1>
                <h1><a class="btn btn-primary mb-3 mr-3" href="logout.php">Logout</a></h1>
            </div>
        </header>
        <div id="content">
            <div id="card-list">

                <?php foreach ($books as $key => $book):?>
                    <div class="book-card">
                        <div class="image">
                            <img src="assets/<?=$book['image'] ?>" alt="">
                        </div>
                        <div class="details">
                            <h2><a href="details.php?id=<?=$key?>&usr=<?= $_SESSION['userid']?>"><?= $book['author']?> - <?= $book['title']?></a></h2>
                        </div>
                        <a href="edit.php?id=<?=$key?>" class="edit">
                            <div>
                                <span>Edit</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    <?php else: ?>
        <header class="flex justify-between">
            <h1><a href="index.php">IK-Library</a> > Home</h1>
            <div class=" flex justify-end mr-5">
                <h1><a class="btn btn-primary mb-3 mr-3" href="logout.php">Logout</a></h1>
            </div>
        </header>

        <div id="content">
            <div id="card-list">

                <?php foreach ($books as $key => $book):?>
                    <div class="book-card">
                        <div class="image">
                            <img src="assets/<?=$book['image'] ?>" alt="">
                        </div>
                        <div class="details">
                            <h2><a href="details.php?id=<?=$key?>&usr=<?= $_SESSION['userid']?>"><?= $book['author']?> - <?= $book['title']?></a></h2>
                        </div>

                    </div>
                <?php endforeach;?>

            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <header class="flex justify-between">
        <h1><a href="index.php">IK-Library</a> > Home</h1>
        <div class=" flex justify-end mr-5">
            <h1><a class="btn btn-primary mb-3 mr-3" href="login.php">Login</a></h1>
            <h1><a class="btn btn-primary mb-3" href="register.php">Register</a></h1>
        </div>
    </header>

    <div id="content">
        <div id="card-list">

            <?php foreach ($books as $key => $book):?>
                <div class="book-card">
                    <div class="image">
                        <img src="assets/<?=$book['image'] ?>" alt="">
                    </div>
                    <div class="details">
                        <h2><a href="details.php?id=<?=$key?>&usr=notlogged"><?= $book['author']?> - <?= $book['title']?></a></h2>
                    </div>

                </div>
            <?php endforeach;?>

        </div>
    </div>
<?php endif; ?>
    <footer>
        <p>IK-Library | ELTE IK Webprogramming</p>
    </footer>
</body>

</html>