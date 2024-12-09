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

// Handle form submission
$message = ""; // To store success or error messages
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // SQL query to insert data
    $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input, select, button {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            left: 50%;
            top: 50%;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
            font-weight: bold;
            color: green;
        }
        footer {
            text-align: center;
            margin-top: 20px;
        }
        footer a {
            text-decoration: none;
            margin: 0 10px;
            color: #007BFF;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Register Form</h1>
    
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    
    <form method="post" action="">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="" disabled selected>Please select</option>
            <option value="lecturer">Lecturer</option>
            <option value="student">Student</option>
        </select><br><br>

        <button type="submit">Submit</button>
        <footer>
        <a href="login.php">Login</a>
        </footer>
    </form>
        
    
</body>
</html>
