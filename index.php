<?php include 'config.php'; 
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login |  Teacher</title>
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!--  Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="https://geraldjamisco.com" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Schmark</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-4">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your Mail & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" novalidate action="" method="POST">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Teacher Id</label>
                      <div class="input-group has-validation">
                        <span class="input-group-mail" id="inputGroupPrepend"></span>
                        <input type="text" name="Teacherid" class="form-control" required placeholder="Teacher Id">
                        <div class="invalid-feedback">Please enter your teacher Id.</div>
                      </div>
                      
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="teacherloginpassword" class="form-control" required placeholder="password">
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="jointeacherPortal">Login</button>
                    </div>
                   
                  </form>
                  <?php
          if (isset($_POST['jointeacherPortal'])) {
            $schmarkTeacherid = $conn->real_escape_string($_POST['Teacherid']);
            $schmarkloginpassword =$conn->real_escape_string($_POST['teacherloginpassword']);

            $getclassteacherlogincrdntls = $conn->query("SELECT * FROM teachers WHERE teacher_id='$schmarkTeacherid'");
            if (mysqli_num_rows($getclassteacherlogincrdntls) == 0) {
              echo '<br> <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-octagon me-1"></i>
              Wrong teacher Id, please Enter Again
            </div>';
            }else {
              # continue to password
              $q_r = $getclassteacherlogincrdntls->fetch_assoc();
              $hashed = $q_r['password'];
              if ($q_r['status'] === "0") {
                echo '<br>  <div class="alert alert-primary alert-dismissible fade show" role="alert">
                      Staff account currently on hold waiting for activation
                    </div>';
              }else {
                $dbSalt = substr($hashed, 0, 14);
                $dbpass = substr($hashed,14);
                $verified = md5($dbSalt . $schmarkloginpassword) == $dbpass;
                      if ($verified === true) {
                        // if the one logged in is a class teacher then send to a class teacher dashboard
                            if ($q_r['classTeacher'] === "YES") {
                                $_SESSION['classTeacherid'] = $schmarkTeacherid;
                                $_SESSION['classteacherloginpassword'] = $schmarkloginpassword;
                                $_SESSION['classTeacherFor'] = $q_r['classTeacherFor'];
                                $_SESSION['classTeacherForStream'] = $q_r['classTeacherForStream'];
                                // send directly to the class teacher's dashboard
                                header('location: c_t/');
                            }elseif ($q_r['classTeacher'] === "NO") {
                                $_SESSION['classTeacherid'] = $schmarkTeacherid;
                                $_SESSION['classteacherloginpassword'] = $schmarkloginpassword;
                                header('location: t/'); 
                            }else {
                                echo '<br>  <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                Your hacking has Failed! sorry ☺☺
                              </div>';
                              die();
                            }
                      }else {
                        echo '<br>  <div class="alert alert-primary alert-dismissible fade show" role="alert">
                      Wrong Password Enter correct password again and procceed!
                    </div>';
                      }
              }
            }
           }

?>


                </div>
              </div>

              <div class="credits">
                Designed by <a href="https://geraldjamisco.com/">Schmark Team</a>
              </div>

            </div>
          </div>
        </div>

      </section>
      
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>