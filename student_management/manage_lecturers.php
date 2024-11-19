<?php
include 'db_connect.php';
include 'navbar.php';
// Handle Insert, Update, Delete Operations for Lecturers
if (isset($_POST['insert_lecturer'])) {
    $name = $_POST['lecturer_name'];

    $sql = "INSERT INTO Lecturer (Name) VALUES ('$name')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>New lecturer record created successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

if (isset($_POST['update_lecturer'])) {
    $lecturer_id = $_POST['lecturer_id'];
    $name = $_POST['lecturer_name'];

    $sql = "UPDATE Lecturer SET Name='$name' WHERE LecturerID=$lecturer_id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>Lecturer record updated successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

if (isset($_POST['delete_lecturer'])) {
    $lecturer_id = $_POST['lecturer_id'];

    // Set LecturerID in module table to NULL (or you can delete related modules)
    $sql = "UPDATE module SET LecturerID = NULL WHERE LecturerID = $lecturer_id";
    $conn->query($sql);

    // Now delete the lecturer
    $sql = "DELETE FROM Lecturer WHERE LecturerID=$lecturer_id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>Lecturer record deleted successfully</div>";

        // Reorder Lecturer IDs
        $sql = "SET @count = 0";
        $conn->query($sql);

        $sql = "UPDATE Lecturer SET LecturerID = @count:= @count + 1";
        $conn->query($sql);

        // Reset AUTO_INCREMENT to the highest current ID + 1
        $sql = "ALTER TABLE Lecturer AUTO_INCREMENT = 1";
        $conn->query($sql);
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}



// Fetch all lecturers
$lecturers = [];
$sql = "SELECT * FROM Lecturer";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lecturers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Lecturers</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
    <h1>Manage Lecturers</h1>
</header>

<h3>Insert Lecturer</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="lecturer_name">Name:</label>
        <input type="text" id="lecturer_name" name="lecturer_name" required>
    </div>
    <input type="submit" name="insert_lecturer" class="btn btn-insert" value="Insert">
</form>

<h3>Update Lecturer</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="lecturer_id">Lecturer ID:</label>
        <input type="number" id="lecturer_id" name="lecturer_id" required>
    </div>
    <div class="form-group">
        <label for="lecturer_name">Name:</label>
        <input type="text" id="lecturer_name" name="lecturer_name" required>
    </div>
    <input type="submit" name="update_lecturer" class="btn btn-update" value="Update">
</form>

<h3>Delete Lecturer</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="lecturer_id">Lecturer ID:</label>
        <input type="number" id="lecturer_id" name="lecturer_id" required>
    </div>
    <input type="submit" name="delete_lecturer" class="btn btn-delete" value="Delete">
</form>

<h3>All Lecturers</h3>
<table>
    <tr>
        <th>Lecturer ID</th>
        <th>Name</th>
    </tr>
    <?php foreach ($lecturers as $lecturer): ?>
        <tr>
            <td><?php echo $lecturer['LecturerID']; ?></td>
            <td><?php echo $lecturer['Name']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
