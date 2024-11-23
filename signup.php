<?php
include('connect.php');


// Create connection to the database (assuming you're using MySQLi)
$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

try {
    if (isset($_POST['signup'])) {
        // Validation of empty fields
        if (empty($_POST['email'])) throw new Exception("Email can't be empty.");
        if (empty($_POST['uname'])) throw new Exception("Username can't be empty.");
        if (empty($_POST['pass'])) throw new Exception("Password can't be empty.");
        if (empty($_POST['fname'])) throw new Exception("Full name can't be empty.");
        if (empty($_POST['phone'])) throw new Exception("Phone number can't be empty.");
        if (empty($_POST['type'])) throw new Exception("Role can't be empty.");

        // Hash password before saving to database
        $hashed_password = password_hash($_POST['pass'], PASSWORD_BCRYPT);

        // Prepare and bind the query to prevent SQL injection
        $stmt = $connection->prepare("INSERT INTO user (username, password, email, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $_POST['uname'], $hashed_password, $_POST['email'], $_POST['fname'], $_POST['phone'], $_POST['type']);

        // Execute the query
        if ($stmt->execute()) {
            $success_msg = "Signup Successfully!";
        } else {
            throw new Exception("Error in signup: " . $stmt->error);
        }

        $stmt->close();
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Attendance Management System 1.0</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<header>
  <h1>Online Attendance Management System 1.0</h1>
</header>

<center>
<h1>Signup</h1>
<div class="content">
    <div class="row">
        <?php
        if (isset($success_msg)) echo $success_msg;
        if (isset($error_msg)) echo $error_msg;
        ?>
        <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
            <div class="form-group">
                <label for="input1" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-7">
                    <input type="text" name="email" class="form-control" id="input1" placeholder="your email" />
                </div>
            </div>

            <div class="form-group">
                <label for="input1" class="col-sm-3 control-label">Username</label>
                <div class="col-sm-7">
                    <input type="text" name="uname" class="form-control" id="input1" placeholder="choose username" />
                </div>
            </div>

            <div class="form-group">
                <label for="input1" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-7">
                    <input type="password" name="pass" class="form-control" id="input1" placeholder="choose a strong password" />
                </div>
            </div>

            <div class="form-group">
                <label for="input1" class="col-sm-3 control-label">Full Name</label>
                <div class="col-sm-7">
                    <input type="text" name="fname" class="form-control" id="input1" placeholder="your full name" />
                </div>
            </div>

            <div class="form-group">
                <label for="input1" class="col-sm-3 control-label">Phone Number</label>
                <div class="col-sm-7">
                    <input type="text" name="phone" class="form-control" id="input1" placeholder="your phone number" />
                </div>
            </div>

            <div class="form-group" class="radio">
                <label for="input1" class="col-sm-3 control-label">Role</label>
                <div class="col-sm-7">
                    <label><input type="radio" name="type" id="optionsRadios1" value="student" checked> Student</label>
                    <label><input type="radio" name="type" id="optionsRadios1" value="teacher"> Teacher</label>
                </div>
            </div>

            <input type="submit" class="btn btn-primary col-md-2 col-md-offset-8" value="Signup" name="signup" />
        </form>
    </div>
    <br>
    <p><strong>Already have an account? <a href="index.php">Login</a> here.</strong></p>
</div>

</center>

</body>
</html>
