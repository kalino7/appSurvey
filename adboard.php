<?php
    include_once("db.php");
    include('adchecker.php');

    $flag = '';

    if(isset($_POST['submit']))
    {
        $cusID =  trim(htmlspecialchars($_POST['selectedID']));
        $condition =  trim(htmlspecialchars($_POST['condition']));

        switch($condition)
        {
            case 'Block':
                $userstats = 'Suspended';
            break;
            case 'Activate':
                $userstats = 'Active';
            break;
            default:
                $userstats = '';
            break;
        }

        if($userstats != '')
        {
            $upd = $db->query("UPDATE users SET userStats = '$userstats' WHERE id = '$cusID' ");
            if($upd)
            {
                $flag = '
                <div class="alert alert-success alert-success-style1">
                <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                </button>
                    <i class="fa fa-check adminpro-checked-pro admin-check-pro" aria-hidden="true"></i>
                    <p><strong>Success! </strong> Operation Was Successful.</p>
                </div>
        ';
            }
        }
    }

    $usrd = $db->query("SELECT * FROM users");
    $totNum = $usrd->num_rows;
    $active = 0;
    $pending = 0;
    $suspended = 0;
    $arr='';
    if($totNum > 0)
    {
      while($data = $usrd->fetch_assoc())
      {
        if($data['userStats'] == 'Active')
        {
          $active += 1;
          $condition = 'Block';
          $btn = 'danger';
        }
        elseif($data['userStats'] == 'Pending')
        {
          $pending += 1;
          $condition = 'Activate';
          $btn = 'primary';
        }
        elseif($data['userStats'] == 'Suspended')
        {
          $suspended += 1;
          $condition = 'Activate';
          $btn = 'primary';
        }

        switch($data['education'])
        {
            case 'FSLC':
                $education = "First School Leaving Certificate (FSLC)";
            break;
            case 'SSCE':
                $education = "Secondary Education (SSCE/GCE)";
            break;
            case 'OND':
                $education = "2 Year Diploma (OND/NCE)";
            break;
            case 'HND':
                $education = "4 year Diploma (HND)";
            break;
            case 'BSC':
                $education = "Bachelor Degree";
            break;
            case 'MSC':
                $education = "Postgraduate Degree(Masters)";
            break;
            case 'PHD':
                $education = "Doctorate Degree";
            break;
            default:
                $education = "";
            break;
        }
    
        switch($data['occupation'])
        {
            case 'UDG':
                $occupation = "Undergraduate (Student)";
            break;
            case 'PG':
                $occupation = "Postgraduate (Student)";
            break;
            case 'SE':
                $occupation = "Self Employed";
            break;
            case 'ECS':
                $occupation = "Employed (Civil Servant)";
            break;
            case 'EPS':
                $occupation = "Employed (Private Sector)";
            break;
            default:
                $occupation = "";
            break;
        }

        $arr .= "
        <tr>
            <td>".$data['fullname']."</td>
            <td>".$data['email']."</td>
            <td>".$data['username']."</td>
            <td>".$data['telephone']."</td>
            <td>".$data['dob']."</td>
            <td>".$data['located']."</td>
            <td>".$data['gender']."</td>
            <td>".$education."</td>
            <td>".$occupation."</td>
            <td>".$data['relationship']."</td>
            <td>".$data['userStats']."</td>
            <td>".date("Y-M-d h:i a", strtotime($data['created_at']))."</td>
            <td> 
            <form method='POST' action='adboard.php'>
                <input type='hidden' name='selectedID' value='".$data['id']."' />
                <input type='hidden' name='condition' value='".$condition."' />
                <input type='submit' class='btn btn-".$btn."' name='submit' value='".$condition."' />
            </form>
            </td>
        </tr>
    ";
      }
    }

    $getSury = $db->query("SELECT * FROM survey");
    $numSur = $getSury->num_rows;
    $sopen = 0;
    $sclosed = 0;
    $survsum = 0;

    if($numSur > 0)
    {
        while($dataSur= $getSury->fetch_assoc())
        {
            $survsum += $dataSur['costs'];

            if($dataSur['status'] == 'open')
            {
                $sopen += 1;
            }
            else
            {
                $sclosed += 1;
            }
        }
    }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Dashboard | <?php echo $theme; ?></title>
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
        <!-- tabs CSS
		============================================ -->
        <link rel="stylesheet" href="css/alerts.css">
        <link rel="stylesheet" href="css/tabs.css">
        <!-- modals CSS
		============================================ -->
    <link rel="stylesheet" href="css/modals.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <!-- jquery
		============================================ -->
        <script src="js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="left-sidebar-pro">
        <?php include("Alside.php");?>
    </div>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        
        <?php include('logo.php'); ?>

        <div class="header-advance-area">
            <?php include("adtop.php");?>
        </div>


        <div class="section-admin container-fluid res-mg-t-15 mg-tb-30">
        <?php echo $flag; ?>
            <div class="row admin text-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="admin-content analysis-progrebar-ctn">
                                <h4 class="text-left text-uppercase"><b>Total Users</b></h4>
                                <div class="row vertical-center-box vertical-center-box-tablet">
                                    <div class="col-xs-3 mar-bot-15 text-left">
                                        <label class="label bg-green"> <i class="fa fa-level-up" aria-hidden="true"></i> *i*</label>
                                    </div>
                                    <div class="col-xs-9 cus-gh-hd-pro">
                                        <h2 class="text-right no-margin"><?php echo number_format($totNum); ?></h2>
                                    </div>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar bg-green"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-bottom:1px;">
                            <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                <h4 class="text-left text-uppercase"><b>Active Users</b></h4>
                                <div class="row vertical-center-box vertical-center-box-tablet">
                                    <div class="text-left col-xs-3 mar-bot-15">
                                        <label class="label bg-red"> <i class="fa fa-check" aria-hidden="true"></i> *i*</label>
                                    </div>
                                    <div class="col-xs-9 cus-gh-hd-pro">
                                        <h2 class="text-right no-margin"><?php echo number_format($active); ?></h2>
                                    </div>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar progress-bar-danger bg-red"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                <h4 class="text-left text-uppercase"><b>Pending Users </b></h4>
                                <div class="row vertical-center-box vertical-center-box-tablet">
                                    <div class="text-left col-xs-3 mar-bot-15">
                                        <label class="label bg-blue"> <i class="fa fa-minus" aria-hidden="true"></i> *i* </label>
                                    </div>
                                    <div class="col-xs-9 cus-gh-hd-pro">
                                        <h2 class="text-right no-margin"><?php echo number_format($pending); ?></h2>
                                    </div>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar bg-blue"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                <h4 class="text-left text-uppercase"><b>Blocked</b></h4>
                                <div class="row vertical-center-box vertical-center-box-tablet">
                                    <div class="text-left col-xs-3 mar-bot-15">
                                        <label class="label bg-purple"> <i class="fa fa-ban" aria-hidden="true"></i> *i* </label>
                                    </div>
                                    <div class="col-xs-9 cus-gh-hd-pro">
                                        <h2 class="text-right no-margin"><?php echo number_format($suspended); ?></h2>
                                    </div>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar bg-purple"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="traffic-analysis-area mg-tb-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="white-box tranffic-als-inner">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i></small> Total Surveys </h3>
                            <div class="stats-row">
                              <h3 class="text-right no-margin"><?php echo number_format($numSur); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="white-box tranffic-als-inner">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i></small> Active Surveys</h3>
                            <div class="stats-row">
                              <h3 class="text-right no-margin"><?php echo number_format($sopen); ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="white-box tranffic-als-inner">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i></small> Closed Surveys</h3>
                            <div class="stats-row">
                              <h3 class="text-right no-margin"><?php echo number_format($sclosed); ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="white-box tranffic-als-inner">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i></small> Generated Sum</h3>
                            <div class="stats-row">
                              <h3 class="text-right no-margin"><?php echo number_format($survsum); ?></h3>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="author-area-pro mg-tb-30" id="profile">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="author-widgets-single res-mg-t-30">
                            <div class="persoanl-widget-hd">
                                <h2>All Register Customers</h2>
                            </div>
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                    <th>FullName</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Telephone</th>
                                    <th>Date Of Birth</th>
                                    <th>Location</th>
                                    <th>Gender</th>
                                    <th>Education</th>
                                    <th>Occupation</th>
                                    <th>Relationship</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php
                                    if(isset($arr))
                                    {
                                        echo $arr;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th>FullName</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Telephone</th>
                                    <th>Date Of Birth</th>
                                    <th>Location</th>
                                    <th>Gender</th>
                                    <th>Education</th>
                                    <th>Occupation</th>
                                    <th>Relationship</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div class="footer-copyright-area">
            <?php include("footer.php");?>
        </div>
    </div>


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
    <!-- morrisjs JS
		============================================ -->

    <!-- morrisjs JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/jquery.charts-sparkline.js"></script>
    <!-- tab JS
	============================================ -->
    <script src="js/tab.js"></script>
    <!-- calendar JS
		============================================ -->
    <script src="js/calendar/moment.min.js"></script>
    <script src="js/calendar/fullcalendar.min.js"></script>
    <script src="js/calendar/fullcalendar-active.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>


<script>
      $(document).ready(function() {
        $('#example').DataTable();
    } );
    </script>
</body>

</html>


