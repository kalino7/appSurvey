<?php 
  include('sendmail.php');
  include_once("db.php"); 
  include("userfxn.php");

  $flag = '';

  if(isset($_POST['submit']))
  {
      $fullname = trimdata($_POST['fullname']);
      $username = trimdata($_POST['username']);
      $pswd = trimdata($_POST['password']);
      $repswd = trimdata($_POST['repswd']);
      $email = trimdata($_POST['email']);
      $telephone = trimdata($_POST['telephone']);
      $dob = trimdata($_POST['dob']);
      $located = trimdata($_POST['location']);
      $relationship = trimdata($_POST['relationship']);
      $gender = trimdata($_POST['gender']);
      $occupation = trimdata($_POST['occupation']);
      $education = trimdata($_POST['education']);

      $age = calculateage($dob);

      if($pswd !== $repswd)
      {
        //password does not match error
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
        $validity = filter_var($email, FILTER_VALIDATE_EMAIL);
        if( $validity == false)
        {
          $flag = '<div class="alert alert-danger alert-mg-b alert-success-style4">
          <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
        <span class="icon-sc-cl" aria-hidden="true">&times;</span>
        </button>
          <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
          <p><strong>**Error** </strong>Invalid Email Address.</p>
        </div>
          ';    
        }
        else
        {
            if((unqiueVals('username', $username) == true) || (unqiueVals('email', $email) == true) || (unqiueVals('telephone', $telephone) == true))
            {
              $flag = '<div class="alert alert-info alert-success-style2">
            <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                    <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                </button>
            <i class="fa fa-info-circle adminpro-inform admin-check-pro" aria-hidden="true"></i>
            <p><strong>**Info** </strong> Either The USERNAME, PHONE NUMBER or EMAIL ADDRESS Has Already Been Registered.</p>
        </div>
              ';
            }
            else
            {

                //Hash Password
                $pswd = password_hash($pswd, PASSWORD_DEFAULT);

                $db->autocommit(FALSE);

                //insert into user tables
                $stmt = $db->prepare("INSERT INTO users(fullname, username, pswd, 
                email, telephone, dob, age, gender, education, occupation, located, relationship) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");

                $stmt->bind_param("ssssssssssss", $fullname, $username, $pswd, $email, $telephone,
                $dob, $age, $gender, $education, $occupation, $located, $relationship);

                if(!$stmt->execute())
                {
                    $flag = '
                  <div class="alert alert-danger alert-mg-b alert-success-style4">
                  <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                </button>
                  <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                  <p><strong>**Error** </strong> Could Not Create Account, Please Check Your Internet Connection And Try Again.</p>
                </div>
                  ';
                }
                else
                {
                    
                    $db->commit();
                    $stmt->close();

                    //activation link
                    $active_key = hash('md5', $email.time());
                    //user id
                    $userid = getUserID($email);

                    $stmt2 = $db->prepare("INSERT INTO account(userID) VALUES(?)");
                
                    $stmt3 = $db->prepare("INSERT INTO activate(email, activeKey) VALUES(?,?)");
                
                    $stmt2->bind_param("i", $userid);
                
                    $stmt3->bind_param("ss", $email, $active_key);

                if( (!$stmt2->execute()) || (!$stmt3->execute()))
                {
                    $db->rollback();
                    $flag = '
                    <div class="alert alert-danger alert-mg-b alert-success-style4">
                    <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                  <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                  </button>
                    <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                    <p><strong>**Error** </strong> Could Not Create Account, Please Check Your Internet Connection And Try Again.</p>
                  </div>
                    ';
                }
                else
                {
                    
                    $mail_status = SenderZesk($active_key, $email, $fullname);
                    
                    if($mail_status == false)
                    {
                        $db->rollback();

                        if(DeleteEmail($email))
                        {
                            $db->commit();
                            
                            $flag = '
                        <div class="alert alert-danger alert-mg-b alert-success-style4">
                        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                      <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                      </button>
                        <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                        <p><strong>**Error** </strong> Could Not Deliver Message, Check Your Internet Connection.</p>
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
                        <p><strong>**Error** </strong> Contact Support Team With Error Message #101.</p>
                      </div>
                        ';
                        }
                    }
                    else
                    {
                        $db->commit();
                        
                        $stmt2->close();
                        $stmt3->close();
                        
                        $db->autocommit(TRUE);

                        $flag = '<div class="alert alert-success alert-dismissible fade in">
                           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           <strong>Successful!! </strong> An Activation link Has Been Sent To Your Email Address.
                          </div>';
                    }

                }

                }
            }
        }
      }
  }


?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Register | <?php echo $theme; ?></title>
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
    <link rel="stylesheet" href="css/alerts.css">
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
          height: auto;
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
                    <a href="login.php" class="btn btn-primary">Back to Login Portal </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            <div class="col-md-6 col-md-6 col-sm-6 col-xs-12">
                <div class="text-center custom-login">
                    <h3>Registration</h3>
                    <p> Sign up for free! </p>
                </div>
                <div class="hpanel">
                    <div class="panel-body">

                        <?php echo $flag; ?>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="loginForm">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label>Fullname</label>
                                    <input class="form-control" name="fullname" type="text" required />
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Username</label>
                                    <input class="form-control" name="username" type="text" required />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Repeat Password</label>
                                    <input type="password" name="repswd" class="form-control" required />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Email Address</label>
                                    <input class="form-control" name="email" type="email" required />
                                </div>

                                <div class="form-group col-lg-6">
                                  <label>Telephone</label>
                                      <div class="input-mark-inner mg-b-22">
                                         <input type="text" class="form-control" name="telephone" required  data-mask="(9999) 999-9999" placeholder="(9999) 999-9999">
                                      </div>
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label>Date of Birth</label>
                                    <input class="form-control" type="date" name="dob" required />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male"> Male</option>
                                        <option value="female"> Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Education Level</label>
                                    <select class="form-control" name="education" required>
                                        <option value="">Select Level of Education</option>
                                        <option value="FSLC"> First School Leaving Certificate (FSLC)</option>
                                        <option value="SSCE"> Secondary Education (SSCE/GCE)</option>
                                        <option value="OND"> 2 Year Diploma (OND/NCE)</option>
                                        <option value="HND"> 4 year Diploma (HND)</option>
                                        <option value="BSC"> Bachelor Degree </option>
                                        <option value="MSC"> Postgraduate Degree(Masters) </option>
                                        <option value="PHD"> Doctorate Degree</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Occupation</label>
                                    <select class="form-control" name="occupation" required>
                                        <option value="">Choose Occupation Category </option>
                                        <option value="UDG"> Undergraduate (Student) </option>
                                        <option value="PG"> Postgraduate (Student)</option>
                                        <option value="SE"> Self Employed </option>
                                        <option value="ECS"> Employed (Civil Servant) </option>
                                        <option value="EPS"> Employed (Private Sector) </option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Location</label>
                                    <select class="form-control" name="location" required>
                                        <option value="">Choose Your Location</option>
                                        <option value="Abuja"> Abuja</option>
                                        <option value="Abia"> Abia</option>
                                        <option value="Adamawa"> Adamawa</option>
                                        <option value="Anambra"> Anambra</option>
                                        <option value="Bauchi"> Bauchi</option>
                                        <option value="Delta"> Delta</option>
                                        <option value="Ebonyi"> Ebonyi</option>
                                        <option value="Edo"> Edo</option>
                                        <option value="Ekiti"> Ekiti</option>
                                        <option value="Enugu"> Enugu</option>
                                        <option value="Gombe"> Gombe</option>
                                        <option value="Imo"> Imo</option>
                                        <option value="Jigawa"> Jigawa</option>
                                        <option value="Kaduna"> Kaduna</option>
                                        <option value="Kano"> Kano</option>
                                        <option value="Kogi"> Kogi</option>
                                        <option value="Lagos"> Lagos</option>
                                        <option value="Ogun"> Ogun</option>
                                        <option value="Ondo"> Ondo</option>
                                        <option value="Osun"> Osun</option>
                                        <option value="Rivers"> Rivers</option>
                                        <option value="Sokoto"> Sokoto</option>
                                        <option value="Taraba"> Taraba</option>
                                        <option value="Zamfara"> Zamfara</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Relationship Status</label>
                                    <select class="form-control" name="relationship" required>
                                        <option value="">Relationship Status</option>
                                        <option value="Single"> Single</option>
                                        <option value="Married"> Married</option>
                                        <option value="Divorced"> Divorced</option>
                                    </select>
                                </div>
                                <div class="checkbox col-lg-12">
                                    <input type="checkbox" class="i-checks" checked required /> Agree To Our Terms & Conditions
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-success loginbtn">Register</button>
                                <button class="btn btn-default">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p>Copyright &copy; <?php echo date('Y'); ?> <a href="#"> <?php echo $theme; ?></a> All rights reserved.</p>
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
        <!-- input-mask JS
		============================================ -->
    <script src="js/input-mask/jasny-bootstrap.min.js"></script>
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