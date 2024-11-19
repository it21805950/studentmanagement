<?php
include 'db_connect.php';
include 'navbar.php';
// Handle Insert Operation
if (isset($_POST['insert'])) {
    $title = $_POST['title'];
    $department_id = $_POST['department_id'];

    // Check if DepartmentID exists in the department table
    $check_department_sql = "SELECT * FROM department WHERE DepartmentID=$department_id";
    $result = $conn->query($check_department_sql);

    if ($result->num_rows > 0) {
        // If DepartmentID exists, proceed with the insert
        $sql = "INSERT INTO Diploma (Title, DepartmentID) VALUES ('$title', $department_id)";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert'>New diploma created successfully</div>";
        } else {
            echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert'>Error: Department ID does not exist.</div>";
    }
}

// Handle Update Operation
if (isset($_POST['update'])) {
    $diploma_id = $_POST['diploma_id'];
    $title = $_POST['title'];
    $department_id = $_POST['department_id'];

    // Check if DepartmentID exists in the department table
    $check_department_sql = "SELECT * FROM department WHERE DepartmentID=$department_id";
    $result = $conn->query($check_department_sql);

    if ($result->num_rows > 0) {
        // If DepartmentID exists, proceed with the update
        $sql = "UPDATE Diploma SET Title='$title', DepartmentID=$department_id WHERE DiplomaID=$diploma_id";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert'>Record updated successfully</div>";
        } else {
            echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert'>Error: Department ID does not exist.</div>";
    }
}


if (isset($_POST['delete'])) {
    $diploma_id = $_POST['diploma_id'];

    // Delete the diploma record
    $sql = "DELETE FROM Diploma WHERE DiplomaID=$diploma_id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>Record deleted successfully</div>";

        // Renumber the DiplomaID
        // 1. Initialize the variable for the new ID
        $conn->query("SET @new_id = 0");

        // 2. Renumber the DiplomaID sequentially
        $conn->query("UPDATE Diploma SET DiplomaID = (@new_id := @new_id + 1)");

        // 3. Reset AUTO_INCREMENT to the next number after the highest current DiplomaID
        $conn->query("ALTER TABLE Diploma AUTO_INCREMENT = 1");

        echo "<div class='alert'>Diploma IDs renumbered successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}


// Handle Select Operation
$diplomas = [];
$sql = "SELECT * FROM Diploma";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $diplomas[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Diplomas</title>  
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<h1>Manage Diplomas</h1>

<h3>Insert Diploma</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" required>
    </div>
    <input type="submit" name="insert" class="btn btn-insert" value="Insert">
</form>

<h3>Update Diploma</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="diploma_id">Diploma ID:</label>
        <input type="number" id="diploma_id" name="diploma_id" required>
    </div>
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" required>
    </div>
    <input type="submit" name="update" class="btn btn-update" value="Update">
</form>

<h3>Delete Diploma</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="diploma_id">Diploma ID:</label>
        <input type="number" id="diploma_id" name="diploma_id" required>
    </div>
    <input type="submit" name="delete" class="btn btn-delete" value="Delete">
</form>

<h3>All Diplomas</h3>
<table>
    <tr>
        <th>Diploma ID</th>
        <th>Title</th>
        <th>Department ID</th>
    </tr>
    <?php foreach ($diplomas as $diploma): ?>
        <tr>
            <td><?php echo $diploma['DiplomaID']; ?></td>
            <td><?php echo $diploma['Title']; ?></td>
            <td><?php echo $diploma['DepartmentID']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
