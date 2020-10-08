<?php
  include_once("db.php"); 

  $curTime = strtotime("now");
  $show = 0;
  $flag='';

  if( isset($_GET['tok']))
  {
    $key = $_GET['tok'];

    $query = $db->query("SELECT * FROM recover WHERE token = '$key' ");
    
    if($query->num_rows > 0)
    {
      $data = $query->fetch_assoc();
      $email = $data['email'];
      $expTime = $data['expires_At'];

      if($curTime > $expTime)
      {
        //expired link
        $del = $db->query("DELETE FROM recover WHERE token = '$key' ");
        if($del)
        {
          $flag = '
          <h1>Oops <span class="counter"> 304</span></h1>
          <p>***Token Has Expired </p>
          ';
        }
      }
      else
      {
        $show = 1;
      }


      // $upd = $db->query("UPDATE users SET userStats='Active' WHERE email = '$email' ");
      // if($upd)
      // {
      //   $delete = $db->query("DELETE FROM activate WHERE activeKey = '$key'");
      //   $flag = '
      //   <h1>Successful!!</h1>
      //   <p>Your Account Has Been Activated, CLick The Login Button To Access Your Dashboard. </p>
      //   <a href="login.php" class="btn btn-lg btn-success">Login</a>
      //   ';
      // }
    }
    else
    {
      $flag = '
      <h1>ERROR <span class="counter"> 204</span></h1>
      <p>***Oops, Invalid Token, Check The Link That Was Sent To Your Mail. </p>
      ';
    }
  }
  else
  {
    $flag = '
    <h1>ERROR <span class="counter"> 104</span></h1>
    <p>***Oops, Invalid Token, Check The Link That Was Sent To Your Mail. </p>
    ';
  }


  if(isset($_POST['submit']))
  {
    $email = trim(htmlspecialchars($_POST['origin']));
    $username = trim(htmlspecialchars($_POST['username']));
    $tokval = trim(htmlspecialchars($_POST['tokval']));
    $expTime = trim(htmlspecialchars($_POST['timeup']));
    $pswd = trim(htmlspecialchars($_POST['password']));
    $repassword = trim(htmlspecialchars($_POST['repassword']));

    
    if($pswd != $repassword)
    {
      //echo error
      $show = 1;
      $flag = '<div class="alert alert-danger alert-mg-b alert-success-style4">
      <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
    <span class="icon-sc-cl" aria-hidden="true">&times;</span>
    </button>
      <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
      <p><strong>**Error** </strong>Password Does Not Match</p>
    </div>
      ';
    }
    else
    {
      if($curTime > $expTime)
      {
        //expired link
        $del = $db->query("DELETE FROM recover WHERE token = '$tokval' ");
        if($del)
        {
          $flag = '
          <h1>Oops <span class="counter"> 304</span></h1>
          <p>***Token Has Expired </p>
          ';
        }
      }
      else
      {
        $search = $db->query("SELECT * FROM users WHERE username = '$username' AND email = '$email' ");
        if($search->num_rows > 0)
        {
          $pswd = password_hash($pswd, PASSWORD_DEFAULT);

          $upd = $db->query("UPDATE users SET pswd = '$pswd' WHERE email ='$email' ");
          if($upd)
          {
            $show = 0;
            $del = $db->query("DELETE FROM recover WHERE token = '$tokval' ");
            ?>
            <script>
                setTimeout(() => {
                  location.href="login.php";
                }, 3000);
            </script>
          <?php
  
          $flag = '
              <div class="alert alert-success alert-success-style1">
              <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
              <span class="icon-sc-cl" aria-hidden="true">&times;</span>
              </button>
                  <i class="fa fa-check adminpro-checked-pro admin-check-pro" aria-hidden="true"></i>
                  <p><strong>Password Change Was Successful! </strong> Redirecting to Login Portal Shortly.</p>
              </div>
      ';
          }
          else
          {
            $show = 1;
            //invalid user account
            $flag = '<div class="alert alert-danger alert-mg-b alert-success-style4">
            <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
          <span class="icon-sc-cl" aria-hidden="true">&times;</span>
          </button>
            <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
            <p><strong>**Oops** </strong>Something Went Wrong, Try Again Later!.</p>
          </div>
            ';
          }
        }
        else
        {
          $show = 1;
          //invalid user account
          $flag = '<div class="alert alert-danger alert-mg-b alert-success-style4">
          <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
        <span class="icon-sc-cl" aria-hidden="true">&times;</span>
        </button>
          <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
          <p><strong>**Error** </strong>The User Account Details Entered Is Invalid.</p>
          <p>Do verify that both the username and email address are correct.</p>
        </div>
          ';
        }
      }
    }
  }

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Reset Page | <?php echo $theme;?></title>
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
                    <a href="login.php" class="btn btn-primary">Login Page</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            <div class="col-md-6 col-md-6 col-sm-6 col-xs-12">
                <div class="content-error">
                    <?php echo $flag; ?>
                </div>
                <?php
                      if($show == 1)
                      {
                    ?>
                    <div class="hpanel">
                        <div class="panel-body">
                            <form action="<?php echo $_SERVER['PHP_SELF'].'?tok='.$key;?>" method="POST" id="loginForm">
                                <div class="form-group">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="hidden" name="tokval" value="<?php echo $key;?>" required/>
                                    <input type="hidden" name="timeup" value="<?php echo $expTime;?>" required/>
                                    <input type="hidden" name="origin" value="<?php echo $email;?>" required/>
                                    <input type="email" disabled placeholder="<?php echo $email;?>" title="Please enter you email address" required name="email" id="email" class="form-control">
                                    <span class="help-block small">Your Registered Email Address</span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="email">Username</label>
                                    <input type="text" placeholder="MyUsername" title="Please enter your Username" required name="username" id="username" class="form-control">
                                    <span class="help-block small">Your Registered Username </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="password">New Password</label>
                                    <input type="password" title="Please enter your new password" placeholder="******" required name="password" id="password" class="form-control">
                                    <span class="help-block small">strong password</span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="password">Re-Enter New Password</label>
                                    <input type="password" title="Please enter your password Again" placeholder="******" required name="repassword" id="repassword" class="form-control">
                                    <span class="help-block small">strong password</span>
                                </div>

                                <button class="btn btn-success btn-block loginbtn" name="submit" >Reset Password</button>

                            </form>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 text-center login-footer">
                <p>Copyright © <?php echo date('Y');?> <a href="#"><?php echo $theme;?></a> All rights reserved.</p>
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
    <!-- morrisjs JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/jquery.charts-sparkline.js"></script>
    <!-- calendar JS
		============================================ -->
    <script src="js/calendar/moment.min.js"></script>
    <script src="js/calendar/fullcalendar.min.js"></script>
    <script src="js/calendar/fullcalendar-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="js/tab.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>
</body>

</html>