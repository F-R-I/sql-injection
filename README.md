Report on Creating a Database and SQL Injection Test
1. Creating the Database
Initially, we will create a new database that contains a users table. In this example, we will have a database named auth and a users table containing user information such as username and email.
Steps to Create the Database:
1.	Open phpMyAdmin, MySQL Workbench, or any database management tool you prefer.
2.	Create a new database using the following SQL query:
sql
نسخ الكود
CREATE DATABASE auth;
3.	After creating the database, select it to start adding tables.
4.	To create the users table, use the following query:
sql
نسخ الكود
USE auth;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);
2. Inserting User Data
Now we will add some sample users to the users table. We will insert 3 test users.
Inserting User Data:
sql
نسخ الكود
INSERT INTO users (username, email) VALUES ('root', 'root@example.com');
INSERT INTO users (username, email) VALUES ('admin', 'admin@example.com');
INSERT INTO users (username, email) VALUES ('admin_root', 'admin_root@example.com');
3. Creating a PHP Page to Perform SQL Injection Testing
We now have a database with user data. Next, we will create a PHP page with a form to input the username, which will send the data to the database using an unsafe query (to show how SQL Injection occurs) and a safe query using Prepared Statements.
PHP File (index.php):
php
نسخ الكود
<?php
// Database connection settings
$dsn = "mysql:host=localhost;dbname=auth;charset=utf8";
$username = "root"; 
$password = ""; 

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsafe_submit'])) {
        // Unsafe input
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
        // Safe input using Prepared Statements
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
4. Creating an HTML Page for User Input
Now, we will create an HTML page with a form to input the username, which will be sent to index.php for processing.
HTML File (form.html):
html
نسخ الكود
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #0056b3;
        }
        label {
            font-size: 18px;
            color: #333;
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #0056b3;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #004080;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SQL Injection Test</h1>
        <form action="index.php" method="POST">
            <label for="user_input">Enter Username:</label><br>
            <input type="text" id="user_input" name="user_input" placeholder="Enter username"><br>

            <button type="submit" name="unsafe_submit">Submit (Unsafe)</button>
            <button type="submit" name="safe_submit">Submit (Safe)</button>
        </form>
    </div>
</body>
</html>
5. Explanation of How to Perform the Test
•	Unsafe SQL Injection Test: When you enter a username like 1' OR 1=1 # in the form, it will retrieve all user data from the database, exposing it to a significant security risk.
•	Safe SQL Injection Test: By using prepared statements, the query is safe, and the application will not be vulnerable to SQL Injection attacks since the inputs are validated and treated securely.
6. Security Notes:
•	An example of how SQL Injection occurs with unsafe queries has been shown.
•	The solution provided using Prepared Statements protects against this vulnerability.
•	Always validate user inputs and avoid queries that directly use user input.
7. Conclusion
•	A database was created with a users table and populated with test data.
•	A PHP application was built to demonstrate SQL Injection and provide a secure solution using prepared statements.
•	Using these methods, developers can learn how to secure their applications against SQL Injection attacks.

