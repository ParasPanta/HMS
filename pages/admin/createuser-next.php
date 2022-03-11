<?php
  require_once('../../php/config.php'); 
  require_once('../../php/session.php'); 
  require('../../php/adminChecker.php');

  try{

    $SN = $_GET['SN'];

    $sql = "SELECT * FROM staffs WHERE SN = $SN";
    $result = mysqli_query($db, $sql);
    $getDataRow = mysqli_fetch_array($result);

    // $sql_user = "SELECT * FROM users WHERE (email = '$email_user')";
    // $result_user = mysqli_query($db, $sql_user);
    // $getDataRow_user = mysqli_fetch_array($result_user);

    if(isset($_POST['Create'])) {
      $Username = $_POST['username'];
      $UserStatus = $_POST['user_status'];
      $Email = $_POST['email'];

      if($UserStatus == 'Admin'){
       $is_admin = 1;
       $is_staff = 0;
      }
      else{
       $is_admin = 0;
       $is_staff = 1;
      }


      $Password = $_POST['password'];
      $Password2 = $_POST['password2'];
        if(empty($Username)) throw new Error('Username should not be empty');
        else if(empty($Password)) throw new Error('Password should not be empty');
        else if(empty($Password2)) throw new Error('Re-Entered Password should not be empty');
        else if($Password != $Password2) throw new Error("Password doesn't match");
        else {
          $sql_try = "SELECT * from users";
          $result_try = mysqli_query($db, $sql_try);
          while($row_try = mysqli_fetch_array($result_try)) {           
            if($Username == $row_try['username']) {
              throw new Error('Username Already Taken!!!');
            } 
          }

          $createSQL = "INSERT INTO users (username, password, is_admin, is_staff, staff_id, email) VALUES ('$Username', '$Password', '$is_admin', '$is_staff', '$SN', '$Email')";

          mysqli_query($db, $createSQL);

          $success = 'User Created Succesfully';
          // header('Refresh: 1');
        }     
    }  
  }catch (Error $errorData) {
    $error = $errorData->getMessage();
 }
 
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../../css/allstyles.css" />

    <!----===== Boxicons CSS ===== -->

    <link rel="stylesheet" href="../../css/boxicons.min.css" />

    <title>Hotel Management System</title>
  </head>
  <body class="dark">
    <div class="grid-section">
      <div class="left-section">
        <nav class="sidebar">
          <header>
            <div class="text logo-text" style="margin-top: 20px">
              <span class="name">Admin Panel</span>
            </div>

            <!-- <i class="bx bx-chevron-right toggle"></i> -->
          </header>

          <div class="menu-bar">
            <div class="menu">
              <!-- <li class="search-box">
                <i class="bx bx-search icon"></i>
                <input type="text" placeholder="Search..." />
              </li> -->

              <ul class="menu-links">
                <li class="nav-link">
                  <a href="./index.php">
                    <i class="bx bx-home-alt icon"></i>
                    <span class="text nav-text">Dashboard</span>
                  </a>
                </li>

                <li class="nav-link">
                  <a href="./viewstaffs.php">
                    <i class="bx bx-chart icon"></i>
                    <span class="text nav-text">View Staffs</span>
                  </a>
                </li>

                <li class="nav-link">
                  <a href="./addstaffs.php">
                    <i class="bx bx-plus icon"></i>
                    <span class="text nav-text">Add Staffs</span>
                  </a>
                </li>

                <li class="nav-link">
                  <a href="./viewcustomers.php">
                    <i class="bx bx-time icon"></i>
                    <span class="text nav-text">View Customers</span>
                  </a>
                </li>

                <li class="nav-link">
                  <a href="./userprofile.php">
                    <i class="bx bx-user icon"></i>
                    <span class="text nav-text">User Profile</span>
                  </a>
                </li>

                <li class="nav-link">
                  <a href="./viewusers.php">
                    <i class="bx bx-group icon"></i>
                    <span class="text nav-text">View Users</span>
                  </a>
                </li>
                </li>

                <li class="nav-link active">
                  <a href="./createuser.php">
                    <i class="bx bx-plus icon"></i>
                    <span class="text nav-text">Create User</span>
                  </a>
                </li>
              </ul>
            </div>

            <div class="bottom-content">
              <li class="">
                <a href="../../php/logout.php">
                  <i class="bx bx-log-out icon"></i>
                  <span class="text nav-text">Logout</span>
                </a>
              </li>
            </div>
          </div>

        </nav>
      </div>
      <div class="right-section">
        <section class="home">
          <div class="text">Create User</div>
        </section>

        <div class="content">
          <h2 class="heading_title">Create User</h2>

          <div class="content-section">

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

          </div>


          <div class="content-section">
            <div>
             <form action="" method='post'>

            <div class="formgrid createuser">

              <div>
               <!-- <div class="forminput">
                <label for="user_id">User ID</label>
                 <input name='user_id' type="text" class='search-area' readonly placeholder="Enter Username" autocomplete='off' value='<?php echo $getDataRow_user['id'] ?>' />
               </div> -->

               <div class="forminput">
                <label for="email">Email</label>
                 <input name='email' type="email" class='search-area' readonly placeholder="Enter Email" autocomplete='off' value='<?php echo $getDataRow['Email'] ?>' />
               </div>

              </div>

              <div>
               <div class="forminput">
                <label for="username">Username</label>
                 <input name='username' type="text" class='search-area' placeholder="Enter Username" autocomplete='off' />
               </div>

               <div class="forminput">
                <label for="user_status">User Status (Change to Lower Privilege)</label>
                 <select name="user_status" class='search-select-box' id="" >
                   <option value="Admin" <?php echo $getDataRow['Gender'] == 'Admin' ? 'selected' : '' ?> >Admin</option>
                   <option value="Staff" <?php echo $getDataRow['Gender'] == 'Staff' ? 'selected' : '' ?>>Staff</option>
                 </select>
               </div>

              </div>

              <div>
               <div class="forminput">
                <label for="password">Password</label>
                 <input name='password' type="password" class='search-area' placeholder="Enter Password Here" autocomplete='off' />
               </div>

               <div class="forminput">
                <label for="password2">Re-Enter Password</label>
                 <input name='password2' type="password" class='search-area' placeholder="Re-Enter Password Here" autocomplete='off' />
               </div>
              </div>

            </div>

              <div class='createuser-create'>
               <div class='createuser-button'>
                 <button class="button-submit" name='Create'>Create</button>
               </div>
              </div>
             </form>
            </div>

          </div>
        </div>

        <!-- <div class="content">
          <h2 class="heading_title">Change Password</h2>

          <div class="content-section">
            <div>
             <form action="" method='post'>

            <div class="formgrid">

              <div class="forminput">
               <label for="password">Password</label>
                <input name='password' type="text" class='search-area' placeholder="Enter Password Here" autocomplete='off' />
              </div>

              <div class="forminput">
               <label for="password2">Re-Enter Password</label>
                <input name='password2' type="text" class='search-area' placeholder="Re-Enter Password Here" autocomplete='off' />
              </div>

            </div>

              <div>
                <button class="button-submit" name='UpdatePassword'>Update</button>
              </div>

             </form>
            </div>

          </div>
        </div> -->

        <div class="content">
          <h2 class="heading_title">View User Full Details</h2>

          <div class="content-section">
            <div>
             <form action="" method='post'>

            <div class="formgrid">

              <div class="forminput">
               <label for="staff_id">Staff ID</label>
                <input name='staff_id' type="text" class='search-area' readonly placeholder="Enter Username" autocomplete='off' value='<?php echo $getDataRow['SN'] ?>' />
              </div>

              <div class="forminput">
               <label for="firstName">First Name</label>
                <input name='firstName' type="text" class='search-area' readonly placeholder="Enter First Name" autocomplete='off' value='<?php echo $getDataRow['FirstName'] ?>' />
              </div>

              <div class="forminput">
               <label for="lastName">Last Name</label>
                <input name='lastName' type="text" class='search-area' readonly placeholder="Enter Last Name" autocomplete='off' value='<?php echo $getDataRow['LastName'] ?>' />
              </div>

              <div class="forminput">
               <label for="gender">Gender</label>
                <select name="gender" class='search-select-box' id="" disabled='true'>
                  <option value="Male" <?php echo $getDataRow['Gender'] == 'Male' ? 'selected' : '' ?> >Male</option>
                  <option value="Female" <?php echo $getDataRow['Gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                  <option value="NonBinary" <?php echo $getDataRow['Gender'] == 'NonBinary' ? 'selected' : '' ?>>Non Binary</option>
                </select>
              </div>

              <div class="forminput">
               <label for="dob">Date of Birth</label>
                <input type="date" name="dob" class='search-area' readonly value='<?php echo $getDataRow['DOB'] ?>'>
              </div>

               <div class="forminput">
               <label for="email1">Email</label>
                <input name='email1' type="email" class='search-area' readonly placeholder="Enter Email" autocomplete='off' value='<?php echo $getDataRow['Email'] ?>' />
              </div>

              <div class="forminput">
               <label for="job">Job</label>
                <input name='job' type="text" class='search-area' readonly placeholder="Enter Job" autocomplete='off' value='<?php echo $getDataRow['Job'] ?>' />
              </div>

              <div class="forminput">
               <label for="contact">Phone</label>
                <input name='contact' type="text" class='search-area' readonly placeholder="Enter Contact Number" autocomplete='off' value='<?php echo $getDataRow['Contact'] ?>' />
              </div>

              <div class="forminput">
               <label for="address">Address</label>
                <input name='address' type="text" class='search-area' readonly placeholder="Enter Address" autocomplete='off' value='<?php echo $getDataRow['Address'] ?>' />
              </div>

            </div>



              <div>
                <!-- <button class="button-submit" name='Update'>Update</button> -->
              </div>
             </form>
            </div>

          </div>
        </div>

      </div>
    </div>
    <script>
      const body = document.querySelector("body"),
        sidebar = body.querySelector("nav"),
        toggle = body.querySelector(".toggle"),
        searchBtn = body.querySelector(".search-box"),
        modeSwitch = body.querySelector(".toggle-switch"),
        modeText = body.querySelector(".mode-text");

      // body.classList.add("dark");

      // toggle.addEventListener("click", () => {
      //   sidebar.classList.toggle("close");
      // });

      searchBtn.addEventListener("click", () => {
        sidebar.classList.remove("close");
      });

      modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");

        if (body.classList.contains("dark")) {
          modeText.innerText = "Light mode";
        } else {
          modeText.innerText = "Dark mode";
        }
      });
    </script>
  </body>
</html>
