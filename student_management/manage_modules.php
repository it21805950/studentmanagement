<?php
include 'db_connect.php';
include 'navbar.php';

// Handle Insert, Update, Delete Operations for Modules
if (isset($_POST['insert_module'])) {
    $module_code = $_POST['module_code'];
    $title = $_POST['module_title'];
    $credit_value = $_POST['credit_value'];
    $coordinator_id = $_POST['coordinator_id'];
    $diploma_id = $_POST['module_diploma_id'];
    $department_id = $_POST['department_id'];
    $lecturer_id = $_POST['lecturer_id']; 

    $sql = "INSERT INTO Module (ModuleCode, Title, CreditValue, CoordinatorID, DiplomaID, DepartmentID, LecturerID) 
            VALUES ('$module_code', '$title', $credit_value, $coordinator_id, $diploma_id, $department_id, $lecturer_id)";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>New module record created successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
if (isset($_POST['update_module'])) {
    $module_code = $_POST['module_code'];  
    $title = $_POST['module_title'];
    $credit_value = $_POST['credit_value'];
    $coordinator_id = $_POST['coordinator_id'];
    $diploma_id = $_POST['module_diploma_id'];
    $department_id = $_POST['department_id'];
    $lecturer_id = $_POST['lecturer_id'];

    // Update the module record
    $sql = "UPDATE Module SET Title='$title', CreditValue=$credit_value, CoordinatorID=$coordinator_id, 
            DiplomaID=$diploma_id, DepartmentID=$department_id, LecturerID=$lecturer_id 
            WHERE ModuleCode='$module_code'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>Module record updated successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}



if (isset($_POST['delete_module'])) {
    $module_code = $_POST['module_code'];
    
   
    $sql_delete_enrollments = "DELETE FROM enrollment WHERE ModuleCode='$module_code'";
    if ($conn->query($sql_delete_enrollments) === TRUE) {
        // Proceed to delete the module
        $sql = "DELETE FROM Module WHERE ModuleCode='$module_code'";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert'>Module record deleted successfully</div>";
        } else {
            echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert'>Error deleting enrollments: " . $sql_delete_enrollments . "<br>" . $conn->error . "</div>";
    }
}


// Fetch all modules with lecturer names
$sql = "SELECT m.ModuleCode, m.Title, m.CreditValue, m.CoordinatorID, m.DiplomaID, m.DepartmentID, l.Name AS LecturerName 
        FROM Module m
        LEFT JOIN Lecturer l ON m.LecturerID = l.LecturerID";
$result = $conn->query($sql);

// Create an array to store modules
$modules = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $modules[] = $row;
    }
}

// Fetch all lecturers from the database
$sql = "SELECT LecturerID, Name AS LecturerName FROM Lecturer";
$result = $conn->query($sql);

// Create an array to store lecturers
$lecturers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lecturers[] = $row;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Manage Modules</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
    <h1>Manage Modules</h1>
</header>

<h3>Insert Module</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="module_code">Module Code:</label>
        <input type="text" id="module_code" name="module_code" required>
    </div>
    <div class="form-group">
        <label for="module_title">Title:</label>
        <input type="text" id="module_title" name="module_title" required>
    </div>
    <div class="form-group">
        <label for="credit_value">Credit Value:</label>
        <input type="number" id="credit_value" name="credit_value" required>
    </div>
    <div class="form-group">
        <label for="coordinator_id">Coordinator ID:</label>
        <input type="number" id="coordinator_id" name="coordinator_id" required>
    </div>
    <div class="form-group">
        <label for="module_diploma_id">Diploma ID:</label>
        <input type="number" id="module_diploma_id" name="module_diploma_id" required>
    </div>
    <div class="form-group">
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" required>
    </div>
    <div class="form-group">
        <label for="Lecturer_Name:">Lecturer Name:</label>
        <select id="lecturer_id" name="lecturer_id" required>
        <option value="">Select Lecturer</option>
        <?php foreach ($lecturers as $lecturer): ?>
            <option value="<?php echo $lecturer['LecturerID']; ?>">
                <?php echo $lecturer['LecturerName']; ?>
            </option>
        <?php endforeach; ?>
    </select>
       
    </div>
    
    
    <input type="submit" name="insert_module" class="btn btn-insert" value="Insert">
</form>

<h3>Update Module</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="module_code">Module Code:</label>
        <input type="text" id="module_code" name="module_code" required>
    </div>
    <div class="form-group">
        <label for="module_title">Title:</label>
        <input type="text" id="module_title" name="module_title" required>
    </div>
    <div class="form-group">
        <label for="credit_value">Credit Value:</label>
        <input type="number" id="credit_value" name="credit_value" required>
    </div>
    <div class="form-group">
        <label for="coordinator_id">Coordinator ID:</label>
        <input type="number" id="coordinator_id" name="coordinator_id" required>
    </div>
    <div class="form-group">
        <label for="module_diploma_id">Diploma ID:</label>
        <input type="number" id="module_diploma_id" name="module_diploma_id" required>
    </div>
    <div class="form-group">
        <label for="department_id">Department ID:</label>
        <input type="number" id="department_id" name="department_id" required>
    </div>
    <div class="form-group">
        <label for="Lecturer_Name:">Lecturer Name:</label>
        <select id="lecturer_id" name="lecturer_id" required>
        <option value="">Select Lecturer</option>
        <?php foreach ($lecturers as $lecturer): ?>
            <option value="<?php echo $lecturer['LecturerID']; ?>">
                <?php echo $lecturer['LecturerName']; ?>
            </option>
        <?php endforeach; ?>
    </select>
       
    </div>
    
    <input type="submit" name="update_module" class="btn btn-update" value="Update">
</form>

<h3>Delete Module</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="module_code">Module Code:</label>
        <input type="text" id="module_code" name="module_code" required>
    </div>
    <input type="submit" name="delete_module" class="btn btn-delete" value="Delete">
</form>

<h3>All Modules</h3>
<table>
    <tr>
        <th>Module Code</th>
        <th>Title</th>
        <th>Credit Value</th>
        <th>Coordinator ID</th>
        <th>Diploma ID</th>
        <th>Department ID</th>
        <th>Lecturer Name</th>
    </tr>
    <?php foreach ($modules as $module): ?>
        <tr>
            <td><?php echo $module['ModuleCode']; ?></td>
            <td><?php echo $module['Title']; ?></td>
            <td><?php echo $module['CreditValue']; ?></td>
            <td><?php echo $module['CoordinatorID']; ?></td>
            <td><?php echo $module['DiplomaID']; ?></td>
            <td><?php echo $module['DepartmentID']; ?></td>
            <td><?php echo $module['LecturerName']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
