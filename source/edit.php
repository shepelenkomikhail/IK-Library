<?php
$booksData = json_decode(file_get_contents("books.json"), true);

$errors = [];
$id = $_GET['id'] ?? '';
$title = $booksData[$id]['title'] ?? '';
$author = $booksData[$id]['author'] ?? '';
$description = $booksData[$id]['description'] ?? '';
$year = $booksData[$id]['year'] ?? '';
$image = $booksData[$id]['image'] ?? '';
$planet = $booksData[$id]['planet'] ?? '';
$genre = $booksData[$id]['genre'] ?? '';

if(count($_POST) > 0) {
    $errors = [];

    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';
    $year = $_POST['year'] ?? '';
    $image = $_POST['image'] ?? '';
    $planet = $_POST['planet'] ?? '';
    $genre = $_POST['genre'] ?? '';

    if(!isset($title))
        $errors['title'] = 'Title field is required!';

    if(!isset($author))
        $errors['author'] = 'Author field is required!';

    if(!isset($description))
        $errors['description'] = 'Description field is required!';

    if(!isset($year) || !is_numeric($year))
        $errors['year'] = 'Year must be a valid number!';

    if(!isset($image))
        $errors['image'] = 'Image field is required!';

    if(!isset($planet))
        $errors['planet'] = 'Planet field is required!';

    if(!isset($genre))
        $errors['genre'] = 'Genre field is required!';


    if(count($errors) == 0){
        $booksData[$id] = [
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'year' => (int)$year,
            'image' => $image,
            'planet' => $planet,
            'genre' => $genre
        ];

        file_put_contents('books.json', json_encode($booksData, JSON_PRETTY_PRINT));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Edit Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="flex items-center justify-center mt-20" id="reg">
    <form action="edit.php?id=<?= $id ?>" method="post">
        <p class="font-bold">Edit Book</p>
        Title <br>
        <input class="mb-3 border-2" type="text" name="title" value="<?= $title ?>"> <?= $errors['title'] ?? '' ?> <br>
        Author <br>
        <input class="mb-3 border-2" type="text" name="author" value="<?= $author ?>"> <?= $errors['author'] ?? '' ?><br>
        Description <br>
        <textarea class="mb-3 border-2" name="description"><?= $description ?></textarea> <?= $errors['description'] ?? '' ?><br>
        Year <br>
        <input class="mb-3 border-2" type="text" name="year" value="<?= $year ?>"> <?= $errors['year'] ?? '' ?><br>
        Image <br>
        <input class="mb-3 border-2" type="text" name="image" value="<?= $image ?>"> <?= $errors['image'] ?? '' ?><br>
        Planet <br>
        <input class="mb-3 border-2" type="text" name="planet" value="<?= $planet ?>"> <?= $errors['planet'] ?? '' ?><br>
        Genre <br>
        <select class="mb-3 border-2" name="genre">
            <option value="Science Fiction" <?= ($genre == 'Science Fiction') ? 'selected' : '' ?>>Science Fiction</option>
            <option value="Fantasy" <?= ($genre == 'Fantasy') ? 'selected' : '' ?>>Fantasy</option>
            <option value="Adventure" <?= ($genre == 'Adventure') ? 'selected' : '' ?>>Adventure</option>
        </select>
        <?= $errors['genre'] ?? '' ?><br>
        <a href="index.php" class="hover:underline">Back to Home</a><br>
        <button class="btn btn-primary mb-3" type="submit">Update Book</button><br>

        <?php if(count($_POST) > 0 && count($errors) == 0): ?>
            <span style="color: green; font-weight: bold;">Successfully saved!</span><br>
        <?php endif; ?>

    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
