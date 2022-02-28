<?php
require_once('../../php/config.php'); 
  require_once('../../php/session.php'); 

    $sessionEmail = $_SESSION['email'];
    $sql = "Select * from users where email='$sessionEmail'"; //Selecting row from same 
    $result = mysqli_query($db, $sql);
    
    $row = mysqli_fetch_array($result);
    $db_username = $row['username'];

    //Counting 
    
    $customersCount = $usersCount = $staffsCount = $roomsCount = 0;

    $customersCount = mysqli_fetch_row(mysqli_query($db, "SELECT distinct COUNT(*) from customers"));
    $staffsCount = mysqli_fetch_row(mysqli_query($db, "SELECT distinct COUNT(*) from staffs"));
    $usersCount = mysqli_fetch_row(mysqli_query($db, "SELECT distinct COUNT(*) from users"));
    $roomsCount = mysqli_fetch_row(mysqli_query($db, "SELECT distinct COUNT(*) from rooms"));  


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

    <!--<title>Dashboard Sidebar Menu</title>-->
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
          <div class="text">Dashboard</div>
        </section>

        <div class="content">
          <h2 class="heading_title">Content Heading</h2>

          <div class="content-section">
            
            <div class="card-parent">

              <div class='dashboard-card one'>
                <h3 class='title'>
                  Customers
                </h3>

                <div class='card-icons-all'>
                  <div class="card-icons">
                    <i class="bx bx-chart icon"></i>
                  </div>
                  <div class="card-text">
                    <?php echo $customersCount[0]; ?>
                  </div>
                </div>

              </div>

              <div class='dashboard-card two'>
                <h3 class='title'>
                  Staffs
                </h3>

                <div class='card-icons-all'>
                  <div class="card-icons">
                    <i class="bx bx-group icon"></i>
                  </div>
                  <div class="card-text">
                    <?php echo $staffsCount[0]; ?>
                  </div>
                </div>

              </div>

              <div class='dashboard-card three'>
                <h3 class='title'>
                  Users
                </h3>

                <div class='card-icons-all'>
                  <div class="card-icons">
                    <i class="bx bx-key icon"></i>
                  </div>
                  <div class="card-text">
                    <?php echo $usersCount[0]; ?>
                  </div>
                </div>

              </div>
              
              <div class='dashboard-card four'>
                <h3 class='title'>
                  Rooms
                </h3>

                <div class='card-icons-all'>
                  <div class="card-icons">
                    <i class="bx bx-windows icon"></i>
                  </div>
                  <div class="card-text">
                    <?php echo $roomsCount[0]; ?>
                  </div>
                </div>

              </div>

            </div>

          </div>

        </div>

        <div class="content">
          
          <div class="welcome">
            <h2 class="heading_title">Welcome<?php echo '   ',$db_username .'  '?></h2>
          </div>

          <!-- <div class="content-section">
              Test
          </div> -->

        </div>

        <!-- <div class="content table example">
          <h2 class="heading_title">Content Heading</h2>
          <div class="content-section">
            <div class="content-table">
              <table class='content-table'>
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
