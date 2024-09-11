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

  <!--Changed the title and the submit button-->
  <main id="main">
    <section id="contact" class="contact mb-5">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="page-title">Post New Event</h1>
                </div>
            </div>
            <div class="form mt-5">
            <style>
            .login {
                box-shadow: 0 0 30px rgba(var(--color-black-rgb), 0.1);
                padding: 30px;
                background: var(--color-white);
                
              }
            @media (max-width: 640px) {
                    .login {
                  padding: 20px;
                  }
            }

            .form-group {
                margin-bottom: 20px;
            }

            .login input {
              padding: 10px 14px;
              border-radius: 0;
              box-shadow: none;
              font-size: 15px;
            }

            .login button[type=submit] {
              background-color: #189454;
              border: 0;
              padding: 10px 20px 10px 20px;
              color: #fff;
              transition: 0.4s;
              cursor: pointer;
              margin-bottom: 20px;
            }

            .error {
              font-weight: 590;
            }

            .gpname {
              text-align: center;
              font-weight: 595;
              padding-bottom: 35px;
            }

            </style>
                    <?php
                    session_start();
                    
                    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                        header("location: login.php");
                        exit;
                    }              
                    include_once "serverlogin.php";
                    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
                    mysqli_select_db($conn, $db_database) or die("Unable to select database: " . mysql_error());

                    // Checks if all form fields are filled
                    

                        //assign form values to variables
                      
                        $groupID = $_SESSION["GroupID"];
                        //fetches GroupName using GroupID from Session login 
                        $query = "SELECT GroupName FROM Groups WHERE groupid = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $groupID);
                        $stmt->execute();
                        $stmt->bind_result($groupName);
                        $stmt->fetch();
                        $stmt->close();

                        if (!empty($_POST["type"]) && !empty($_POST["date"]) && !empty($_POST["title"]) && !empty($_POST["desc"]) && !empty($_POST["image"]) && !empty($_POST["time"])) {
                         $eventType = $_POST["type"];
                        $eventTitle = $_POST["title"];
                        $eventDesc = $_POST["desc"];
                        $eventImage = "files/images/events/" . $_POST["image"];
                        //concatenates date and time from the form and converts the string to timestamp format and formats it properly
                        $eventDateTime = date('Y-m-d H:i:s', strtotime($_POST["date"] . ' ' . $_POST["time"]));
                        //submitDate achieved by getting local time date
                        $submitDateTime = date('Y-m-d H:i:s');
                        //fetches EventTypeID using EventType from form input
                        $typeQuery = "SELECT EventTypeID FROM EventTypes WHERE eventtype = ?";
                        $typeStatement = $conn->prepare($typeQuery);
                        $typeStatement->bind_param("s", $eventType);
                        $typeStatement->execute();
                        $typeResult = $typeStatement->get_result();
                        $typeData = $typeResult->fetch_assoc();
                        $typeID = $typeData['EventTypeID'];
                        $typeStatement->close();

                        //prepares and executes SQL statement with prepared statement
                        $sql = $conn->prepare("INSERT INTO Events (EventTypeID, GroupID, EventDate, SubmitDate, EventTitle, EventImage, EventDesc) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $sql->bind_param("iisssss", $typeID, $groupID, $eventDateTime, $submitDateTime, $eventTitle, $eventImage, $eventDesc);

                        // executes the statement
                        if ($sql->execute()) {
                            echo "New record created successfully";
                        } 
                        else {
                            echo "Error: " . $conn->error;
                        }

                        $sql->close();
                    }
                
                $conn->close();
                              
                ?>
                <p class="gpname"><?php echo $groupName; ?></p>
                <form action="post.php" method="post" role="form" class= "login">
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Your Event Title" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="date" id="date" placeholder="Your Event Date [Format: year-month-day ####-##-##]" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="time" id="time" placeholder="Your Event Time [Format: hr:min AM or PM]" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="type" id="type" placeholder="Your Event Type" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="image" id="image" placeholder="Image Name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="desc" rows="3" placeholder="The Event Description" required></textarea>
                        </div class="form-group">
                            <div class="text-center"><button type="submit">Submit</button>
                        </div>
                    </div>
                </form>
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