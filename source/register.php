<?php
$data = json_decode(file_get_contents("user.json"), true);

$errors = [];
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$passwordCheck = $_POST['passwordCheck'] ?? '';
$hashedPassword = '';

if(count($_POST) > 0) {
    $errors = [];
    if (!isset($username)) {
        $errors['username'] = 'Name field is required!';
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $errors['username'] = 'Name must be between 3 and 20 characters long!';
    } elseif (preg_match('/\s/', $username)) {
        $errors['username'] = 'Name cannot contain whitespace!';
    } else {
        foreach ($data as $users) {
            if ($username === $users['username']) {
                $errors['username'] = 'Name is not free!';
                break;
            }
        }
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = 'The e-mail address is not valid';

    if(!isset($password))
        $errors['password'] = 'Password field is required!';
    else if($password !== $passwordCheck)
        $errors['passwordCheck'] = 'Passwords do not match! ';
    else
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $errors = array_map(function ($e) {
        return "<span style='color: red'> <br> $e </span>";
    }, $errors);

    if(count($errors) == 0){
        $reg = json_decode(file_get_contents("user.json"),true);
        $reg[$username] = [
            'username' => $username,
            'password' => $hashedPassword,
            'email' => $email,
            'role' => 'user'
        ];
        file_put_contents('user.json',json_encode($reg,JSON_PRETTY_PRINT));

        session_start();
        $_SESSION['userid'] = $username;
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
    <title>Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="flex items-center justify-center mt-20" id="reg">
    <form action="register.php" method="post">
        <p class="font-bold">Please, fill the following fields to register!</p>
        User name <br>
        <input class="mb-3 border-2" type="text" name="username" value="<?= $username ?>"> <?= $errors['username'] ?? '' ?> <br>
        Email <br>
        <input  class="mb-3 border-2" type="text" name="email" value="<?= $email ?>"> <?= $errors['email'] ?? '' ?><br>
        Password <br>
        <input class="mb-3 border-2" type="password" name="password" value="<?= $password ?>"> <?= $errors['password'] ?? '' ?><br>
        Repeat password <br>
        <input class="mb-3 border-2" type="password" name="passwordCheck" value="<?= $passwordCheck ?>"> <?= $errors['passwordCheck'] ?? '' ?><br>
        <button class="btn btn-primary mb-3" type="submit">Register</button><br>
        <a href="index.php" class="hover:underline">Back to Home</a><br>
        <?php if(count($_POST) > 0 && count($errors) == 0): ?>
            <span style="color: green; font-weight: bold;">Successfully saved!</span><br>
        <?php endif; ?>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>