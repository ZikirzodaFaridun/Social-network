<?php
// Check if the form data was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name'])) {
    // Get the name from the POST request
    $name = htmlspecialchars(trim($_POST['name'])); // Sanitize input
    echo "<h1>Hello, $name!</h1>";
    echo "<p>Thank you for submitting your name.</p>";
} else {
    // If accessed directly, redirect back to index.html
    header("Location: index.html");
    exit;
}
?>
