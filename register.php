<?php
// Create (or open if it already exists) the SQLite database
$db = new SQLite3('users.db');

// Create the "users" table if it does not exist
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT
)");

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Username and password are required. <a href='register.html'>Go back</a>";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to insert the user data
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);

    // Execute the statement and check for errors
    try {
        $stmt->execute();
        echo "Registration successful! Go back to <a href='index.html'>Home Page</a>.";
    } catch (Exception $e) {
        if ($db->lastErrorCode() == 19) { // Unique constraint violation code in SQLite
            echo "Username already exists. <a href='register.html'>Try a different username</a>";
        } else {
            echo "An error occurred. Please try again. <a href='register.html'>Go back</a>";
        }
    }
}
?>
