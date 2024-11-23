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
    <link rel="stylesheet" type="text/css" href="main.css">
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
            <a href="report.php">My Report</a>
            <a href="account.php">My Account</a>
            <a href="../logout.php">Logout</a>
        </div>
    </header>

    <center>
        <div class="row">
            <div class="content">
                <h3>Student Report</h3>
                <br>
                <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Select Subject</label>
                        <div class="col-sm-4">
                            <select name="whichcourse" id="input1">
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
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input1" class="col-sm-3 control-label">Your Reg. No.</label>
                        <div class="col-sm-7">
                            <input type="text" name="sr_id" class="form-control" id="input1" placeholder="enter your reg. no." />
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
                </form>

                <div class="content"><br></div>

                <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
                    <table class="table table-striped">
                        <?php
                        // Checking the form for ID
                        if (isset($_POST['sr_btn'])) {
                            $sr_id = $_POST['sr_id'];
                            $course = $_POST['whichcourse'];

                            $i = 0;
                            $count_pre = 0;

                            // Query for searching respective ID
                            $all_query = $connection->query("SELECT stat_id, COUNT(*) as countP FROM attendance WHERE stat_id = '$sr_id' AND course = '$course' AND st_status = 'Present'");
                            $singleT = $connection->query("SELECT COUNT(*) as countT FROM attendance WHERE stat_id = '$sr_id' AND course = '$course'");

                            $count_tot = 0;
                            if ($row = $singleT->fetch_row()) {
                                $count_tot = $row[0];
                            }

                            // Displaying the results
                            while ($data = $all_query->fetch_assoc()) {
                                $i++;
                                if ($i <= 1) {
                        ?>
                                    <tbody>
                                        <tr>
                                            <td>Registration No.: </td>
                                            <td><?php echo $data['stat_id']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Total Class (Days): </td>
                                            <td><?php echo $count_tot; ?> </td>
                                        </tr>

                                        <tr>
                                            <td>Present (Days): </td>
                                            <td><?php echo $data['countP']; ?> </td>
                                        </tr>

                                        <tr>
                                            <td>Absent (Days): </td>
                                            <td><?php echo $count_tot - $data['countP']; ?> </td>
                                        </tr>
                                    </tbody>
                        <?php
                                }
                            }
                        }
                        ?>
                    </table>
                </form>
            </div>
        </div>
    </center>
</body>
</html>
