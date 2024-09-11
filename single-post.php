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
              <li><a href="events.php">All Events</a></li>
              <li><a href="events.php?Type=Music">Music</a></li>
              <li><a href="events.php?Type=Art%2BCulture">Art+Culture</a></li>
              <li><a href="events.php?Type=Sports">Sport</a></li>
              <li><a href="events.php?Type=Food">Food</a></li>
              <li><a href="events.php?Type=Fund Raiser">Fund Raiser</a></li>
            </ul>
          </li>
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

    <section class="single-post-content">
      <div class="container">
        <div class="row">
          <div class="col-md-9 post-content" data-aos="fade-up">

            <!-- ======= Single Post Content ======= -->
            <?php
            date_default_timezone_set('America/Halifax');

            require_once 'serverlogin.php';
            $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
            mysqli_select_db($conn, $db_database)
            or die("Unable to select database: " . mysql_error());
  
            //SQL query that fetches required info from events, groups, and eventtypes tables
            $query = "SELECT EventID, EventTitle, EventType, GroupName, EventDate, EventImage, ContactName, ContactEmail, EventDesc FROM events
            INNER JOIN eventtypes ON (events.EventTypeID = eventtypes.EventTypeID)
            INNER JOIN groups ON (events.GroupID = groups.GroupID)
            ORDER BY EventDate ASC";
            $result = mysqli_query ($conn,$query);

            //gets the number from the URL and assigns it to $eventNumber
            if ($_GET['Number']) {
              $eventNumber = $_GET['Number'];
            }
            //Goes through the array and assigns them to variables only if $row["EventID"] == $eventNumber
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                if ($row["EventID"] == $eventNumber) {
                $eventTitle = $row["EventTitle"];
                $eventType = $row["EventType"];
                $groupName = $row["GroupName"];

                $eventDate = date_create($row["EventDate"]);
                $formattedDate = date_format($eventDate, "D d M, Y");
                $formattedTime = date_format($eventDate, "h:i A");
                $eventImage = $row["EventImage"];
                $contactName = $row["ContactName"];
                $contactEmail = $row["ContactEmail"];
                $eventDesc = $row["EventDesc"];
              //Assigning the first character to a variable so it can be formatted later properly
              $firstChar = $eventDesc[0];
              //makes the event description a substr so it can skip the first character
              //Used substr learned from https://www.w3schools.com/php/func_string_substr.asp
              $eventDesc = substr($eventDesc, 1);

              //Uses Heredoc to print the necessary values on proper format in the webpage
              echo <<<BODY
            <div class="single-post" style="margin: 0 auto;">
              <div class="post-meta" style="color: black;"><span class="date">$eventType</span> <span class="mx-1">&bullet;</span> <span>Date: $formattedDate</span> <span>Time: $formattedTime</span></div> 
              <br>
              <h1 class="mb-5">$eventTitle</h1>
              <h3>Organizers: $groupName</h3>
              <h4 class="mb-5">(Contact $contactName at $contactEmail for more info)</h4>
              <p style="margin-bottom: 10px";"><span class="firstcharacter">$firstChar</span>$eventDesc</p>
                <img src="$eventImage" alt="" class="img-fluid" width = "700" height = "600">
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
            <!-- End Single Post Content -->
            <!-- ======= Comments ======= -->
            <div class="comments">
              <h5 class="comment-title py-4">2 Comments</h5>
              <div class="comment d-flex mb-4">
                <div class="flex-shrink-0">
                  <div class="avatar avatar-sm rounded-circle">
                    <img class="avatar-img" src="assets/img/person-5.jpg" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="flex-grow-1 ms-2 ms-sm-3">
                  <div class="comment-meta d-flex align-items-baseline">
                    <h6 class="me-2">Jordan Singer</h6>
                    <span class="text-muted">2d</span>
                  </div>
                  <div class="comment-body">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non minima ipsum at amet doloremque qui magni, placeat deserunt pariatur itaque laudantium impedit aliquam eligendi repellendus excepturi quibusdam nobis esse accusantium.
                  </div>

                  <div class="comment-replies bg-light p-3 mt-3 rounded">
                    <h6 class="comment-replies-title mb-4 text-muted text-uppercase">2 replies</h6>

                    <div class="reply d-flex mb-4">
                      <div class="flex-shrink-0">
                        <div class="avatar avatar-sm rounded-circle">
                          <img class="avatar-img" src="assets/img/person-4.jpg" alt="" class="img-fluid">
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-2 ms-sm-3">
                        <div class="reply-meta d-flex align-items-baseline">
                          <h6 class="mb-0 me-2">Brandon Smith</h6>
                          <span class="text-muted">2d</span>
                        </div>
                        <div class="reply-body">
                          Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                        </div>
                      </div>
                    </div>
                    <div class="reply d-flex">
                      <div class="flex-shrink-0">
                        <div class="avatar avatar-sm rounded-circle">
                          <img class="avatar-img" src="assets/img/person-3.jpg" alt="" class="img-fluid">
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-2 ms-sm-3">
                        <div class="reply-meta d-flex align-items-baseline">
                          <h6 class="mb-0 me-2">James Parsons</h6>
                          <span class="text-muted">1d</span>
                        </div>
                        <div class="reply-body">
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio dolore sed eos sapiente, praesentium.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="comment d-flex">
                <div class="flex-shrink-0">
                  <div class="avatar avatar-sm rounded-circle">
                    <img class="avatar-img" src="assets/img/person-2.jpg" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="flex-shrink-1 ms-2 ms-sm-3">
                  <div class="comment-meta d-flex">
                    <h6 class="me-2">Santiago Roberts</h6>
                    <span class="text-muted">4d</span>
                  </div>
                  <div class="comment-body">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto laborum in corrupti dolorum, quas delectus nobis porro accusantium molestias sequi.
                  </div>
                </div>
              </div>
            </div><!-- End Comments -->

            <!-- ======= Comments Form ======= -->
            <div class="row justify-content-center mt-5">

              <div class="col-lg-12">
                <h5 class="comment-title">Leave a Comment</h5>
                <div class="row">
                  <div class="col-lg-6 mb-3">
                    <label for="comment-name">Name</label>
                    <input type="text" class="form-control" id="comment-name" placeholder="Enter your name">
                  </div>
                  <div class="col-lg-6 mb-3">
                    <label for="comment-email">Email</label>
                    <input type="text" class="form-control" id="comment-email" placeholder="Enter your email">
                  </div>
                  <div class="col-12 mb-3">
                    <label for="comment-message">Message</label>

                    <textarea class="form-control" id="comment-message" placeholder="Enter your name" cols="30" rows="10"></textarea>
                  </div>
                  <div class="col-12">
                    <input type="submit" class="btn btn-primary" value="Post comment">
                  </div>
                </div>
              </div>
            </div><!-- End Comments Form -->

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

                      // Fetches latest events by ordering events with the most recent submit date
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

                      //Heredoc shows the data on proper format
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
            <p><a href="about.php" class="footer-link-more">Learn More</a></p>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Navigation</h3>
            <ul class="footer-links list-unstyled">
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