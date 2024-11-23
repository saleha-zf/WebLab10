<?php

if (isset($_POST['login'])) {
    try {
        // Check empty fields
        if (empty($_POST['username'])) {
            throw new Exception("Username is required!");
        }
        if (empty($_POST['password'])) {
            throw new Exception("Password is required!");
        }

        // Establishing connection
        include('connect.php'); // Uses MySQLi-based `connect.php`

        // Prevent SQL injection with prepared statements
        $stmt = $connection->prepare("SELECT * FROM user WHERE username = ? AND password = ? AND type = ?");
        $stmt->bind_param("sss", $_POST['username'], $_POST['password'], $_POST['type']);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check rows returned
        if ($result->num_rows > 0) {
            session_start();
            $_SESSION['name'] = "oasis";

            // Redirect based on role
            if ($_POST["type"] == 'teacher') {
                header('location: teacher/index.php');
            } elseif ($_POST["type"] == 'student') {
                header('location: student/index.php');
            } elseif ($_POST["type"] == 'admin') {
                header('location: admin/index.php');
            }
        } else {
            throw new Exception("Username, Password, or Role is wrong, try again!");
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html>
<head>

	<title>Online Attendance Management System</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
	 
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
	 
	 
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
	<center>

<header>

  <h1>Online Attendance Management System 1.0</h1>

</header>

<h1>Login</h1>

<?php
//printing error message
if(isset($error_msg))
{
	echo $error_msg;
}
?>

<!-- Old Version -->
<!-- 
<form action="" method="post">
	
	<table>
		<tr>
			<td>Username </td>
			<td><input type="text" name="username"></input></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password"></input></td>
		</tr>
		<tr>
			<td>Role</td>
			<td>
			<select name="type">
				<option name="teacher" value="teacher">Teacher</option>
				<option name="student" value="student">Student</option>
				<option name="admin" value="admin">Admin</option>
			</select>
			</td>
		</tr>
		<tr><td><br></td></tr>
		<tr>
			<td><button><input type="submit" name="login" value="Login"></input></button></td>
			<td><button><input type="reset" name="reset" value="Reset"></button></td>
		</tr>
	</table>
</form>
-->

<div class="content">
	<div class="row">

		<form method="post" class="form-horizontal col-md-6 col-md-offset-3">
			<div class="form-group">
			    <label for="input1" class="col-sm-3 control-label">Username</label>
			    <div class="col-sm-7">
			      <input type="text" name="username"  class="form-control" id="input1" placeholder="your username" />
			    </div>
			</div>

			<div class="form-group">
			    <label for="input1" class="col-sm-3 control-label">Password</label>
			    <div class="col-sm-7">
			      <input type="password" name="password"  class="form-control" id="input1" placeholder="your password" />
			    </div>
			</div>


			<div class="form-group" class="radio">
			<label for="input1" class="col-sm-3 control-label">Role</label>
			<div class="col-sm-7">
			  <label>
			    <input type="radio" name="type" id="optionsRadios1" value="student" checked> Student
			  </label>
			  	  <label>
			    <input type="radio" name="type" id="optionsRadios1" value="teacher"> Teacher
			  </label>
			  <label>
			    <input type="radio" name="type" id="optionsRadios1" value="admin"> Admin
			  </label>
			</div>
			</div>


			<input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Login" name="login" />
		</form>
	</div>
</div>



<br><br>
<p><strong>Have forgot your password? <a href="reset.php">Reset here.</a></strong></p>
<p><strong>If you don't have any account, <a href="signup.php">Signup</a> here</strong></p>

</center>
</body>
</html>