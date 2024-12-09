<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";  
$dbname = "lab_5b";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error = ""; 

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Query to fetch the user with the provided matric
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if ($user['password'] === $password) { // No hashing used, simple comparison
            // Authentication successful, redirect to display_users.php
            header("Location: display.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "Matric not found. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            text-align: center;
        }
        .form-container {
            width: 300px;
            margin: 0 auto;
        }
        form {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 80%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .register-link {
            margin-top: 10px;
            display: block;
            text-decoration: none;
            color: #007BFF;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <div class="form-container">
        <form method="post" action="">
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <p>Don't have an account?<a class="register-link" href="users.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
