<?php
  //The require_once() will first check whether a file is already included or not and if it is already included then it will not include it again.
  require_once('./php/config.php'); 
  // require_once('./php/session.php'); 
  session_start();

  $email = $password = '';

  
  // $_SERVER["REQUEST_METHOD" =>If post request send then do it
  //isset => if submit is clicked 

  try {
  
    if(isset($_POST['submit'])) {
    $enteredEmail = $_POST["email"];
    $enteredPassword = $_POST["password"];

      //Check If Email Empty
    if(empty($enteredEmail)) {
      throw new Exception("Email can't be blank");
    } else if(empty($enteredPassword)) {
      throw new Exception("Password can't be blank");
    } else {
      $sql = "SELECT * FROM users where email = '$enteredEmail' AND password = '$enteredPassword'";
      $result = mysqli_query($db, $sql);
      $row = mysqli_fetch_array($result);

      if(mysqli_num_rows($result)) {
        $success=  'Logging in...';   
        $_SESSION['email'] = $enteredEmail; 
        $_SESSION['is_admin'] = $row['is_admin'];
        $_SESSION['is_staff'] = $row['is_staff'];

        sleep(2);
        // header("location: ./pages/admin/index.php");
        
        if($row['is_admin'] == 1 && $row['is_staff'] == 0)
        {
          header("location: ./pages/admin/index.php");
        }
        else{
          header("location: ./pages/staff/index.php");
        }


      } else {
        $error = 'Incorrect Email or Password';
      }
    } 
  }
  } catch (Exception $errorData) {
    $error =  $errorData->getMessage();
  }
  
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8" />
  <title>Hotel Management System</title>
  <link rel="stylesheet" href="./css/allstyles.css" />
</head>

<body class="dark">
  <div class="body-login">
      <div class="center-login">
        <div class="content-login">
        <div class="heading_title">
          <h1>Login</h1>
        </div>

        <div class="message-div">
          <?php if(isset($error)){  ?>
            <div class="message-error">
              <?php echo $error; ?>
            </div>
          <?php } ?>
        </div>

        <div class="message-div">
          <?php if(isset($success)){  ?>
            <div class="message-success">
              <?php echo $success; ?>
            </div>
          <?php } ?>
        </div>

        <div class="content-section-login">
          <div class="formgrid">
            <form method='POST'>
              <div class="forminput">
                <label class='label-login'>Email</label>
                <input type="email" name='email' class='search-area' placeholder='Enter your email' />
              </div>

              <div class="forminput">
                <label class='label-login'>Password</label>
                <input type="password" name='password' class='search-area' placeholder='Enter your password' />
              </div>


              <input type="submit" value="Login" class="button-submit" name='submit' />
            </form>
          </div>
        </div>    

      </div>
    </div>
    </div>
</body>
<!-- <script src="./JS/script.js"></script> -->

</html>