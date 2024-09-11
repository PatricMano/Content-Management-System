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
              <li><a href="login.php">Login</a></li>
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
                    <h1 class="page-title">Create Account</h1>
                </div>
            </div>
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
            .login p {
                margin: 0px;
                border: 0px;
                padding-bottom: 5px;
            }

            .error {
            font-weight: 590;
            }
            </style>
            <div class="form mt-5">
                    <?php
                    session_start();           
                    include_once "serverlogin.php";
                    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
                    mysqli_select_db($conn, $db_database) or die("Unable to select database: " . mysql_error());

                    $group_err = $type_err = $name_err = $email_err = $image_err = $desc_err = $username_err = $password_err = "";
    
                    //Regular Expressions for all the checks
                    $length = "/^.{7,}$/";
                    $number = "/[0-9]/";
                    $capital = "/[A-Z]/";
                    $special = "/.*[\W].*/";

                    // Checks if the form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Checks if the form is filled
                        if (empty(trim($_POST["group"]))) {
                            $group_err = "Please enter your group name.";
                        } 
                        else {
                            $group = trim($_POST["group"]);
                        }

                        if (empty(trim($_POST["type"]))) {
                            $type_err = "Please enter your group type.";
                        } 
                        else {
                            $type = trim($_POST["type"]);
                        }

                        if (empty(trim($_POST["name"]))) {
                            $name_err = "Please enter your contact name.";
                        } 
                        else {
                            $name = trim($_POST["name"]);
                        }

                        if (empty(trim($_POST["email"]))) {
                            $email_err = "Please enter your contact email.";
                        } 
                        else {
                            $email = trim($_POST["email"]);
                        }

                        if (empty(trim($_POST["image"]))) {
                            $image_err = "Please enter your group image name.";
                        } 
                        else {
                            $image = "files/images/events/" . trim($_POST["image"]);
                        }

                        if (empty(trim($_POST["desc"]))) {
                            $desc_err = "Please tell us about your group.";
                        } 
                        else {
                            $desc = trim($_POST["desc"]);
                        }

                        if (empty(trim($_POST["username"]))) {
                            $username_err = "Please enter a username.";
                        } 
                        else {
                            $username = trim($_POST["username"]);
                        }

                        if (empty(trim($_POST["password"]))) {
                            $password_err = "Please enter a password.";
                        } 
                        else {
                            $password = trim($_POST["password"]);
                            
                            //Checks for at least 7 characters
                            if (!preg_match($length, $password)) {
                              $password_err = "<br>Error! Password needs at least 7 characters.";
                            }

                            //Checks for at least 1 number
                            if (!preg_match($number, $password)) {
                              $password_err .= "<br>Error! Password needs at least 1 number.";
                            }

                            //Checks for at least one capital letter
                            if (!preg_match($capital, $password)) {
                              $password_err .= "<br>Error! Password needs at least 1 capital letter.";
                            }

                            //Checks for at least one special character
                            if (!preg_match($special, $password)) {
                              $password_err .= "<br>Error! Password needs at least one special character.";
                            }
                        }

                        if (empty($group_err) && empty($type_err) && empty($name_err) && empty($email_err) && empty($image_err) && empty($desc_err) && empty($username_err) && empty($password_err)) {
                            //Hashing the password
                            $hashed = password_hash($password, PASSWORD_DEFAULT);

                            // Checks if the username already exists
                            $checkUsernameQuery = "SELECT Username FROM login WHERE Username = ?";
                            $checkUsernameStmt = $conn->prepare($checkUsernameQuery);
                            $checkUsernameStmt->bind_param("s", $username);
                            $checkUsernameStmt->execute();
                            $checkUsernameStmt->store_result();
                
                            if ($checkUsernameStmt->num_rows > 0) {
                                $username_err = "Username already exists, please try again";
                            } else {
                                // Inserts data into groups table
                                $insertGroupQuery = "INSERT INTO Groups (GroupName, GroupType, ContactName, ContactEmail, GroupImage, GroupDesc) VALUES (?, ?, ?, ?, ?, ?)";
                                $insertGroupStmt = $conn->prepare($insertGroupQuery);
                                $insertGroupStmt->bind_param("ssssss", $group, $type, $name, $email, $image, $desc);
                                $insertGroupStmt->execute();
                                $groupID = mysqli_insert_id($conn); // Get the GroupID of the newly inserted group
                
                                // Inserts data into login table
                                $insertLoginQuery = "INSERT INTO login (GroupID, Username, Password) VALUES (?, ?, ?)";
                                $insertLoginStmt = $conn->prepare($insertLoginQuery);
                                $insertLoginStmt->bind_param("iss", $groupID, $username, $hashed);
                                $insertLoginStmt->execute();
                
                                // Sets session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["AccountID"] = mysqli_insert_id($conn); // Get the AccountID of the newly inserted login
                                $_SESSION["GroupID"] = $groupID;
                
                                // Redirects user to post.php
                                header("location: post.php");
                            }
                        }
                    }
                ?>
                <form action=" " method="post" role="form" class="login">
                    <div class="row">
                        <div class="form-group">
                            <p><b>Tell us about your group:</b></p>
                            <input type="text" name="group" class="form-control" id="group" placeholder="Your Community Group" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="type" id="type" placeholder="What type of group are you?" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Provide a Contact Name for your group" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Provide a Contact Email for your group" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="image" id="image" placeholder="Group Image Name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="desc" rows="3" placeholder="Tell us about your group:" required></textarea>      
                        </div>
                        
                        <div class="form-group">
                            <p><b>Create an Account:</b></p>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Create a Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Create a Password" required>
                        </div>
                        <div class="text-center">
                        <button type="submit">Submit</button>
                        <div class="text-center">
                        <div class="error"><?php echo $username_err;
                            echo $password_err; ?></div>
                        </div>
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
              <li><a href="#"><i class="bi bi-chevron-right"></i> Login</a></li>
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