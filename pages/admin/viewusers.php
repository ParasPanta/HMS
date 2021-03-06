<?php
  require_once('../../php/config.php'); 
  require_once('../../php/session.php'); 
  require('../../php/adminChecker.php');

  try {
    if(isset($_GET["del"])){
        $sn = $_GET['del'];

        $sql = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($db, $sql);
        $getDataRow = mysqli_fetch_array($result);

        $del_sql = "DELETE FROM staffs where id = '$id'";
        mysqli_query($db, $del_sql);
        // $deleteMsg = "Staff named $getDataRow['FirstName'] $getDataRow['LastName'] with SN = $sn has been deleted successfully";

        $deletedMsg = 'Staff named '.$getDataRow['FirstName'].' '.$getDataRow['LastName'].' having SN of '.$sn.' has been deleted successfully';
      }
    
    if(isset($_POST['reset'])) {
      $sql_out = "SELECT * from users";
      $result_out = mysqli_query($db, $sql_out);
    }

    if(isset($_POST["search"])) {
      if ($_POST['search-type'] == "firstName"){
       $firstname = $_POST['boxsearch'];
      }
      if ($_POST['search-type'] == "lastName"){
       $lastname = $_POST['boxsearch'];
      }

      if ($_POST['search-type'] == "age"){
       $age = $_POST['boxsearch'];
       $nowyear = date("Y");
       $year1 = (int)$nowyear - (int)$age;
       $year2 = (int)$nowyear - (int)$age - 1;
       $year3 = (int)$nowyear - (int)$age + 1;

      //  echo $year1, $year1,$year1,$year1,$year1,$year1;
      }
      if ($_POST['search-type'] == "gender"){
       $gender = $_POST['boxsearch'];

      //  echo $gender, $gender, $gender, $gender, $gender, $gender, $gender, $gender;
      }
      if ($_POST['search-type'] == "email"){
       $email = $_POST['boxsearch'];
      }
      if ($_POST['search-type'] == "job"){
       $job = $_POST['boxsearch'];
      }
      if ($_POST['search-type'] == "contact"){
       $contact = $_POST['boxsearch'];
      }
      if ($_POST['search-type'] == "address"){
       $address = $_POST['boxsearch'];
      }
      
      $q = "SELECT * from staffs WHERE 1 = 1 ";

      if(isset($firstname) && !empty($firstname)) $q = $q . " AND FirstName like '%$firstname%'";
      if(isset($lastname) && !empty($lastname)) $q = $q . " AND LastName like '%$lastname%'";

      if(isset($age) && !empty($age)) $q = $q . " AND DOB like '$year1%' OR DOB like '$year2%' OR DOB like '$year3%'";
      // if(isset($age) && !empty($age)) $q = $q . " '";
      // if(isset($age) && !empty($age)) $q = $q . " '";

      if(isset($email) && !empty($email)) $q = $q . " AND email like '%$email%'";
      if(isset($gender) && !empty($gender)) $q = $q . " AND gender like '%$gender%'";
      if(isset($job) && !empty($job)) $q = $q . " AND job like '%$job%'";
      if(isset($contact) && !empty($contact)) $q = $q . " AND contact like '%$contact%'";
      if(isset($address) && !empty($address)) $q = $q . " AND address like '%$address%'";

      if ($_POST['search-type'] == "username"){
       $username = $_POST['boxsearch'];

        $q = "SELECT * from users WHERE username like '%$username%' ";
      }

      $result_out = mysqli_query($db, $q);
      if(mysqli_num_rows($result_out) == 0) {
        throw new Exception('Results not found. Try Using another Keyword');
      }
      

      if($_POST['search-type'] != "username"){
        $result_search = mysqli_query($db, $q);
        if(mysqli_num_rows($result_search) == 0) {
          throw new Exception('Results not found. Try Using another Keyword');
        }

        $q_search = "SELECT * from users WHERE staff_id in (";
        
        while($row_search = mysqli_fetch_array($result_search)) {

          $SID = $row_search['SN'];
          $q_search = $q_search . "'$SID',";
        }

        $q_search = $q_search . "'$SID')";


        $result_out = mysqli_query($db, $q_search);
        if(mysqli_num_rows($result_out) == 0) {
          throw new Exception('Results not found. Try Using another Keyword');
        }
      }
    }
  } catch (Exception $errorData) {
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

              <li class="nav-link active">
                <a href="./viewusers.php">
                  <i class="bx bx-group icon"></i>
                  <span class="text nav-text">View Users</span>
                </a>
              </li>
              </li>

              <li class="nav-link">
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
        <div class="text">View Users</div>
      </section>
      <div class="content">
        <h2 class="heading_title">Search</h2>

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

          <div class="message-div">
            <?php if(isset($deletedMsg)){  ?>
            <div class="message-error">
              <?php echo $deletedMsg; ?>
            </div>
            <?php } ?>
          </div>

        </div>



        <div class="content-section">
          <!-- <div>
                <input type="text" class='search-area' placeholder="Search..." />
            </div> -->

          <div>
            <form action="" method='post'>
              <input name='boxsearch' type="search" class='search-area' placeholder="Search..." autocomplete='off' />

              <div class="searchselect">
                <select class='search-select-box' name="search-type" id="seacrh-by">
                  <option value="firstName">First Name</option>
                  <option value="lastName">Last Name</option>
                  <option value="username">Username</option>
                  <option value="age">Age</option>
                  <option value="gender">Gender</option>
                  <option value="email">Email</option>
                  <option value="job">Job</option>
                </select>
              </div>

              <!-- <input class='button-submit' type="submit" value="Submit"> -->
              <button class="button-submit" name='search'>Search</button>
              <button class="button-submit reset" name='reset'>Reset</button>

            </form>
          </div>
        </div>
      </div>
      <div class="content">
        <h2 class="heading_title">Users List</h2>
        <div class="content-section">
          <div class="content-table">
            <table>
              <thead>
                <tr>
                  <th class="ID">ID</th>
                  <!-- <th class="ID">ID</th> -->
                  <th class="Name">Name</th>
                  <th class="Username">Username</th>
                  <th class="Status">Status</th>
                  <th class="Age_Gender">Age:Gender</th>
                  <th class="Email">Email</th>
                  <th class="Job">Job</th>
                  <th class="Action">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                     if(!isset($_POST['search'])) {
                      $sql_out = "SELECT * from users";
                      $result_out = mysqli_query($db, $sql_out);
                    }
                    while($row_out = mysqli_fetch_array($result_out)) {
                     ?>

                <tr>

                  <?php
                              $user_staff_id = $row_out['staff_id'];

                              $sql = "SELECT * from staffs WHERE SN = $user_staff_id";
                              $result = mysqli_query($db, $sql);
                              $row = mysqli_fetch_array($result)

                          ?>

                  <td><?php echo $row_out['id'] ?></td>
                  <!-- <td><?php echo $row['SN'] ?></td> -->

                  <?php 

                              $nowyear = date("Y");
                              $nowmonth = date("m");
                              $year = (int)substr($row['DOB'], 0, 4);
                              $month = (int)substr($row['DOB'], 6, 7);

															if($nowmonth >= $month){
																	$age = $nowyear - $year;
															}
															else{
																$age = $nowyear - $year -1;
															}

														?>

                  <td><?php echo $row['FirstName'].' '.$row['LastName'] ?></td>
                  <td><?php echo $row_out['username'] ?></td>

                  <td>
                    <?php

                            if($row_out['is_admin'] == 1 && $row_out['is_staff'] == 0)
                            {
                              echo 'Admin';
                            }
                            elseif ($row_out['is_staff'] == 1 && $row_out['is_admin'] == 0) {
                              echo 'Staff';
                            }                            

                        ?>
                  </td>


                  <td><?php echo $age.' : '.$row['Gender'] ?></td>
                  <td><?php echo $row['Email'] ?></td>
                  <td><?php echo $row['Job'] ?></td>
                  <td>
                    <div class='table-link'>
                      <a class='buttonLink view' href='viewuserdetails.php?id=<?php echo $row_out['id'] ?>'>View</a>
                      <a class='buttonLink update' href='updateusers.php?id=<?php echo $row_out['id'] ?>'>Update</a>
                    </div>
                  </td>
                </tr>

                <?php } ?>
              </tbody>
            </table>
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