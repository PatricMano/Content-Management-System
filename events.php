<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>What's Happening</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS Files -->
  <link href="assets/css/variables.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: ZenBlog
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/zenblog-bootstrap-blog-template/
  * Author: BootstrapMade.com
  * License: https:///bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>What's Happening</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li class="dropdown"><a href="events.php"><span>Events</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <!-- Modified the links to redirect to the required event type on all pages-->
              <li><a href="events.php">All Events</a></li>
              <li><a href="events.php?Type=Music">Music</a></li>
              <li><a href="events.php?Type=Art%2BCulture">Art+Culture</a></li>
              <li><a href="events.php?Type=Sports">Sport</a></li>
              <li><a href="events.php?Type=Food">Food</a></li>
              <li><a href="events.php?Type=Fund Raiser">Fund Raiser</a></li>
            </ul>
          </li>
          <!-- Added Post Event on all pages-->
          <li><a href="groups.php">Community Groups</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="post.php">Post Event</a></li>
          <li class="dropdown"><a href="#"><span>Login</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <?php
              session_start();
              if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                  echo '<li><a href="#">Login</a></li>';
              }
              else {
                  echo '<li><a href="login.php">Login</a></li>';
              }
              ?>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        <a href="#" class="mx-2"><span class="bi-facebook"></span></a>
        <a href="#" class="mx-2"><span class="bi-twitter"></span></a>
        <a href="#" class="mx-2"><span class="bi-instagram"></span></a>

        <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
        <i class="bi bi-list mobile-nav-toggle"></i>

        <!-- ======= Search Form ======= -->
        <div class="search-form-wrap js-search-form-wrap">
          <form action="search-result.html" class="search-form">
            <span class="icon bi-search"></span>
            <input type="text" placeholder="Search" class="form-control">
            <button class="btn js-search-close"><span class="bi-x"></span></button>
          </form>
        </div><!-- End Search Form -->

      </div>

    </div>

  </header><!-- End Header -->

  <main id="main">
    <section>
      <div class="container">
        <div class="row">

          <div class="col-md-9" data-aos="fade-up">
            <!--Changed the heading-->
          
          <?php
          date_default_timezone_set('America/Halifax');
          
          //Checks if Type is in the URL
          if ($_GET['Type']) {
            //assigns Type to $navType
            $navType = $_GET['Type'];
          } else {
            $navType = null;
          }
          
          //If there is a type then the type is printed on the Category heading if not then it prints all in the heading
          if ($navType){
            echo "<h3 class='category-title'> Event Category: $navType</h3>";
          }
          else {
            echo "<h3 class='category-title'>Event Category: all</h3>";
          }

          //uses serverlogin in the file
          require_once 'serverlogin.php';

          //Connects with database
          $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
          mysqli_select_db($conn, $db_database)
          or die("Unable to select database: " . mysql_error());

          //SQL query that fetches required info from events, groups, and eventtypes tables
          $query = "SELECT EventID, EventTitle, EventType, GroupImage, GroupName, EventDate, EventImage FROM events
          INNER JOIN eventtypes ON (events.EventTypeID = eventtypes.EventTypeID)
          INNER JOIN groups ON (events.GroupID = groups.GroupID)
          WHERE EventDate >= CURDATE()
          ORDER BY EventDate ASC";
          $result = mysqli_query ($conn,$query);

          //Checks if there are results
          if ($result->num_rows > 0) {
            //loops through each row
            while ($row = $result->fetch_assoc()) {
              $eventNumber = $row["EventID"];
              $eventTitle = $row["EventTitle"];
              $eventType = $row["EventType"];
              $groupImage = $row["GroupImage"];
              $groupName = $row["GroupName"];
              $eventDate = date_create($row["EventDate"]);
              $formattedDate = date_format($eventDate, "d-M-y");
              $formattedTime = date_format($eventDate, "h:i A");
              $eventImage = $row["EventImage"];


              //Sorts the the page according to event categories
              if ($navType == null || $eventType == $navType) {
              //Uses Heredoc to print the necessary values on proper format in the webpage
              echo <<<BODY
              <div class="d-md-flex post-entry-2 half">
                  <a href="single-post.php?Number=$eventNumber" class="me-4 thumbnail">
                    <img src="$eventImage" alt="" class="img-fluid">
                  </a>
                  <div>
                    <div class="post-meta" style="color: black;"><span class="date">$eventType</span> <span class="mx-1">&bullet;</span> <span>$formattedDate</span> <span class="mx-1">&bullet;</span> <span>$formattedTime</span></div> 
                    <h3><a href="single-post.php?Number=$eventNumber">$eventTitle</a></h3>
                    <div class="d-flex align-items-center author">
                      <div class="photo"><img src="$groupImage" alt="" class="img-fluid"></div>
                      <div class="name">
                        <h3 class="m-0 p-0">$groupName</h3>
                      </div>
                    </div>
                  </div>
                </div>
              BODY;
              }
            }
          }
          else {
            echo "Nothing here to display! Sorry!";
        }
        $conn->close();
          ?>
          <div class="text-start py-4">
              <div class="custom-pagination">
                <a href="#" class="prev">Prevous</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#" class="next">Next</a>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <!-- ======= Sidebar ======= -->
            <div class="aside-block">
              <!--Changed the column slider and removed one of the slides-->
              <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill" data-bs-target="#pills-popular" type="button" role="tab" aria-controls="pills-popular" aria-selected="true">Upcoming</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill" data-bs-target="#pills-trending" type="button" role="tab" aria-controls="pills-trending" aria-selected="false">Latest Added</button>
                </li>
                </ul>
              <div class="tab-content" id="pills-tabContent">   
                <?php
                require_once 'serverlogin.php';
                $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
                mysqli_select_db($conn, $db_database)
                or die("Unable to select database: " . mysqli_error($conn)); 
                
                // Fetches upcoming events by finding the events that are closest to current date
                //CURDATE from: https://www.w3schools.com/sql/func_mysql_curdate.asp
                $upcomingQuery = "SELECT EventID, EventTitle, EventType, GroupName, EventDate FROM events
                INNER JOIN eventtypes ON (events.EventTypeID = eventtypes.EventTypeID)
                INNER JOIN groups ON (events.GroupID = groups.GroupID)
                WHERE EventDate >= CURDATE()
                ORDER BY EventDate ASC";
                $upcomingResult = mysqli_query($conn, $upcomingQuery);
                if ($upcomingResult->num_rows > 0) {
                  while ($upcomingRow = $upcomingResult->fetch_assoc()) {
                    $upcomingEventID = $upcomingRow["EventID"];
                    $upcomingEventTitle = $upcomingRow["EventTitle"];
                    $upcomingEventType = $upcomingRow["EventType"];
                    $upcomingGroupName = $upcomingRow["GroupName"];
                    $upcomingEventDate = $upcomingRow["EventDate"];
                    $upcomingFormattedDate = date_format(date_create($upcomingEventDate), "d-M-y");
                    
                    //Heredoc shows the data on proper format
                      echo <<<UPCOMING
                        <div class="tab-pane fade show active" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
                          <div class="post-entry-1 border-bottom">
                            <div class="post-meta" style="color: black"><span class="date">$upcomingEventType</span> <span class="mx-1">&bullet;</span> <span>$upcomingFormattedDate</span></div>
                              <h2 class="mb-2"><a href="single-post.php?Number=$upcomingEventID">$upcomingEventTitle</a></h2>
                              <span class="author mb-3 d-block">$upcomingGroupName</span>
                          </div>
                        </div>   
                      UPCOMING;
                        }
                      }
                      else {
                        echo "Nothing here to display! Sorry!";
                      }

                      $latestQuery = "SELECT EventID, EventTitle, EventType, GroupName, EventDate FROM events
                      INNER JOIN eventtypes ON (events.EventTypeID = eventtypes.EventTypeID)
                      INNER JOIN groups ON (events.GroupID = groups.GroupID)
                      ORDER BY SubmitDate DESC";
                      $latestResult = mysqli_query($conn, $latestQuery);
                      if ($latestResult->num_rows > 0) {
                        while ($latestRow = $latestResult->fetch_assoc()){
                          $latestEventID = $latestRow["EventID"];
                          $latestEventTitle = $latestRow["EventTitle"];
                          $latestEventType = $latestRow["EventType"];
                          $latestGroupName = $latestRow["GroupName"];
                          $latestEventDate = $latestRow["EventDate"];
                          $latestFormattedDate = date_format(date_create($latestEventDate), "d-M-y");
                      echo <<<LATEST
                      <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">
                        <div class="post-entry-1 border-bottom">
                          <div class="post-meta" style="color: black"><span class="date">$latestEventType</span> <span class="mx-1">&bullet;</span> <span>$latestFormattedDate</span></div>
                              <h2 class="mb-2"><a href="single-post.php?Number=$latestEventID">$latestEventTitle</a></h2>
                              <span class="author mb-3 d-block">$latestGroupName</span>
                        </div>
                      </div>
                      LATEST;
                    }
                  }
                  else {
                    echo "Nothing here to display! Sorry!";
                  }
                  $conn->close();
                ?>
              </div>
            </div>
            <!--Removed Video section and Modified the Categories and Tags section-->
            <div class="aside-block">
              <h3 class="aside-title">Events</h3>
              <ul class="aside-links list-unstyled">
                <li><a href="events.php"><i class="bi bi-chevron-right"></i> All Events</a></li>
                <li><a href="events.php?Type=Music"><i class="bi bi-chevron-right"></i> Music</a></li>
                <li><a href="events.php?Type=Art%2BCulture"><i class="bi bi-chevron-right"></i> Art+Culture</a></li>
                <li><a href="events.php?Type=Sports"><i class="bi bi-chevron-right"></i> Sport</a></li>
                <li><a href="events.php?Type=Food"><i class="bi bi-chevron-right"></i> Food</a></li>
                <li><a href="events.php?Type=Fund Raiser"><i class="bi bi-chevron-right"></i> Fund Raiser</a></li>
              </ul>
            </div><!-- End Categories -->

            <div class="aside-block">
              <h3 class="aside-title">Tags</h3>
              <ul class="aside-tags list-unstyled">
                <li><a href="events.php">All Events</a></li>
                <li><a href="events.php?Type=Music">Music</a></li>
                <li><a href="events.php?Type=Art%2BCulture">Art+Culture</a></li>
                <li><a href="events.php?Type=Sports">Sport</a></li>
                <li><a href="events.php?Type=Food">Food</a></li>
                <li><a href="events.php?Type=Fund Raiser">Fund Raiser</a></li>
              </ul>
            </div><!-- End Tags -->

          </div>

        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-content">
      <div class="container">

        <div class="row g-5">
          <div class="col-lg-4">
            <h3 class="footer-heading">About What's Happening</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam ab, perspiciatis beatae autem deleniti voluptate nulla a dolores, exercitationem eveniet libero laudantium recusandae officiis qui aliquid blanditiis omnis quae. Explicabo?</p>
            <!-- Redirects to about.php on all pages-->                          
            <p><a href="about.php" class="footer-link-more">Learn More</a></p>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Navigation</h3>
            <ul class="footer-links list-unstyled">

            <!-- Added Post Event on all pages-->              
              <li><a href="index.php"><i class="bi bi-chevron-right"></i> Home</a></li>
              <li><a href="events.php"><i class="bi bi-chevron-right"></i> Events</a></li>
              <li><a href="groups.php"><i class="bi bi-chevron-right"></i> Community Groups</a></li>
              <li><a href="about.php"><i class="bi bi-chevron-right"></i> About</a></li>
              <li><a href="post.php"><i class="bi bi-chevron-right"></i> Post Event</a></li>
              <?php
              if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                  echo '<li><a href="#"><i class="bi bi-chevron-right"></i> Login</a></li>';
              }
              else {
                  echo '<li><a href="login.php"><i class="bi bi-chevron-right"></i> Login</a></li>';
              }
              ?>
            </ul>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Events</h3>
            <ul class="footer-links list-unstyled">
              <!-- Modified the links to redirect to the required event type on all pages-->
              <li><a href="events.php"><i class="bi bi-chevron-right"></i> All Events</a></li>
              <li><a href="events.php?Type=Music"><i class="bi bi-chevron-right"></i> Music</a></li>
              <li><a href="events.php?Type=Art%2BCulture"><i class="bi bi-chevron-right"></i> Art+Culture</a></li>
              <li><a href="events.php?Type=Sports"><i class="bi bi-chevron-right"></i> Sport</a></li>
              <li><a href="events.php?Type=Food"><i class="bi bi-chevron-right"></i> Food</a></li>
              <li><a href="events.php?Type=Fund Raiser"><i class="bi bi-chevron-right"></i> Fund Raiser</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-legal">
      <div class="container">

        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span>ZenBlog</span></strong>. All Rights Reserved
            </div>

            <div class="credits">
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>

          </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

        </div>

      </div>
    </div>

  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>