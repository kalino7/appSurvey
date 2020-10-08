<?php
    include_once("db.php");

    if(isset($_POST['submit']))
    {
      $token = $_POST['token'];
      $userid = $_POST['userid'];
      $pswd = trim($_POST['password']);

      $query = $db->query("SELECT * FROM users WHERE id='$userid'");
      $data = $query->fetch_assoc();
      $_GET['tok'] = $token;

      if(!password_verify($pswd, $data['pswd']) )
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
      else
      {
        $_SESSION['user'] = $data['username'];
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['activity'] = time();

        $flag = '
        <div class="alert alert-success alert-success-style1">
        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
        <span class="icon-sc-cl" aria-hidden="true">&times;</span>
        </button>
            <i class="fa fa-check adminpro-checked-pro admin-check-pro" aria-hidden="true"></i>
            <p><strong>Success! </strong> Redirecting to Dashboard Area Shortly.</p>
        </div>
        ';
        ?>
          <script>
              setTimeout(() => {
                var x = '<?php echo $token; ?>';
                location.href="answer.php?tok=" + x;
              }, 2000);
          </script>
        <?php
      }

    }

    include("lockChecker.php");
    
    // if(isset($_GET['tok']))
    // {
    //   $token = trim($_GET['tok']);
    //   $token = htmlspecialchars($token);

    //   $query = $db->query("SELECT * FROM selected WHERE token = '$token' ");
      
    //   if($query->num_rows > 0)
    //   {
    //       $tag = 316;
    //       $data = $query->fetch_assoc();
    //       $userid = $data['userID'];

    //   }
    //   else
    //   {
    //     $tag = 0;
    //     $flag = '
    //     <h1 class="mg-tb-15">ERROR B<span class="counter"> 104</span></h1>
    //     <h4 class="mg-t-30">Sorry, Broken Token Link. </h4>
    //     <a href="#" class="btn btn-lg btn-default">Support Team</a>
    //         ';
    //   }
    // }
    // else
    // {
    //     //invalid token
    //     $tag = 0;
    //     $flag = '
    //     <h1 class="mg-tb-15">ERROR A<span class="counter"> 104</span></h1>
    //     <h4 class="mg-t-30">Sorry, Invalid Token Link. </h4>
    //     ';
    // }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Survey | <?php echo $theme;?></title>
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
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
    ============================================ -->
    <link rel="stylesheet" href="css/alerts.css">
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
    
    <div class="container-fluid mg-t-30">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php
                  if(!$tag == 0)
                  {
                ?>
                <div class="hpanel">
                    <div class="panel-body text-center lock-inner">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <br/>
                        <h4><span class="text-success"><?php echo date('D');?> </span> <strong><?php echo date('M').", ".date('Y'); ?></strong></h4>
                        <p>Your Are In Lock Screen. You Need To Enter Your Password.</p>
                        <?php if(isset($flag)){echo $flag;} ?>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method ="POST" class="m-t">
                            <div class="form-group">
                              <input type = "hidden" name="token" value="<?php echo $token; ?>">
                              <input type = "hidden" name="userid" value="<?php echo $userid; ?>">
                              <input type="password" required name="password" placeholder="******" class="form-control">
                            </div>
                            <button class="btn btn-primary block full-width" name="submit" type="submit">Unlock</button>
                        </form>
                    </div>
                </div>
                <?php
                  }
                  else
                  {
                ?>
                    <div class="hpanel">
                        <div class="panel-body text-center lock-inner">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <br/>
                            <h4><span class="text-success"><?php echo date('D');?> </span> <strong><?php echo date('M').", ".date('Y'); ?></strong></h4>
                            <div class="content-error">
                                <?php echo $flag; ?>
                            </div>
                        </div>
                    </div>
                <?php
                  }
                ?>

            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 text-center login-footer">
                <p>Copyright &copy; <?php echo date('Y');?> <a href="#"><?php echo $theme;?></a> All rights reserved.</p>
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
        <!-- counterup JS
		============================================ -->
    <script src="js/counterup/jquery.counterup.min.js"></script>
    <script src="js/counterup/waypoints.min.js"></script>
    <script src="js/counterup/counterup-active.js"></script>
    
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