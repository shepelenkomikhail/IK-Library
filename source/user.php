<?php
session_start();
$usersData = json_decode(file_get_contents("user.json"), true);
$books = json_decode(file_get_contents("books.json"), true);
$currentUser = $_SESSION['userid'];

if (!isset($usersData[$currentUser])) {
    echo "User not found.";
    exit;
}
$user = $usersData[$currentUser];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body class="bg-gray-100">
<header class="flex justify-between">
    <h1><a href="index.php">IK-Library</a> > Profile</h1>
    <h1 class="font-bold text-2xl">Welcome <a href="user.php?<?= $_SESSION['userid'] ?>"><?= $_SESSION['userid'] ?>!</a></h1>
    <div class="flex justify-end mr-5">
        <h1><a class="btn btn-primary mb-3 mr-3" href="user.php">Profile</a></h1>
        <h1><a class="btn btn-primary mb-3 mr-3" href="logout.php">Logout</a></h1>
    </div>
</header>

<main class="flex flex-col items-center mt-10">
    <h2 class="mb-4 font-bold">User Name: <?= $user['username'] ?></h2>
    <p>Email: <?= $user['email'] ?></p>
    <p>Role: <?= $user['role'] ?></p>
    <p>Last Login: <?= $user['lastlog'] ?></p>
    <h3 class="mt-6 mb-2 font-bold">Read Books:</h3>
    <ul class="mb-4">
        <?php foreach ($user['read'] as $book): ?>
            <?php $book = $books[$book]['title'] ?>
            <li><?= $book ?></li>
        <?php endforeach; ?>
    </ul>
    <h3 class="mb-2 font-bold">Feedbacks:</h3>
    <ul>
        <?php foreach ($user['feedbacks'] as $feedback): ?>
            <li>
                <strong>Book ID:</strong> <?= $feedback['book_id'] ?><br>
                <strong>Rating:</strong> <?= $feedback['rating'] ?><br>
                <strong>Comment:</strong> <?= $feedback['comment'] ?>
            </li>
        <hr>
        <?php endforeach; ?>
    </ul>
</main>

<footer class="fixed bottom-0 w-full">
    IK-Library | ELTE IK Webprogramming
</footer>

</body>
</html>

