<?php
if (isset($_POST['login_user'])) {
  $Email = mysqli_real_escape_string($db, $_POST['email']);
  $Password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($Email)) {
    array_push($errors, "Email is required");
  }
  if (empty($Password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $Password = md5($Password);
    $query = "SELECT * FROM users WHERE fullname='$Fullname' AND password='$Password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['fullname'] = $FullName;
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
    }else {
      array_push($errors, "Wrong email/password combination");
    }
  }
}
?>
