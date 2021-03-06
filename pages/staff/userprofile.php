<?php
  require_once('../../php/config.php'); 
  require_once('../../php/session.php');
  require('../../php/staffChecker.php'); 

  try{

    // $id_user = $_GET['id'];
    $email_user = $_SESSION['email'];
    $sql_user = "SELECT * FROM users WHERE (email = '$email_user')";
    $result_user = mysqli_query($db, $sql_user);
    $getDataRow_user = mysqli_fetch_array($result_user);

    $id_user = $getDataRow_user['id'];

    $old_password = $getDataRow_user['password'];

    $staff_id = $getDataRow_user['staff_id'];

    $sql = "SELECT * FROM staffs WHERE SN = $staff_id";
    $result = mysqli_query($db, $sql);
    $getDataRow = mysqli_fetch_array($result);

    if(isset($_POST['Update'])) {
      $Username = $_POST['username'];
      $Email = $_POST['email'];
        if(empty($Username)) throw new Error('Username should not be empty');
        else if(empty($Email)) throw new Error('Email should not be empty');
        else {
          $sql_try = "SELECT * from users";
          $result_try = mysqli_query($db, $sql_try);
          while($row_try = mysqli_fetch_array($result_try)) {           
            if($Username == $row_try['username'] && $id_user != $row_try['id']) {
              throw new Error('Username Already Taken!!!');
            } 
          }
          $updateSQL = "UPDATE users SET 
              username = '$Username',
              Email = '$Email' WHERE (id = '$id_user')
            ";
          mysqli_query($db, $updateSQL);
          
          $updateSQL_staff = "UPDATE staffs SET email = '$Email' WHERE (SN = '$staff_id')";
          mysqli_query($db, $updateSQL_staff);

          $_SESSION['email'] = $Email;

          $success = 'User Details Updated Succesfully';
          // header('Refresh: 1');
        }     
    } 

    if(isset($_POST['UpdatePassword'])) {
      $Password = $_POST['password'];
      $Password2 = $_POST['password2'];
        if(empty($Password)) throw new Error('Password should not be empty');
        else if(empty($Password2)) throw new Error('Re-Entered Password should not be empty');
        else if($Password != $Password2) throw new Error("Password doesn't match");
        else if($Password == $old_password) throw new Error("Old Password cannot be used");
        else {
          // $sql_try = "SELECT * from users";
          // $result_try = mysqli_query($db, $sql_try);
          // while($row_try = mysqli_fetch_array($result_try)) {           
          //   if($Username == $row_try['username'] && $id_user != $row_try['id']) {
          //     throw new Error('Username Already Taken!!!');
          //   } 
          // }
          $updateSQL = "UPDATE users SET password = '$Password' WHERE (id = '$id_user')";
          mysqli_query($db, $updateSQL);
          
          // $updateSQL_staff = "UPDATE staffs SET email = '$Email' WHERE (SN = '$staff_id')";
          // mysqli_query($db, $updateSQL_staff);

          $success = 'Password Updated Succesfully';
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
  <!-- <link rel="stylesheet" href="style.css" /> -->
  <link rel="stylesheet" href="../../css/allstyles.css" />

  <!----===== Boxicons CSS ===== -->
  <!-- <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    /> -->

  <link rel="stylesheet" href="../../css/boxicons.min.css" />

  <title>Hotel Management System</title>
</head>

<body class="dark">
  <div class="grid-section">
    <div class="left-section">
      <nav class="sidebar">
        <header>
          <div class="text logo-text" style="margin-top: 20px">
            <span class="name">Staff Panel</span>
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
                <a href="./viewcustomers.php">
                  <i class="bx bx-time icon"></i>
                  <span class="text nav-text">View Customers</span>
                </a>
              </li>

              <li class="nav-link">
                <a href="./addcustomers.php">
                  <i class="bx bx-plus icon"></i>
                  <span class="text nav-text">Add Customers</span>
                </a>
              </li>

              <li class="nav-link">
                <a href="./viewrooms.php">
                  <i class="bx bx-windows icon"></i>
                  <span class="text nav-text">View Rooms</span>
                </a>
              </li>

              <li class="nav-link">
                <a href="./viewstaffs.php">
                  <i class="bx bx-chart icon"></i>
                  <span class="text nav-text">View Staffs</span>
                </a>
              </li>

              <li class="nav-link active">
                <a href="./userprofile.php">
                  <i class="bx bx-user icon"></i>
                  <span class="text nav-text">User Profile</span>
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

            <!-- <li class="mode">
                <div class="sun-moon">
                  <i class="bx bx-moon icon moon"></i>
                  <i class="bx bx-sun icon sun"></i>
                </div>
                <span class="mode-text text">Dark mode</span>

                <div class="toggle-switch">
                  <span class="switch"></span>
                </div>
              </li> -->
          </div>
        </div>

      </nav>
    </div>
    <div class="right-section">
      <section class="home">
        <div class="text"><?php echo $getDataRow['FirstName'].' '.$getDataRow['LastName']."'s" ?> Profile</div>
      </section>


      <!-- <div class="content">
          <h2 class="heading_title">Content Heading</h2>
          <div class="content-section">
            <div class="content-table">
              <table>
                <thead>
                  <tr>
                    <th class="SN">SN</th>
                    <th class="Name">Name</th>
                    <th class="Email">Email</th>
                    <th class="Contact">Contact</th>
                    <th class="Address">Address</th>
                    <th class="Action">Action</th>
                  </tr>
                </thead>
                <tbody>
                 <?php
                     for( $i=1; $i<=10; $i++)
                     {
                       echo "<tr>",
                        "<td>$i</td>",
                        "<td>Paras Panta</td>",
                        "<td>Paras.pa1239@gmail.com</td>",
                        "<td>9815110375</td>",
                        "<td>Newroad</td>",
                        "<td>",
                         "<div class='table-link'>",
                           "<a class='buttonLink update' href='http://'>Update</a>",
                           "<a class='buttonLink delete' href='http://'>Delete</a>",
                         "</div>",
                        "</td>",
                        "</tr>";
                     }
                 ?>
                </tbody>
              </table>
            </div>
          </div>
        </div> -->

      <div class="content">
        <h2 class="heading_title">Manage User Details</h2>

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

              <div class="formgrid">

                <div class="forminput">
                  <label for="user_id">User ID</label>
                  <input name='user_id' type="text" class='search-area' readonly placeholder="Enter Username"
                    autocomplete='off' value='<?php echo $getDataRow_user['id'] ?>' />
                </div>

                <div class="forminput">
                  <label for="username">Username</label>
                  <input name='username' type="text" class='search-area' placeholder="Enter Username" autocomplete='off'
                    value='<?php echo $getDataRow_user['username'] ?>' />
                </div>

                <div class="forminput">
                  <label for="email">Email</label>
                  <input name='email' type="email" class='search-area' placeholder="Enter Email" autocomplete='off'
                    value='<?php echo $getDataRow['Email'] ?>' />
                </div>

              </div>

              <div>
                <button class="button-submit" name='Update'>Update</button>
              </div>
            </form>
          </div>

        </div>
      </div>

      <div class="content">
        <h2 class="heading_title">Change Password</h2>

        <div class="content-section">
          <div>
            <form action="" method='post'>

              <div class="formgrid">

                <div class="forminput">
                  <label for="password">Password</label>
                  <input name='password' type="text" class='search-area' placeholder="Enter Password Here"
                    autocomplete='off' />
                </div>

                <div class="forminput">
                  <label for="password2">Re-Enter Password</label>
                  <input name='password2' type="text" class='search-area' placeholder="Re-Enter Password Here"
                    autocomplete='off' />
                </div>

              </div>

              <div>
                <button class="button-submit" name='UpdatePassword'>Update</button>
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