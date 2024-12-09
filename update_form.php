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

// Fetch user data if matric is provided in the URL
$matric = "";
$name = "";
$role = "";
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $role = $user['role'];
    } else {
        echo "User not found.";
        exit;
    }
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>User updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error updating user: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
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
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
            font-weight: bold;
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
    <h1>Update User</h1>
    <form method="post" action="">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($matric); ?>" readonly><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="lecturer" <?php echo $role == "lecturer" ? "selected" : ""; ?>>Lecturer</option>
            <option value="student" <?php echo $role == "student" ? "selected" : ""; ?>>Student</option>
        </select><br><br>

        <button type="submit">Update</button>
        <footer>
        <a href="display.php">Back</a>
        </footer>
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
