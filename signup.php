<?php
session_start();

// initializing variables
$FullName = "";
$MobileNumber = "";
$Email = "";
$StudentID = "";
$Password = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'user_management');

// REGISTER USER
if (isset($_POST['signup_user'])) {
  // receive all input values from the form
  $FullName = mysqli_real_escape_string($db, $_POST['fullname']);
  $MobileNumber = mysqli_real_escape_string($db, $_POST['mobilenumber']);
  $Email = mysqli_real_escape_string($db, $_POST['email']);
  $StudentID = mysqli_real_escape_string($db, $_POST['studentID']);
  $Password = mysqli_real_escape_string($db, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($FullName)) { array_push($errors, "Full name is required"); }
  if (empty($MobileNumber)) { array_push($errors, "Full name is required"); }
  if (empty($Email)) { array_push($errors, "Email is required"); }
  if (empty($StudentID)) { array_push($errors, "Student ID is required"); }
  if (empty($Password)) { array_push($errors, "Password is required"); }
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE fullname='$FullName' OR email='$Email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['fullname'] === $FullName) {
      array_push($errors, "name already exists");
    }

    if ($user['mobilenumber'] === $MobileNumber) {
      array_push($errors, "number already exists");
    }

    if ($user['email'] === $Email) {
      array_push($errors, "email already exists");
    }

    if ($user['studentID'] === $StudentID) {
      array_push($errors, "Student ID already exists");
    }

    if ($user['password'] === $Password) {
      array_push($errors, "Password already exists. Please create an new password.");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    $password = md5($password);//encrypt the password before saving in the database

    $query = "INSERT INTO users (fullname, mobilenumber, email, studentID, password) 
          VALUES('$username', '$email', '$password')";
    mysqli_query($db, $query);
    $_SESSION['fullname'] = $FullName;
    $_SESSION['success'] = "You are now logged in";
    header(location: '4.html');
  }
}
?>
