<?php
session_start();
$error = '';
$username = '';
$password = '';

if (isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $reg = json_decode(file_get_contents('user.json'), true);
    $match = array_keys(array_filter($reg, function ($u) use ($username) {
        return $u['username'] == $username;
    }));

    $id = isset($match[0]) ? $match[0] : null;
    if($id !== null){
        if(password_verify($password, $reg[$id]['password'])){
            $_SESSION['userid'] = $id;
            header("Location: index.php");
            exit;
        }
        else $_SESSION['loginerror'] = 2;
    } else $_SESSION['loginerror'] = 1;

    if (isset($_SESSION['loginerror'])) {
        if ($_SESSION['loginerror'] == 1) $error = "The username is invalid";
        else if ($_SESSION['loginerror'] == 2) $error = "The password is invalid";
        unset($_SESSION['loginerror']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>IK-Library | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
<div class="flex items-center justify-center mt-20" id="login">
    <form action="login.php" method="post">
        Login (user name) <br>
        <input class="mb-3 border-2" type="text" name="username" value="<?= $username ?>"> <br>
        Password <br>
        <input class="mb-3 border-2" type="password" name="password" value="<?= $password ?>"> <br>
        <button class="btn btn-primary mb-3" type="submit">Submit</button> <br>
        <a href="register.php" class="hover:underline">Register</a>
        <span style="color:red"><br><?= $error ?></span>
    </form>
</div>
</body>
</html>
