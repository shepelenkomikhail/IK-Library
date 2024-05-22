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

if(count($_POST) > 0) {
    $errors = [];

    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';
    $year = $_POST['year'] ?? '';
    $image = $_POST['image'] ?? '';
    $planet = $_POST['planet'] ?? '';

    if(trim($title) === '')
        $errors['title'] = 'Title field is required!';

    if(trim($author) === '')
        $errors['author'] = 'Author field is required!';

    if(trim($description) === '')
        $errors['description'] = 'Description field is required!';

    if(trim($year) === '' || !is_numeric($year))
        $errors['year'] = 'Year must be a valid number!';

    if(trim($image) === '')
        $errors['image'] = 'Image field is required!';

    if(trim($planet) === '')
        $errors['planet'] = 'Planet field is required!';

    if(count($errors) == 0){
        $booksData[$id] = [
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'year' => (int)$year,
            'image' => $image,
            'planet' => $planet
        ];

        file_put_contents('books.json', json_encode($booksData, JSON_PRETTY_PRINT));

        header("Location: index.php");
        exit;
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
        <input  class="mb-3 border-2" type="text" name="author" value="<?= $author ?>"> <?= $errors['author'] ?? '' ?><br>
        Description <br>
        <textarea class="mb-3 border-2" name="description"><?= $description ?></textarea> <?= $errors['description'] ?? '' ?><br>
        Year <br>
        <input class="mb-3 border-2" type="text" name="year" value="<?= $year ?>"> <?= $errors['year'] ?? '' ?><br>
        Image <br>
        <input class="mb-3 border-2" type="text" name="image" value="<?= $image ?>"> <?= $errors['image'] ?? '' ?><br>
        Planet <br>
        <input class="mb-3 border-2" type="text" name="planet" value="<?= $planet ?>"> <?= $errors['planet'] ?? '' ?><br>
        <button class="btn btn-primary mb-3" type="submit">Update Book</button><br>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
