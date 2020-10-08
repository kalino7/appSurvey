<?php
  include_once("db.php");
  include('checker.php');

  if(!isset($_GET['id']) || empty($_GET['id']))
  {
    header("Location: set.php");
?>
    <script>
        setTimeout(() => {
        window.location.href="set.php";
        }, 0000);
    </script>
<?php
  }
  else
  {
    $surveyID = htmlspecialchars($_GET['id']);
    $surveyID = trim($surveyID);
    $query= $db->query("SELECT * FROM survey WHERE userID = '$_SESSION[id]' AND id = '$surveyID' ");
    if($query->num_rows <= 0)
    {
        header("Location: set.php");
?>
        <script>
            setTimeout(() => {
            window.location.href="set.php";
            }, 0000);
        </script>
<?php
    }
    else
    {
		$data = $query->fetch_assoc();
		$surTitle =$data['surveyName'];
		$display = '';
		$query= $db->query("SELECT * FROM criteria WHERE surveyID = '$surveyID' ");
		while($data = $query->fetch_assoc())
		{
			if($data['consText'] == "respNumber")
			{
				$textContent = "Number Of Required Responses";
				$textValue = $data['consValue'];
			}
			elseif($data['consText'] == "gender")
			{
				$textContent = "Gender Category";
				$textValue = $data['consValue'];
			}
			elseif($data['consText'] == "minage")
			{
				$textContent = "Age Range (Minimum) ";
				$textValue = $data['consValue'];
			}
			elseif($data['consText'] == "maxage")
			{
				$textContent = "Age Range (Maximum) ";
				$textValue = $data['consValue'];
			}
			elseif($data['consText'] == "rship")
			{
				$textContent = "Relationship Category";
				$textValue = $data['consValue'];
			}
			elseif($data['consText'] == "locating")
			{
				$textContent = "State Category";
				$textValue = $data['consValue'];
			}
			elseif($data['consText'] == "edu")
			{
				$textContent = "Level of Education";
				switch($data['consValue'])
				{
						case 'FSLC':
								$textValue = "First School Leaving Certificate (FSLC)";
						break;
						case 'SSCE':
								$textValue = "Secondary Education (SSCE/GCE)";
						break;
						case 'OND':
								$textValue = "2 Year Diploma (OND/NCE)";
						break;
						case 'HND':
								$textValue = "4 year Diploma (HND)";
						break;
						case 'BSC':
								$textValue = "Bachelor Degree";
						break;
						case 'MSC':
								$textValue = "Postgraduate Degree(Masters)";
						break;
						case 'PHD':
								$textValue = "Doctorate Degree";
						break;
						case 'All':
								$textValue = "All";
						break;
						default:
								$textValue = "";
						break;
				}
			}
			elseif($data['consText'] == "job")
			{
				$textContent = "Occupation";
		
				switch($data['consValue'])
				{
						case 'UDG':
								$textValue = "Undergraduate (Student)";
						break;
						case 'PG':
								$textValue = "Postgraduate (Student)";
						break;
						case 'SE':
								$textValue = "Self Employed";
						break;
						case 'ECS':
								$textValue = "Employed (Civil Servant)";
						break;
						case 'EPS':
								$textValue = "Employed (Private Sector)";
						break;
						case 'All':
								$textValue = "All";
						break;
						default:
								$textValue = "";
						break;
				}
			}

		$display .=	'<div class="form-group-inner">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<label class="login2 pull-right pull-right-pro">'.$textContent.'</label>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<input type="text" disabled class="form-control" placeholder="'. $textValue.'" />
					</div>
				</div>
			</div>';

		   }
		}
  	}
?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>survey | <?php echo $theme; ?></title>
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
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
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
    <!-- modals CSS
		============================================ -->
    <link rel="stylesheet" href="css/modals.css">
    <!-- forms CSS
		============================================ -->
    <link rel="stylesheet" href="css/form/all-type-forms.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="left-sidebar-pro">
        <?php include("Lsidebar.php");?>
    </div>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <?php include('logo.php'); ?>
        <div class="header-advance-area">
            <?php include("topnav.php");?>
        </div>
        <!-- Advanced Form Start -->
		<div class="basic-form-area mg-tb-15">
		<div class="container-fluid">

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="sparkline12-list">
						<div class="sparkline12-hd">
							<div class="main-sparkline12-hd">
								<h1> Survey Criteria For ( <?php echo $surTitle; ?> ) </h1>
							</div>
						</div>
						<div class="sparkline12-graph">
							<div class="basic-login-form-ad">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="all-form-element-inner">
											<form action="#">

												<?php echo $display;?>

											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
        <!-- Advanced Form End-->
        <div class="footer-copyright-area">
			<?php include("footer.php");?>
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