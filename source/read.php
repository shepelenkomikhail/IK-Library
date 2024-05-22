<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}

$bookId = $_GET['id'] ?? null;
$userId = $_SESSION['userid'];

if ($bookId) {
    $userData = json_decode(file_get_contents("user.json"), true);

    if (isset($userData[$userId])) {
        if (!in_array($bookId, $userData[$userId]['read'])) {
            $userData[$userId]['read'][] = $bookId;
            file_put_contents("user.json", json_encode($userData, JSON_PRETTY_PRINT));
        }
    }

    header('Location: index.php');
    exit;
} else {
    echo "Invalid book ID.";
}
?>
