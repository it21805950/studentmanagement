<?php
include 'db_connect.php';
include 'navbar.php';
// Handle Insert, Update, Delete Operations for Students
if (isset($_POST['insert_student'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $diploma_id = $_POST['diploma_id'];
    $exam_results = $_POST['exam_results'];

    $sql = "INSERT INTO Student (Name, Address, DiplomaID, ExamResults) VALUES ('$name', '$address', $diploma_id, '$exam_results')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>New student record created successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

if (isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $diploma_id = $_POST['diploma_id'];
    $exam_results = $_POST['exam_results'];

    $sql = "UPDATE Student SET Name='$name', Address='$address', DiplomaID=$diploma_id, ExamResults='$exam_results' WHERE StudentID=$student_id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>Student record updated successfully</div>";
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

if (isset($_POST['delete_student'])) {
    $student_id = $_POST['student_id'];

    // Delete the selected student
    $sql = "DELETE FROM Student WHERE StudentID=$student_id";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert'>Student record deleted successfully</div>";

        // Reorder Student IDs
        $sql = "SET @count = 0";
        $conn->query($sql);

        $sql = "UPDATE Student SET StudentID = @count:= @count + 1";
        $conn->query($sql);

        // Reset AUTO_INCREMENT to the highest current ID + 1
        $sql = "ALTER TABLE Student AUTO_INCREMENT = 1";
        $conn->query($sql);
    } else {
        echo "<div class='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}


// Fetch all students
$students = [];
$sql = "SELECT * FROM Student";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
    <h1>Manage Students</h1>
</header>

<h3>Insert Student</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="diploma_id">Diploma ID:</label>
        <input type="number" id="diploma_id" name="diploma_id" required>
    </div>

    <div class="form-group">
        <label for="exam_results">Exam Results:</label>
        <textarea id="exam_results" name="exam_results" required></textarea>
    </div>

    <input type="submit" name="insert_student" class="btn btn-insert" value="Insert">
</form>

<h3>Update Student</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="student_id">Student ID:</label>
        <input type="number" id="student_id" name="student_id" required>
    </div>
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="diploma_id">Diploma ID:</label>
        <input type="number" id="diploma_id" name="diploma_id" required>
    </div>

    <div class="form-group">
        <label for="exam_results">Exam Results:</label>
        <textarea id="exam_results" name="exam_results" required></textarea>
    </div>
    <input type="submit" name="update_student" class="btn btn-update" value="Update">
</form>

<h3>Delete Student</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="student_id">Student ID:</label>
        <input type="number" id="student_id" name="student_id" required>
    </div>
    <input type="submit" name="delete_student" class="btn btn-delete" value="Delete">
</form>

<h3>All Students</h3>
<table>
    <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Diploma ID</th>
        <th>Exam Results</th>
    </tr>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?php echo $student['StudentID']; ?></td>
            <td><?php echo $student['Name']; ?></td>
            <td><?php echo $student['Address']; ?></td>
            <td><?php echo $student['DiplomaID']; ?></td>
            <td>
                <table>
                    <?php
                    $examResults = explode("\n", $student['ExamResults']);
                    foreach ($examResults as $result) {
                        echo "<tr><td>$result</td></tr>";
                    }
                    ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


</body>
</html>
