<?php
  require_once('../../php/config.php'); 
  require_once('../../php/session.php');
  require('../../php/staffChecker.php'); 


  try {

    if(isset($_POST["search"])) {
      if ($_POST['search-type'] == "price"){
       $price = $_POST['boxsearch'];
      }
      if ($_POST['search-type'] == "roomnum"){
       $roomnum = $_POST['boxsearch'];
      }
      
      $q = "SELECT * from rooms WHERE 1 = 1 ";

      if(isset($price) && !empty($price)) $q = $q . " AND Price like '%$price%'";
      if(isset($roomnum) && !empty($roomnum)) $q = $q . " AND RoomNumber like '%$roomnum%'";
      

      $result = mysqli_query($db, $q);
      if(mysqli_num_rows($result) == 0) {
        throw new Exception('Results not found. Try Using another Keyword');
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

              <li class="nav-link active">
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
        <div class="text">View Customers</div>
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
                  <option value="roomnum">Room Number</option>
                  <option value="price">Price</option>
                </select>
              </div>

              <button class="button-submit" name='search'>Search</button>

            </form>
          </div>
        </div>
      </div>
      <div class="content">
        <h2 class="heading_title">Staffs List</h2>
        <div class="content-section">
          <div class="content-table">
            <table>
              <thead>
                <tr>
                  <th class="RoomID">Room ID</th>
                  <th class="RoomNumber">Room Number</th>
                  <th class="Status">Status</th>
                  <th class="Price">Price</th>
                </tr>
              </thead>
              <tbody>
                <?php
                     if(!isset($_POST['search'])) {
                      $sql = "SELECT * from rooms";
                      $result = mysqli_query($db, $sql);
                    }
                    while($row = mysqli_fetch_array($result)) {
                     ?>

                <tr>
                  <td><?php echo $row['id'] ?></td>
                  <td><?php echo $row['RoomNumber'] ?></td>

                  <?php

                           $room_number = $row['RoomNumber'];
                           $Status = 'Unoccupied';

                           $sql_test = "SELECT * from customers WHERE (RoomNumber = '$room_number')";
                           $result_test = mysqli_query($db, $sql_test);
                           $row_test = mysqli_fetch_array($result_test);

                             if(isset($row_test)){
                              $Status = 'Occupied';
                             }

                        ?>


                  <td><?php echo $Status ?></td>
                  <td><?php echo 'Rs. '.$row['Price'] ?></td>

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