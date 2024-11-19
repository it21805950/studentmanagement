<?php
include 'db_connect.php';
include 'navbar.php';
// Handle Insert Operation
if (isset($_POST['insert'])) {
    $department_name = $_POST['department_name'];

    $sql = "INSERT INTO Department (DepartmentName) VALUES ('$department_name')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>New department created successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Handle Update Operation
if (isset($_POST['update'])) {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];

    $sql = "UPDATE Department SET DepartmentName='$department_name' WHERE DepartmentID=$department_id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>Record updated successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Handle Delete Operation
if (isset($_POST['delete'])) {
    $department_id = $_POST['department_id'];

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // Delete the department
        $sql = "DELETE FROM Department WHERE DepartmentID=$department_id";
        if ($conn->query($sql) === TRUE) {
            // Renumber the DepartmentID values sequentially
            $sql_reset_id = "SET @new_id = 0;
                            UPDATE Department SET DepartmentID = (@new_id := @new_id + 1) ORDER BY DepartmentID;
                            ALTER TABLE Department AUTO_INCREMENT = 1;";
            if ($conn->multi_query($sql_reset_id)) {
                do {
                    // Handle results from the multi_query
                    if ($result = $conn->store_result()) {
                        $result->free();
                    }
                } while ($conn->more_results() && $conn->next_result());

                // Commit the transaction
                $conn->commit();
                echo "<div class='alert'>Department record deleted and IDs renumbered successfully</div>";
            } else {
                throw new Exception($conn->error);
            }
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "<div class='alert'>Error: " . $e->getMessage() . "</div>";
    }
}

// Handle Select Operation
$departments = [];
$sql = "SELECT * FROM Department";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Departments</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<h1>Manage Departments</h1>

<h3>Insert Department</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="department_name">Department Name:</label>
        <input type="text" id="department_name" name="department_name" required>
    </div>
    <input type="submit" name="insert" class="btn btn-insert" value="Insert">
</form>

<h3>Update Department</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" required>
    </div>
    <div class="form-group">
        <label for="department_name">Department Name:</label>
        <input type="text" id="department_name" name="department_name" required>
    </div>
    <input type="submit" name="update" class="btn btn-update" value="Update">
</form>

<h3>Delete Department</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" required>
    </div>
    <input type="submit" name="delete" class="btn btn-delete" value="Delete">
</form>

<h3>All Departments</h3>
<table>
    <tr>
        <th>Department ID</th>
        <th>Department Name</th>
    </tr>
    <?php foreach ($departments as $department): ?>
        <tr>
            <td><?php echo $department['DepartmentID']; ?></td>
            <td><?php echo $department['DepartmentName']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
