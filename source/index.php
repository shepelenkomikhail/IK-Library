<?php
session_start();
function loadBooksData() {
    return json_decode(file_get_contents("books.json"), true);
}

function loadUserData() {
    return json_decode(file_get_contents("user.json"), true);
}

$books = loadBooksData();
$userData = loadUserData();
$isAuthenticated = isset($_SESSION['userid']);
$userid = $_SESSION['userid'] ?? null;
$userrole = $_SESSION['role'] ?? null;

$input = $_GET;
$search = isset($input['search']) ? $input['search'] : '';
$info = isset($input['info']) ? $input['info'] : '';

$filteredBooks = [];
foreach ($books as $key => $book) {
    if (
        (empty($search) || stripos($book['title'], $search) !== false || stripos($book['author'], $search) !== false) &&
        (empty($info) || $book['genre'] == $info)
    ) {
        $filteredBooks[$key] = $book;
    }
}
foreach ($filteredBooks as $key => $book) {
    if (isset($book['feedbacks'])) {
        $totalRating = array_reduce($book['feedbacks'], function ($carry, $feedback) {
            return $carry + $feedback['rating'];
        }, 0);
        $averageRating = count($book['feedbacks']) > 0 ? $totalRating / count($book['feedbacks']) : 0;
        $filteredBooks[$key]['averageRating'] = $averageRating;
    } else {
        $filteredBooks[$key]['averageRating'] = 0;
    }
}


usort($filteredBooks, function($a, $b) {
    return $b['averageRating'] <=> $a['averageRating'];
});
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
    <?php if ($_SESSION['role'] === 'admin') : ?>
        <header class="flex justify-between">
            <h1><a href="index.php">IK-Library</a> > Home</h1>
            <h1 class="font-bold text-2xl">Welcome <a href="user.php?<?= $_SESSION['userid'] ?>"><?= $_SESSION['userid'] ?>!</a></h1>
            <div class="flex justify-end mr-5">
                <h1><a class="btn btn-primary mb-3 mr-3" href="user.php">Profile</a></h1>
                <h1><a class="btn btn-primary mb-3 mr-3" href="add.php">Add</a></h1>
                <h1><a class="btn btn-primary mb-3 mr-3" href="logout.php">Logout</a></h1>
            </div>
        </header>
        <div class="md:w-8/12 mx-auto p-3 ">
        <h2 class="mb-3 text-xl text-bold text-secondary">Filters and options (to list all books click Submit)</h2>
        <form action="index.php" method="get" class="grid lg:grid-cols-6 grid-cols-1 gap-3">
            <label class="input input-bordered flex items-center lg:col-span-2">
                <input type="text" class="grow border-2 rounded-l mr-3" placeholder="Search" name="search" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                     class="w-4 h-4 opacity-70">
                    <path fill-rule="evenodd"
                          d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                          clip-rule="evenodd" />
                </svg>
            </label>
            <select class="select select-bordered w-full" name="info">
                <option disabled selected>Filter by genre</option>
                <option value="Science Fiction">Science Fiction</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Adventure">Adventure</option>
            </select>
            <input type="submit" class="btn btn-primary w-full">
        </form>
        </div>
        <div id="content">
            <div id="card-list">

                <?php foreach ($filteredBooks as $key => $book): ?>
                    <div class="book-card">
                        <div class="image">
                            <img src="assets/<?= $book['image'] ?>" alt="">
                        </div>
                        <div class="details">
                            <h2><a href="details.php?id=book<?= $key ?>&usr=<?= $_SESSION['userid'] ?>"><?= $book['author'] ?> - <?= $book['title'] ?></a></h2>
                            <?php
                            if (isset($book['feedbacks']) && count($book['feedbacks']) > 0) {
                                $totalRating = array_reduce($book['feedbacks'], function ($carry, $feedback) {return $carry + $feedback['rating'];}, 0);
                                $averageRating = $totalRating / count($book['feedbacks']);
                                echo "<p>Average Rating: " . number_format($averageRating, 2) . "</p>";
                            } else {
                                echo "<p>Not yet graded!</p>";
                            }
                            ?>
                            <?php if (in_array("book" . $key, $userData[$userid]['read'] ?? [])): ?>
                                <span class="text-green-700 font-bold">Read</span>
                            <?php else: ?>
                                <a class="btn btn-primary mb-3" href="read.php?id=book<?= $key ?>">Mark as Read</a>
                            <?php endif; ?>
                        </div>
                        <a href="edit.php?id=book<?= $key ?>" class="edit">
                            <div>
                                <span>Edit</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php else: ?>
        <header class="flex justify-between">
            <h1><a href="index.php">IK-Library</a> > Home</h1>
            <h1 class="font-bold text-2xl">Welcome <a href="user.php?<?= $_SESSION['userid'] ?>"><?= $_SESSION['userid'] ?>!</a></h1>
            <div class="flex justify-end mr-5">
                <h1><a class="btn btn-primary mb-3 mr-3" href="user.php">Profile</a></h1>
                <h1><a class="btn btn-primary mb-3 mr-3" href="logout.php">Logout</a></h1>
            </div>
        </header>

        <div class="md:w-8/12 mx-auto p-3 ">
            <h2 class="mb-3 text-xl text-bold text-secondary">Filters and options (to list all books click Submit)</h2>
            <form action="index.php" method="get" class="grid lg:grid-cols-6 grid-cols-1 gap-3">
                <label class="input input-bordered flex items-center lg:col-span-2">
                    <input type="text" class="grow border-2 rounded-l mr-3" placeholder="Search" name="search" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                         class="w-4 h-4 opacity-70">
                        <path fill-rule="evenodd"
                              d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                              clip-rule="evenodd" />
                    </svg>
                </label>
                <select class="select select-bordered w-full" name="info">
                    <option disabled selected>Filter by genre</option>
                    <option value="Science Fiction">Science Fiction</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Adventure">Adventure</option>
                </select>
                <input type="submit" class="btn btn-primary w-full">
            </form>
        </div>
        <div id="content">
            <div id="card-list">

                <?php foreach ($filteredBooks as $key => $book): ?>
                    <div class="book-card">
                        <div class="image">
                            <img src="assets/<?= $book['image'] ?>" alt="">
                        </div>
                        <div class="details">
                            <h2><a href="details.php?id=book<?= $key ?>&usr=<?= $_SESSION['userid'] ?>"><?= $book['author'] ?> - <?= $book['title'] ?></a></h2>
                            <?php
                            if (isset($book['feedbacks']) && count($book['feedbacks']) > 0) {
                                $totalRating = array_reduce($book['feedbacks'], function ($carry, $feedback) {return $carry + $feedback['rating'];}, 0);
                                $averageRating = $totalRating / count($book['feedbacks']);
                                echo "<p>Average Rating: " . number_format($averageRating, 2) . "</p>";
                            } else {
                                echo "<p>Not yet graded!</p>";
                            }
                            ?>

                            <?php if (in_array("book" . $key, $userData[$userid]['read'] ?? [])): ?>
                                <span class="text-green-700 font-bold">Read</span>
                            <?php else: ?>
                                <a class="btn btn-primary mb-3" href="read.php?id=book<?= $key ?>">Mark as Read</a>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
<?php $_SESSION['role'] = 'guest';?>
    <header class="flex justify-between">
        <h1><a href="index.php">IK-Library</a> > Home</h1>
        <div class="flex justify-end mr-5">
            <h1><a class="btn btn-primary mb-3 mr-3" href="login.php">Login</a></h1>
            <h1><a class="btn btn-primary mb-3" href="register.php">Register</a></h1>
        </div>
    </header>
    <div class="md:w-8/12 mx-auto p-3 ">
        <h2 class="mb-3 text-xl text-bold text-secondary">Filters and options (to list all books click Submit)</h2>
        <form action="index.php" method="get" class="grid lg:grid-cols-6 grid-cols-1 gap-3">
            <label class="input input-bordered flex items-center lg:col-span-2">
                <input type="text" class="grow border-2 rounded-l mr-3" placeholder="Search" name="search" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                     class="w-4 h-4 opacity-70">
                    <path fill-rule="evenodd"
                          d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                          clip-rule="evenodd" />
                </svg>
            </label>
            <select class="select select-bordered w-full" name="info">
                <option disabled selected>Filter by genre</option>
                <option value="Science Fiction">Science Fiction</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Adventure">Adventure</option>
            </select>

            <input type="submit" class="btn btn-primary w-full">
        </form>
    </div>
    <div id="content">
        <div id="card-list">

            <?php foreach ($filteredBooks as $key => $book): ?>
                <div class="book-card">
                    <div class="image">
                        <img src="assets/<?= $book['image'] ?>" alt="">
                    </div>
                    <div class="details">
                        <h2><a href="details.php?id=book<?= $key ?>&usr=notlogged"><?= $book['author'] ?> - <?= $book['title'] ?></a></h2>
                        <?php
                        if (isset($book['feedbacks']) && count($book['feedbacks']) > 0) {
                            $totalRating = array_reduce($book['feedbacks'], function ($carry, $feedback) {return $carry + $feedback['rating'];}, 0);
                            $averageRating = $totalRating / count($book['feedbacks']);
                            echo "<p>Average Rating: " . number_format($averageRating, 2) . "</p>";
                        } else {
                            echo "<p>Not yet graded!</p>";
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
<?php endif; ?>
<footer>
    <p>IK-Library | ELTE IK Webprogramming</p>
</footer>
</body>

</html>
