<?php
  $sessionEmail = $_SESSION['email'];

  $sql = "SELECT * FROM users where email = '$sessionEmail'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result);

  $is_admin = $row['is_admin'];
  $is_staff = $row['is_staff'];

  if($is_admin != 0 && $is_staff != 1)
  {
    header("Location: ../index.php?error");
    exit();
  }
?>