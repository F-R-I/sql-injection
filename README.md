# SQL Injection Test Project

## Overview
This project demonstrates an example of an SQL Injection vulnerability and how to prevent it using prepared statements. The goal is to highlight the risks of improper handling of user input in SQL queries and show how secure coding practices can mitigate these risks.

## Steps to Create the Database

1. **Create a Database:**
   - Create a new database called `auth` in MySQL.

   ```sql
   CREATE DATABASE auth;
Create a Users Table:

In the auth database, create a users table with the following structure:
sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL
);
Insert Sample Data:

Insert some sample users into the users table:
sql

INSERT INTO users (username, email) VALUES
('root', 'root@example.com'),
('admin', 'admin@example.com'),
('testuser1', 'test1@example.com'),
('testuser2', 'test2@example.com');
SQL Injection Vulnerability
The project includes a page that accepts user input for querying the database. There are two forms:

Unsafe Form (SQL Injection Vulnerability):

This form directly inserts user input into the SQL query without sanitization or validation, making it vulnerable to SQL Injection.
For example, if a user enters ' OR 1=1 #, it will return all users in the database due to the SQL query being modified.
Example of Vulnerable Query:

php

$query = "SELECT * FROM users WHERE username = '$user_input'";
Safe Form (Prepared Statement):

This form uses a prepared statement, which securely binds the user input to the SQL query, preventing SQL Injection.
By using PDO with bound parameters, this method ensures that user input is treated as data, not executable code.
Example of Safe Query:

php

$query = "SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($query);
$stmt->bindParam(':username', $user_input, PDO::PARAM_STR);
$stmt->execute();
How to Run the Project
Setup the Database:

Create a MySQL database named auth.
Run the SQL queries to create the users table and insert sample data.
Set Up the Web Server:

Place the project files (index.php and form.html) in the appropriate directory on your local web server (e.g., XAMPP, WAMP, or LAMP).
Ensure the PHP configuration is correct for your local setup, including database connection settings (username, password, and database name).
Test SQL Injection:

Open the form.html file in your browser.
Try submitting different usernames to see the difference between the unsafe form (vulnerable to SQL Injection) and the safe form (secure against SQL Injection).
Security Measures
Always use prepared statements to prevent SQL Injection.
Never concatenate user input directly into SQL queries.
Validate and sanitize all user input before using it in queries.
Conclusion
This project demonstrates the importance of secure coding practices when interacting with databases. By using prepared statements and parameterized queries, you can effectively prevent SQL Injection attacks and protect your applications from malicious exploits.

sql


### Steps to Add to Your `README.md`:
1. Open or create the `README.md` file in your project directory.
2. Copy and paste the content above into the `README.md` file.
3. Save the file and commit it to your GitHub repository.

This will create a structured and informative README for your project that explains how it works and highlights the importance of preventing SQL injection vulnerabilities.





