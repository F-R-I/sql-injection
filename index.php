<?php
// Database connection settings
$dsn = "mysql:host=localhost;dbname=auth;charset=utf8"; // Database name auth
$username = "root"; // Default username in XAMPP
$password = ""; // Default password (usually empty in XAMPP)

try {
    // Create PDO connection
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Failed to connect to the database: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsafe_submit'])) {
        // Unsafe input (vulnerable to SQL Injection)
        $user_input = $_POST['user_input'];

        try {
            $query = "SELECT * FROM users WHERE username = '$user_input'";
            $result = $conn->query($query);

            echo "<h2>Search Results (Unsafe):</h2>";
            if ($result->rowCount() > 0) {
                foreach ($result as $row) {
                    echo "Username: " . htmlspecialchars($row['username']) . "<br>";
                    echo "Email: " . htmlspecialchars($row['email']) . "<br>";
                }
            } else {
                echo "No results found.";
            }
        } catch (PDOException $e) {
            echo "Query error (Unsafe): " . $e->getMessage();
        }
    }

    if (isset($_POST['safe_submit'])) {
        // Safe input (prevent SQL Injection using prepared statements)
        $user_input = $_POST['user_input'];

        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $user_input, PDO::PARAM_STR);
            $stmt->execute();

            echo "<h2>Search Results (Safe):</h2>";
            if ($stmt->rowCount() > 0) {
                foreach ($stmt as $row) {
                    echo "Username: " . htmlspecialchars($row['username']) . "<br>";
                    echo "Email: " . htmlspecialchars($row['email']) . "<br>";
                }
            } else {
                echo "No results found.";
            }
        } catch (PDOException $e) {
            echo "Query error (Safe): " . $e->getMessage();
        }
    }
}
?>
