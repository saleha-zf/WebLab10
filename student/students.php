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
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
  
<link rel="stylesheet" href="styles.css">
  
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<header>

  <h1>Online Attendance Management System 1.0</h1>
  <div class="navbar">
    <a href="index.php">Home</a>
    <a href="students.php">Students</a>
    <a href="report.php">My Report</a>
    <a href="account.php">My Account</a>
    <a href="../logout.php">Logout</a>
  </div>

</header>

<center>

<div class="row">

  <div class="content">
    <h3>Student List</h3>
    <br>

    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
      <div class="form-group">
        <label for="input1" class="col-sm-3 control-label">Batch</label>
        <div class="col-sm-7">
            <input type="text" name="sr_batch" class="form-control" id="input1" placeholder="Only 2020" />
        </div>
      </div>
      <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
    </form>

    <div class="content"></div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Registration No.</th>
          <th scope="col">Name</th>
          <th scope="col">Department</th>
          <th scope="col">Batch</th>
          <th scope="col">Semester</th>
          <th scope="col">Email</th>
        </tr>
      </thead>
    <?php
    if (isset($_POST['sr_btn'])) {

        // Get the batch value from the form (you can dynamically change this if needed)
        $srbatch = $_POST['sr_batch'];  // Get batch from form input
        $i = 0;

        // Perform the query using MySQLi
        $query = "SELECT * FROM students WHERE st_batch = '$srbatch' ORDER BY st_id ASC";
        $result = $connection->query($query);

        // Check if query returns results
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                $i++;
    ?>

        <tr>
          <td><?php echo $data['st_id']; ?></td>
          <td><?php echo $data['st_name']; ?></td>
          <td><?php echo $data['st_dept']; ?></td>
          <td><?php echo $data['st_batch']; ?></td>
          <td><?php echo $data['st_sem']; ?></td>
          <td><?php echo $data['st_email']; ?></td>
        </tr>

    <?php 
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
    }
    ?>
    </table>

  </div>

</div>

</center>

</body>
</html>
