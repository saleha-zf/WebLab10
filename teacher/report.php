<?php
ob_start();
session_start();

if ($_SESSION['name'] != 'oasis') {
    header('location: login.php');
}

include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Attendance Management System 1.0</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<header>
    <h1>Online Attendance Management System 1.0</h1>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="students.php">Students</a>
        <a href="teachers.php">Faculties</a>
        <a href="attendance.php">Attendance</a>
        <a href="report.php">Report</a>
        <a href="../logout.php">Logout</a>
    </div>
</header>

<center>
<div class="row">
    <div class="content">
        <h3>Individual Report</h3>
        <form method="post" action="">
            <label>Select Subject</label>
            <select name="whichcourse">
                <option value="algo">Analysis of Algorithms</option>
                <option value="algolab">Analysis of Algorithms Lab</option>
                <option value="dbms">Database Management System</option>
                <option value="dbmslab">Database Management System Lab</option>
                <option value="weblab">Web Programming Lab</option>
                <option value="os">Operating System</option>
                <option value="oslab">Operating System Lab</option>
                <option value="obm">Object Based Modeling</option>
                <option value="softcomp">Soft Computing</option>
            </select>
            <p></p>
            <label>Student Reg. No.</label>
            <input type="text" name="sr_id">
            <input type="submit" name="sr_btn" value="Go!" >
        </form>

        <h3>Mass Report</h3>
        <form method="post" action="">
            <label>Select Subject</label>
            <select name="course">
                <option value="algo">Analysis of Algorithms</option>
                <option value="algolab">Analysis of Algorithms Lab</option>
                <option value="dbms">Database Management System</option>
                <option value="dbmslab">Database Management System Lab</option>
                <option value="weblab">Web Programming Lab</option>
                <option value="os">Operating System</option>
                <option value="oslab">Operating System Lab</option>
                <option value="obm">Object Based Modeling</option>
                <option value="softcomp">Soft Computing</option>
            </select>
            <p></p>
            <label>Date ( yyyy-mm-dd )</label>
            <input type="text" name="date">
            <input type="submit" name="sr_date" value="Go!" >
        </form>

        <br><br>

        <?php
        $all_query = null;  // Initialize variable
        if (isset($_POST['sr_btn'])) {
            $sr_id = $_POST['sr_id'];
            $course = $_POST['whichcourse'];

            // Replace mysql_query with mysqli_query
            $single = $connection->query("SELECT stat_id, COUNT(*) AS countP FROM attendance WHERE attendance.stat_id='$sr_id' AND attendance.course='$course' AND attendance.st_status='Present'");
            $singleT = $connection->query("SELECT COUNT(*) AS countT FROM attendance WHERE attendance.stat_id='$sr_id' AND attendance.course='$course'");
        }

        if (isset($_POST['sr_date'])) {
            $sdate = $_POST['date'];
            $course = $_POST['course'];

            // Replace mysql_query with mysqli_query
            $all_query = $connection->query("SELECT * FROM attendance WHERE reports.stat_date='$sdate' AND reports.course='$course'");
        }

        if ($all_query && $all_query->num_rows > 0) {
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Reg. No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Batch</th>
                    <th scope="col">Date</th>
                    <th scope="col">Attendance Status</th>
                </tr>
            </thead>

            <?php
            $i = 0;
            // Replace mysql_fetch_array with mysqli_fetch_array
            while ($data = $all_query->fetch_array()) {
                $i++;
            ?>
            <tbody>
                <tr>
                    <td><?php echo $data['st_id']; ?></td>
                    <td><?php echo $data['st_name']; ?></td>
                    <td><?php echo $data['st_dept']; ?></td>
                    <td><?php echo $data['st_batch']; ?></td>
                    <td><?php echo $data['stat_date']; ?></td>
                    <td><?php echo $data['st_status']; ?></td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
        <?php } else { ?>
        <p>No records found.</p>
        <?php } ?>

        <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
        <table class="table table-striped">
        <?php
        if (isset($_POST['sr_btn'])) {
            $count_pre = 0;
            $i = 0;
            $count_tot;
            // Replace mysql_fetch_row with mysqli_fetch_row
            if ($row = $singleT->fetch_row()) {
                $count_tot = $row[0];
            }
            while ($data = $single->fetch_array()) {
                $i++;
                if ($i <= 1) {
        ?>

        <tbody>
            <tr>
                <td>Student Reg. No: </td>
                <td><?php echo $data['stat_id']; ?></td>
            </tr>
            <tr>
                <td>Total Class (Days): </td>
                <td><?php echo $count_tot; ?> </td>
            </tr>
            <tr>
                <td>Present (Days): </td>
                <td><?php echo $data[1]; ?> </td>
            </tr>
            <tr>
                <td>Absent (Days): </td>
                <td><?php echo $count_tot - $data[1]; ?> </td>
            </tr>
        </tbody>

        <?php } } } ?>
        </table>
        </form>
    </div>
</div>

</center>

</body>
</html>
