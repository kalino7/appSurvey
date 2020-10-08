<?php 
  include_once("db.php");
  include('checker.php');
  
  $flag='';

  if(isset($_POST['submit']))
  {
    $email = $_POST['email'];
    $pswd = $_POST['password'];

    $query = $db->query("SELECT * FROM users WHERE email='$email'");
    
    if($query->num_rows > 0)
    {
      $data = $query->fetch_assoc();
      $hashed = $data['pswd'];
      $stats = $data['userStats'];
      
      if($stats == 'Active')
      {
        if(password_verify($pswd, $hashed))
        {
          $_SESSION['user'] = $data['username'];
          $_SESSION['id'] = $data['id'];
          $_SESSION['email'] = $email;
          $_SESSION['activity'] = time();
  
          ?>
            <script>
                setTimeout(() => {
                  location.href="dashboard.php";
                }, 3000);
            </script>
          <?php
  
          $flag = '
              <div class="alert alert-success alert-success-style1">
              <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
              <span class="icon-sc-cl" aria-hidden="true">&times;</span>
              </button>
                  <i class="fa fa-check adminpro-checked-pro admin-check-pro" aria-hidden="true"></i>
                  <p><strong>Success! </strong> Redirecting to Dashboard Area Shortly.</p>
              </div>
      ';
        }
        else
        {
          $flag = '
            <div class="alert alert-danger alert-mg-b alert-success-style4">
                  <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
              <span class="icon-sc-cl" aria-hidden="true">&times;</span>
              </button>
                  <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                  <p><strong>**Error** </strong>Invalid Password Credentials.</p>
              </div>
      ';  
        }
      }else
      {
        $flag = '
        <div class="alert alert-danger alert-mg-b alert-success-style4">
              <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
          <span class="icon-sc-cl" aria-hidden="true">&times;</span>
          </button>
              <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
              <p><strong>**Error** </strong>Either Your Account Has Not Yet Been Activated Or Has Been Blocked.</p>
              <p>Regardless, You Can Contact The Support Team For Review. Thank You</p>
          </div>
  ';
      }
      
    }
    else
    {
      $flag = '
      <div class="alert alert-danger alert-mg-b alert-success-style4">
      <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
    <span class="icon-sc-cl" aria-hidden="true">&times;</span>
    </button>
      <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
      <p><strong>**Error** </strong>Invalid Email Address</p>
    </div>
  ';  
    }
  }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login | <?php echo $theme; ?> </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="css/owl.transitions.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="css/main.css">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="css/morrisjs/morris.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="css/metisMenu/metisMenu-vertical.css">
    <!-- calendar CSS
		============================================ -->
    <link rel="stylesheet" href="css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="css/calendar/fullcalendar.print.min.css">
    <!-- forms CSS
		============================================ -->
    <link rel="stylesheet" href="css/form/all-type-forms.css">

    <link rel="stylesheet" href="css/alerts.css">
    
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        body {
          background-image: url('img/logo/bk1.jpeg');
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: 100% 100%;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="color-line"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="back-link back-backend">
                    <!-- <a href="#" class="btn btn-primary">Back to Dashboard</a> -->
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?php echo $flag;?>
            </div>
            <div class="col-md-4 col-md-4 col-sm-4 col-xs-12">
                <div class="text-center m-b-md custom-login">
                    <h3>PLEASE LOGIN TO THE APP</h3>

                </div>
                <div class="hpanel">
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input type="email" placeholder="abc@gmail.com" title="Please enter you email address" required name="email" id="email" class="form-control">
                                <span class="help-block small">Your unique Email Address</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required name="password" id="password" class="form-control">
                                <span class="help-block small">Your strong password</span>
                            </div>
                            <!-- <div class="checkbox login-checkbox">
                                <label>
										<input type="checkbox" class="i-checks"> Remember me </label>
                                <p class="help-block small">(if this is a private computer)</p>
                            </div> -->
                            <button class="btn btn-success btn-block loginbtn" name="submit" >Login</button>
                            <a class="btn btn-default btn-block" href="register.php">Register</a>
                            <span class="help-block small"></span>
                            <b><i><a class="text text-primary" href="recovery.php">Forgot Password ?</a></i></b>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p>Copyright &copy; <?php echo date('Y');?> <a href="#"><?php echo $theme; ?></a> All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- jquery
		============================================ -->
    <script src="js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- wow JS
		============================================ -->
    <script src="js/wow.min.js"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="js/jquery-price-slider.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
    <script src="js/metisMenu/metisMenu-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="js/tab.js"></script>
    <!-- icheck JS
		============================================ -->
    <script src="js/icheck/icheck.min.js"></script>
    <script src="js/icheck/icheck-active.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>
</body>

</html>