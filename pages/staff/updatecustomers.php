<?php
  require_once('../../php/config.php'); 
  require_once('../../php/session.php');
  require('../../php/staffChecker.php'); 

  try{

    $sn = $_GET['SN'];
    $sql = "SELECT * FROM customers WHERE SN = $sn";
    $result = mysqli_query($db, $sql);
    $getDataRow = mysqli_fetch_array($result);

    if(isset($_POST['Update'])) {
      $FirstName = $_POST['firstName'];
      $LastName = $_POST['lastName'];
      $Gender = $_POST['gender'];
      $DOB = $_POST['dob'];
      $Email = $_POST['email'];
      $Contact = $_POST['contact'];
      $Address = $_POST['address'];
      $RoomNum = $_POST['roomnum'];

        if(empty($FirstName)) throw new Error('First Name should not be empty');
        else if(empty($LastName)) throw new Error('Last Name should not be empty');
        else if($Gender  === 'default') throw new Error('Gender should not be empty');
         else if(empty($DOB)) throw new Error('Date of Birth should not be empty');
         else if(empty($Contact)) throw new Error('Phone should not be empty');
         else if(empty($Email)) throw new Error('Email should not be empty');
         else if(empty($Address)) throw new Error('Address should not be empty');
         else if(empty($RoomNum)) throw new Error('Room Number should not be empty');
        //  else if($RoomNum == $row_try['RoomNumber']) throw new Error('Room Already taken');
        //  else{
           
        //  }
        else {
          $sql_try = "SELECT * from customers";
          $result_try = mysqli_query($db, $sql_try);
          while($row_try = mysqli_fetch_array($result_try)) {           
            if($Email == $row_try['Email'] && $Contact == $row_try['Contact']  && $Address == $row_try['Address'] && $sn != $row['SN']) {
              throw new Error('Customers Details Already Exist!!!');
            }
            else if($RoomNum == $row_try['RoomNumber']) throw new Error('Room Already taken');
          }
          $updateSQL = "UPDATE customers SET 
              FirstName = '$FirstName',
              LastName = '$LastName', 
              Gender = '$Gender', 
              DOB = '$DOB', 
              Contact = '$Contact', 
              Email = '$Email', 
              RoomNumber = '$RoomNum',
              Address = '$Address' WHERE (SN = '$sn')
            ";
          mysqli_query($db, $updateSQL);
          $success = 'Customer Details Updated Succesfully';
          header('Refresh: 2');
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

              <li class="nav-link active">
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

              <li class="nav-link">
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
        <div class="text">Manage Customers</div>
      </section>
      <div class="content">
        <h2 class="heading_title">Manage Customer Details</h2>

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
                  <label for="firstName">First Name</label>
                  <input name='firstName' type="text" class='search-area' placeholder="Enter First Name"
                    autocomplete='off' value='<?php echo $getDataRow['FirstName'] ?>' />
                </div>

                <div class="forminput">
                  <label for="lastName">Last Name</label>
                  <input name='lastName' type="text" class='search-area' placeholder="Enter Last Name"
                    autocomplete='off' value='<?php echo $getDataRow['LastName'] ?>' />
                </div>

                <div class="forminput">
                  <label for="gender">Gender</label>
                  <select name="gender" class='search-select-box' id="">
                    <option value="Male" <?php echo $getDataRow['Gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?php echo $getDataRow['Gender'] == 'Female' ? 'selected' : '' ?>>Female
                    </option>
                    <option value="NonBinary" <?php echo $getDataRow['Gender'] == 'NonBinary' ? 'selected' : '' ?>>Non
                      Binary</option>
                  </select>
                </div>

                <div class="forminput">
                  <label for="dob">Date of Birth</label>
                  <input type="date" name="dob" class='search-area' value='<?php echo $getDataRow['DOB'] ?>'>
                </div>

                <div class="forminput">
                  <label for="email">Email</label>
                  <input name='email' type="email" class='search-area' placeholder="Enter Email" autocomplete='off'
                    value='<?php echo $getDataRow['Email'] ?>' />
                </div>

                <!-- <div class="forminput">
               <label for="roomnum">Room Number</label>
                <input name='roomnum' type="text" class='search-area' placeholder="Enter Room Number" autocomplete='off' value='<?php echo $getDataRow['RoomNumber'] ?>' />
              </div> -->

                <div class="forminput">
                  <label for="roomnum">Room Number</label>
                  <select name="roomnum" class='search-select-box' id="">

                    <?php
                    $sql_rooms = "SELECT * from rooms";
                    $result_rooms = mysqli_query($db, $sql_rooms);
                    
                    while ($row_rooms = mysqli_fetch_array($result_rooms)) { ?>

                    <?php $room_number =  $row_rooms['RoomNumber']; ?>

                    <option value="$room_number" <?php echo $room_number == '$room_number' ? 'selected' : '' ?>>
                      <?php echo $getDataRow['RoomNumber'] ?></option>

                    <!-- <option value="<?php echo $row_rooms['RoomNumber'] ?>" ><?php echo $row_rooms['RoomNumber'] ?></option> -->

                    <?php
                    }
                  ?>
                  </select>
                </div>


                <div class="forminput">
                  <label for="contact">Phone</label>
                  <input name='contact' type="text" class='search-area' placeholder="Enter Contact Number"
                    autocomplete='off' value='<?php echo $getDataRow['Contact'] ?>' />
                </div>

                <div class="forminput">
                  <label for="address">Address</label>
                  <input name='address' type="text" class='search-area' placeholder="Enter Address" autocomplete='off'
                    value='<?php echo $getDataRow['Address'] ?>' />
                </div>

              </div>

              <div>
                <button class="button-submit" name='Update'>Update</button>
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

  // Calculate age 
  // $(document).ready(function(){
  //   $("#txtDOB").change(function(){
  //     var dob = $("#txtDOB").val();

  //     if(dob != null || dob != ""){
  //       $("#age").val(getAge(dob));
  //     }
  //   });

  //     function getAge(birth) {
  //       ageMS = Date.parse(Date()) - Date.parse(birth);
  //       age = new Date();
  //       age.setTime(ageMS);
  //       ageYear = age.getFullYear() - 1970;

  //       return ageYear;
  //       }
  //   });
  </script>
</body>

</html>