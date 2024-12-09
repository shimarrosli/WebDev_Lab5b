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

// Query to fetch data from the users table
$sql = "SELECT matric, name, role AS accessLevel FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #d3e0ea;
        }

        h1 {
            text-align: center;
            font-family: Arial, sans-serif;
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
    <h1>Users List</h1>
    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Role</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Fetch each row from the result set
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["matric"]) . "</td>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["accessLevel"]) . "</td>
                        <td><a href='update_form.php?matric=" . urlencode($row["matric"]) . "'>Update</a></td>
                        <td><a href='delete.php?matric=" . urlencode($row["matric"]) . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a></td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <footer>
        <a href="login.php">Log Out</a>
    </footer>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
