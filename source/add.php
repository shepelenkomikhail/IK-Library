<?php
$booksData = json_decode(file_get_contents("books.json"), true);

$errors = [];
$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$description = $_POST['description'] ?? '';
$year = $_POST['year'] ?? '';
$image = $_POST['image'] ?? '';
$planet = $_POST['planet'] ?? '';
$genre = $_POST['genre'] ?? '';

if(count($_POST) > 0) {
    $errors = [];

    if (!isset($title) || trim($title) === '') {
        $errors['title'] = 'Title field is required!';
    }

    if (!isset($author) || trim($author) === '') {
        $errors['author'] = 'Author field is required!';
    }

    if (!isset($description) || trim($description) === '') {
        $errors['description'] = 'Description field is required!';
    }

    if (!isset($year) || trim($year) === '' || !is_numeric($year)) {
        $errors['year'] = 'Year must be a valid number!';
    }

    if (!isset($image) || trim($image) === '') {
        $errors['image'] = 'Image field is required!';
    }

    if (!isset($planet) || trim($planet) === '') {
        $errors['planet'] = 'Planet field is required!';
    }

    if (!isset($genre)) {
        $errors['genre'] = 'Genre field is required!';
    }

    $errors = array_map(function ($e) {
        return "<span style='color: red'> <br> $e </span>";
    }, $errors);

    if(count($errors) == 0){
        $books = json_decode(file_get_contents("books.json"),true);
        $bookId = 'book' . count($books);
        $books[$bookId] = [
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'year' => (int)$year,
            'image' => $image,
            'planet' => $planet,
            'genre' => $genre,
            'feedbacks' => []
        ];
        file_put_contents('books.json',json_encode($books,JSON_PRETTY_PRINT));

        $title = '';
        $author = '';
        $description = '';
        $year = '';
        $image = '';
        $planet = '';
        $genre = '';

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Add New Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="flex items-center justify-center mt-20" id="reg">
    <form action="add.php" method="post">
        <p class="font-bold">Please, fill the following fields to add a new book!</p>
        Title <br>
        <input class="mb-3 border-2" type="text" name="title" value="<?= $title ?>"> <?= $errors['title'] ?? '' ?> <br>
        Author <br>
        <input  class="mb-3 border-2" type="text" name="author" value="<?= $author ?>"> <?= $errors['author'] ?? '' ?><br>
        Description <br>
        <textarea class="mb-3 border-2" name="description"><?= $description ?></textarea> <?= $errors['description'] ?? '' ?><br>
        Year <br>
        <input class="mb-3 border-2" type="text" name="year" value="<?= $year ?>"> <?= $errors['year'] ?? '' ?><br>
        Image <br>
        <select class="mb-3 border-2" name="image">
            <option value="book_cover_1.png">book_cover_1.png</option>
            <option value="book_cover_2.png">book_cover_2.png</option>
            <option value="book_cover_3.png">book_cover_3.png</option>
            <option value="book_cover_4.png">book_cover_4.png</option>
            <option value="book_cover_5.png">book_cover_5.png</option>
            <option value="book_cover_6.png">book_cover_6.png</option>
        </select>
        <?= $errors['image'] ?? '' ?><br>
        Genre <br>
        <select class="mb-3 border-2" name="genre">
            <option value="Science Fiction" <?= ($genre == 'Science Fiction') ? 'selected' : '' ?>>Science Fiction</option>
            <option value="Fantasy" <?= ($genre == 'Fantasy') ? 'selected' : '' ?>>Fantasy</option>
            <option value="Adventure" <?= ($genre == 'Adventure') ? 'selected' : '' ?>>Adventure</option>
        </select>
        <?= $errors['genre'] ?? '' ?><br>
        Planet <br>
        <input class="mb-3 border-2" type="text" name="planet" value="<?= $planet ?>"> <?= $errors['planet'] ?? '' ?><br>
        <button class="btn btn-primary mb-3" type="submit">Add Book</button><br>
        <a href="index.php" class="hover:underline">Back to Home</a><br>
        <?php if(count($_POST) > 0 && count($errors) == 0): ?>
            <span style="color: green; font-weight: bold;">Successfully added!</span><br>
        <?php endif; ?>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
