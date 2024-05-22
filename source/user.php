<?php
// Assuming you have user data, reviews, and books data available in $userData, $userReviews, and $userBooks respectively
// You can adjust the structure according to your actual data

// Start session if not already started
session_start();

// Sample user data
$userData = [
    'username' => $_SESSION['userid'],
    'email' => 'user@example.com', // Sample email, replace with actual data
    'role' => 'user' // Sample role, replace with actual data
];

// Sample user reviews
$userReviews = [
    ['book_title' => 'Book 1', 'rating' => 4, 'review' => 'Great book!'],
    ['book_title' => 'Book 2', 'rating' => 5, 'review' => 'Amazing read!'],
    // Add more reviews here if available
];

// Sample books user has read
$userBooks = [
    'Book 1',
    'Book 2',
    'Book 3'
    // Add more books here if available
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container">
    <h1 class="font-bold text-2xl">Welcome <?= $userData['username'] ?>!</h1>
    <div class="user-data">
        <h2>User Data</h2>
        <p><strong>Username:</strong> <?= $userData['username'] ?></p>
        <p><strong>Email:</strong> <?= $userData['email'] ?></p>
        <p><strong>Role:</strong> <?= $userData['role'] ?></p>
    </div>

    <!-- Display user reviews -->
    <div class="user-reviews">
        <h2>User Reviews</h2>
        <?php foreach ($userReviews as $review): ?>
            <div class="review">
                <h3><?= $review['book_title'] ?></h3>
                <p><strong>Rating:</strong> <?= $review['rating'] ?></p>
                <p><strong>Review:</strong> <?= $review['review'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="user-books">
        <h2>Books Read</h2>
        <ul>
            <?php foreach ($userBooks as $book): ?>
                <li><?= $book ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
</body>
</html>
