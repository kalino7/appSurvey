<?php
  include('sendmail.php');
  include_once("db.php");
  include('checker.php');

  $flag =''; 
  if(isset($_POST['pswdReset']))
  {
    $email = trim(htmlspecialchars($_POST['username']));
    $search = $db->query("SELECT email FROM users WHERE email = '$email' ");
    if($search->num_rows > 0)
    {
      $token = sha1(uniqid($email, true));
      $expires = strtotime("+1 hour");
      $mailStats = SenderReset($token, $email);

      if($mailStats)
      {
        //mail sent
        $stmt = $db->prepare("INSERT INTO recover(email, token, expires_At) VALUES(?,?,?)");
        $stmt->bind_param("ssi", $email, $token, $expires);
        if($stmt->execute())
        {
          $flag = '
            <div class="alert alert-success alert-success-style1">
            <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
            <span class="icon-sc-cl" aria-hidden="true">&times;</span>
            </button>
                <i class="fa fa-check adminpro-checked-pro admin-check-pro" aria-hidden="true"></i>
                <p><strong>Successful! </strong> Password Reset Token Has Been Sent To Your Email.</p>
            </div>
          ';
        }
        else
        {
          //broken 
          $flag = '
          <div class="alert alert-danger alert-mg-b alert-success-style4">
            <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
          <span class="icon-sc-cl" aria-hidden="true">&times;</span>
          </button>
            <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
            <p><strong>**Oops** </strong>Broken Token Link: Please Try Again.</p>
          </div>
        ';
        }
      }
      else
      {
        //network error
        $flag = '
        <div class="alert alert-danger alert-mg-b alert-success-style4">
          <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
        <span class="icon-sc-cl" aria-hidden="true">&times;</span>
        </button>
          <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
          <p><strong>**Oops** </strong>Network Error In Sending Mail. Please Check Your Internet Connection And Try Again</p>
        </div>
      ';
      }
    }
    else
    {
      //does not exist
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
    <title>Password Recevery | <?php echo $theme;?></title>
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
                    <a href="login.php" class="btn btn-primary">Back to Login Portal</a>
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
                <div class="text-center ps-recovered">
                    <h3>PASSWORD RECOVER</h3>
                    <p>Please fill the form to recover your password</p>
                </div>
                <div class="hpanel">
                    <div class="panel-body poss-recover">
                        <p>
                            Enter your email address and your password will be reset and emailed to you.
                        </p>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="username">Email</label>
                                <input type="email" placeholder="example@gmail.com" title="Please enter you email adress" required="" value="" name="username" id="username" class="form-control">
                                <span class="help-block small">Your registered email address</span>
                            </div>

                            <button type="submit" name="pswdReset" class="btn btn-success btn-block">Reset password</button>
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