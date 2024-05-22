<?php
session_start();
$booksData = json_decode(file_get_contents("books.json"), true);
$errors = [];
$bookId = $_GET['id'] ?? null;
$usr = $_GET['usr'] ?? null;

$rating = $_POST['rating'] ?? '';
$comment = $_POST['comment'] ?? '';

if(count($_POST) > 0){
    $errors = [];
    if(!isset($rating)) {
        $errors[] = "Rating is required.";
    }

    if(!isset($comment)) {
        $errors[] = "Comment is required.";
    }

    if($rating < 1 || $rating > 5) {
        $errors[] = "Rating should be between 1 and 5.";
    }

    if(count($errors) == 0) {
        $feedback = [
            'rating' => $rating,
            'comment' => $comment
        ];

        $booksData[$bookId]['feedbacks'][] = $feedback;
        file_put_contents('books.json', json_encode($booksData, JSON_PRETTY_PRINT));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>IK-Library | Details</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
<header>
    <h1><a href="index.php">IK-Library</a> > Details</h1>
</header>

<div id="content">
    <div id="card-list">

        <?php foreach ($booksData as $key => $book):?>
            <?php if($bookId === $key):?>
                <div class="book-card w-2/3">
                    <div class="image">
                        <img src="assets/<?=$book['image'] ?>" alt="">
                    </div>
                    <div class="details">
                        <h2 class="font-bold"><?= $book['author']?> - <?= $book['title']?></h2>
                        <p><?= $book['description']?></p>
                        <div class="flex flex-col mt-3">
                            <span class="font-bold">Year: <?= $book['year']?></span>
                            <span class="font-bold">Planet: <?= $book['planet']?></span>
                            <?php if(isset($book['feedbacks']) && !empty($book['feedbacks'])): ?>
                                <div class="feedbacks">
                                    <h3>Feedbacks:</h3>
                                    <ul>
                                        <?php foreach($book['feedbacks'] as $feedback): ?>
                                            <li>Rating: <?= $feedback['rating'] ?> - <?= $feedback['comment'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php
                                    $totalRating = array_reduce($book['feedbacks'], function($carry, $feedback) {
                                        return $carry + $feedback['rating'];
                                    }, 0);
                                    $averageRating = $totalRating / count($book['feedbacks']);
                                    ?>
                                    <p>Average Rating: <?= number_format($averageRating, 2) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($usr === 'admin'):?>
                        <a href="edit.php?id=<?=$key?>" class="edit">
                            <div>
                                <span>Edit</span>
                            </div>
                        </a>
                    <?php elseif($usr !== 'notlogged'):?>
                        <form action="details.php" method="post" class="mt-4 flex flex-col">
                            <label for="rating">Rating (1-5):</label>
                            <input class="border-2" type="number" name="rating" id="rating" min="1" max="5">

                            <label for="comment">Comment:</label>
                            <textarea class="border-2" name="comment" id="comment" rows="3" required></textarea>

                            <input class="border-2" type="hidden" name="book_id" value="<?= $key ?>">
                            <button class="btn btn-primary m-3" type="submit">Submit Feedback</button>

                            <?php if(count($_POST) > 0 && count($errors) == 0): ?>
                                <?php foreach($errors as $error): ?>
                                    <span style="color: red; font-weight: bold;"><?= $error ?></span><br>
                                <?php endforeach; ?>
                            <?php else:?>
                                <span style="color: green; font-weight: bold;">Successfully added!</span><br>
                            <?php endif; ?>
                        </form>
                    <?php endif;?>
                </div>
            <?php endif;?>
        <?php endforeach;?>

    </div>
</div>
<footer>
    <p>IK-Library | ELTE IK Webprogramming</p>
</footer>
</body>

</html>
