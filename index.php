// db.php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

// style.css
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}
.container {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
button, input {
    padding: 10px;
    margin: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
button {
    background-color: #007BFF;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background-color: #0056b3;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
th {
    background-color: #007BFF;
    color: white;
}

// index.php
<?php
include 'db.php';
$result = $conn->query("SELECT * FROM tables");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Café Management</title>
</head>
<body>
<div class="container">
    <h1>Table and Customer Management</h1>
    <a href="create.php"><button>Add New Record</button></a>
    <table>
        <tr>
            <th>ID</th>
            <th>Table Number</th>
            <th>Customer Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['table_number']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>

// create.php
<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_number = $_POST['table_number'];
    $customer_name = $_POST['customer_name'];
    $conn->query("INSERT INTO tables (table_number, customer_name) VALUES ('$table_number', '$customer_name')");
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Add Record</title>
</head>
<body>
<div class="container">
    <h1>Add New Record</h1>
    <form method="POST">
        <label>Table Number:</label>
        <input type="text" name="table_number" required><br>
        <label>Customer Name:</label>
        <input type="text" name="customer_name" required><br>
        <button type="submit">Add</button>
    </form>
</div>
</body>
</html>

// edit.php
<?php
include 'db.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tables WHERE id=$id");
$row = $result->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_number = $_POST['table_number'];
    $customer_name = $_POST['customer_name'];
    $conn->query("UPDATE tables SET table_number='$table_number', customer_name='$customer_name' WHERE id=$id");
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Edit Record</title>
</head>
<body>
<div class="container">
    <h1>Edit Record</h1>
    <form method="POST">
        <label>Table Number:</label>
        <input type="text" name="table_number" value="<?php echo $row['table_number']; ?>" required><br>
        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?php echo $row['customer_name']; ?>" required><br>
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>

// delete.php
<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM tables WHERE id=$id");
header('Location: index.php');
?>
