<?php
    include_once("db.php");
    include('checker.php');

    $sel = $db->query("SELECT * FROM account WHERE userID = '$_SESSION[id]' ");
    $dataRec = $sel->fetch_assoc();
    $curBal = $dataRec['bal'];
    $withdrawn = $dataRec['withdrawn'];
    $totalEarned = $dataRec['total_earned'];
    $forms = $dataRec['forms'];

    $userD = $db->query("SELECT * FROM users WHERE id = '$_SESSION[id]' ");
    $getUserD = $userD->fetch_assoc();
    $fullname = $getUserD['fullname'];
    $telephone = $getUserD['telephone'];
    $dob = $getUserD['dob'];
    $location = $getUserD['located'];
    $relationships = $getUserD['relationship'];
    $registration = $getUserD['created_at'];
    $gender = $getUserD['gender'];

    switch($getUserD['education'])
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

    switch($getUserD['occupation'])
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


    $getSury = $db->query("SELECT * FROM survey WHERE userID = '$_SESSION[id]'");
    $numSur = $getSury->num_rows;
    $sopen = 0;
    $sclosed = 0;

    if($numSur > 0)
    {
        while($dataSur= $getSury->fetch_assoc())
        {
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
    <title>Dashboard V | <?php echo $theme; ?></title>
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
        <link rel="stylesheet" href="css/tabs.css">
        <!-- modals CSS
		============================================ -->
    <link rel="stylesheet" href="css/modals.css">
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

    <script>

    document.onkeydown = function (e) {
        if (event.keyCode == 123) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'i'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'C'.charCodeAt(0) || e.keyCode == 'c'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'J'.charCodeAt(0) || e.keyCode == 'j'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'U'.charCodeAt(0) || e.keyCode == 'u'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 's'.charCodeAt(0))) {
            return false;
        }
    }
</script>

</head>

<body oncontextmenu="return false;">

    <div class="left-sidebar-pro">
        <?php include("Lsidebar.php");?>
    </div>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        
        <?php include('logo.php'); ?>

        <div class="header-advance-area">
            <?php include("topnav.php");?>
        </div>


        <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['cashSumit']))
    {
        $bankN = trim( htmlspecialchars($_POST['bankName']) );
        $accN = trim( htmlspecialchars($_POST['accName']) );
        $acNo = trim( htmlspecialchars($_POST['accNo']) );

        $stmt = $db->prepare("INSERT INTO banks(userID, accountName, accountNo, bankName) VALUES(?,?,?,?)");
        $stmt->bind_param("isss", $_SESSION['id'], $accN, $acNo, $bankN);
        
        if($stmt->execute())
        {
            //trigger success modal
            $suc = 1;
        ?>
            <script>
                 $(document).ready(function(){
                    $('#successTriger').trigger('click');
                });
            </script>
        <?php
        }
        else
        {
            //trigger error modal
        }
    }

    ///request for cash
    if(isset($_POST['cashSumit']))
    {
        $amt = trim(htmlspecialchars($_POST['cashback']));
        $remBal = $curBal - $amt;
        
        if($remBal < 50)
        {
            //pop N50 error
    ?>
        <script>
                 $(document).ready(function(){
                    $('#errorTriger1').trigger('click');
                });
        </script>
        
    <?php
        }
        else
        {
            $db->autocommit(FALSE);
            //INS REQUEST
            $curTime = strtotime("now");
            $stmtC = $db->prepare("INSERT INTO cash(userID, amount, created_At, updated_AT) VALUES(?,?,?,?)");
            $stmtC->bind_param("idii", $_SESSION['id'], $amt, $curTime, $curTime);
            if($stmtC->execute())
            {
                //updcash rec
                $cashUpd = $db->query("UPDATE account SET bal = '$remBal' WHERE userID = '$_SESSION[id]' ");
                if($db->commit())
                {
                    $curBal = $remBal;
                    $suc = 2;
                ?>
                    <script>
                         $(document).ready(function(){
                            $('#successTriger').trigger('click');
                        });
                    </script>
                <?php
                }
                else
                {
                    $db->rollback();
                }
            }

            $db->autocommit(TRUE);
        }
    }


    $bank = $db->query("SELECT * FROM banks WHERE userID = '$_SESSION[id]'");
    $setBank = $bank->num_rows;
    if($setBank > 0)
    {
        //records exist
        $getBank = $bank->fetch_assoc();
        $bankName = $getBank['bankName'];
        $accName = $getBank['accountName'];
        $accNo = $getBank['accountNo'];
        $setDate = $getBank['created_At'];
    }

?>

        <a class="Primary mg-b-10" id="successTriger" href="#" data-toggle="modal" data-target="#PrimaryModalalert" ></a>
        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                    </div>
                                    <div class="modal-body">
                                        <i class="fa fa-check modal-check-pro"></i>
                                        <h2>Successful!</h2>
                                    <?php 
                                        if(isset($suc))
                                        {
                                            switch($suc)
                                            {
                                                case 1:
                                                    echo'
                                                    <p>Account Details Registered</p>';
                                                break;
                                                case 2:
                                                    echo'
                                                    <p>Your Request For Cash Has Been Submitted</p>
                                                    <p>Check the Status of Your Request At The Transaction History</p>';
                                                break;
                                                default:
                                                break;
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
        </div>

        <a class="Danger mg-b-10" id="errorTriger1" href="#" data-toggle="modal" data-target="#DangerModalalert" ></a>
        <div id="DangerModalalert" class="modal modal-adminpro-general FullColor-popup-DangerModal fade in" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                                    </div>
                                    <div class="modal-body">
                                        <i class="fa fa-times modal-check-pro"></i>
                                        <h2>**Oops**</h2>
                                        <p>Must Have A balance Of At Least N50 To Keep The Account Open</p>
                                    </div>
                                </div>
                            </div>
        </div>


        <div class="section-admin container-fluid res-mg-t-15 mg-tb-30">
            <div class="row admin text-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="admin-content analysis-progrebar-ctn">
                                <h4 class="text-left text-uppercase"><b>Current Balance</b></h4>
                                <div class="row vertical-center-box vertical-center-box-tablet">
                                    <div class="col-xs-3 mar-bot-15 text-left">
                                        <label class="label bg-green"> <i class="fa fa-level-up" aria-hidden="true"></i> ₦</label>
                                    </div>
                                    <div class="col-xs-9 cus-gh-hd-pro">
                                        <h2 class="text-right no-margin"><?php echo number_format($curBal); ?></h2>
                                    </div>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar bg-green"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-bottom:1px;">
                            <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                <h4 class="text-left text-uppercase"><b>Total Withdrawn</b></h4>
                                <div class="row vertical-center-box vertical-center-box-tablet">
                                    <div class="text-left col-xs-3 mar-bot-15">
                                        <label class="label bg-red"> <i class="fa fa-level-down" aria-hidden="true"></i> ₦</label>
                                    </div>
                                    <div class="col-xs-9 cus-gh-hd-pro">
                                        <h2 class="text-right no-margin"><?php echo number_format($withdrawn); ?></h2>
                                    </div>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 100%;" class="progress-bar progress-bar-danger bg-red"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                <h4 class="text-left text-uppercase"><b>Total Earned</b></h4>
                                <div class="row vertical-center-box vertical-center-box-tablet">
                                    <div class="text-left col-xs-3 mar-bot-15">
                                        <label class="label bg-purple"> <i class="fa fa-level-up" aria-hidden="true"></i> ₦ </label>
                                    </div>
                                    <div class="col-xs-9 cus-gh-hd-pro">
                                        <h2 class="text-right no-margin"><?php echo number_format($totalEarned); ?></h2>
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
        
        <div class="traffic-analysis-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box tranffic-als-inner">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa fa-sort-asc"></i></small> Surveys Created</h3>
                            <div class="stats-row">
                                <div class="stat-item">
                                    <h6>Open</h6>
                                    <b><?php echo $sopen;?></b></div>
                                <div class="stat-item">
                                    <h6>Closed</h6>
                                    <b><?php echo $sclosed;?></b></div>
                                <div class="stat-item">
                                    <h6>Total</h6>
                                    <b><?php echo $numSur;?></b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="white-box tranffic-als-inner res-mg-t-30">
                            <h3 class="box-title"><small class="pull-right m-t-10 text-danger"><i class="fa fa-sort-desc"></i> </small> Surveys Answered </h3>
                            <div class="stats-row">
                                <div class="stat-item">
                                    <h3 class="text-right no-margin"><?php echo $forms; ?></h3>
                                </div>
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
                        <div class="personal-info-wrap">
                            <div class="widget-head-info-box">
                                <div class="persoanl-widget-hd">
                                    <h2><?php echo $fullname; ?></h2>
                                    <p>App Survey User</p>
                                </div>
                                <img src="img/notification/survey-icon.jpg" class="img-circle circle-border m-b-md" alt="profile">
                                <div class="social-widget-result">
                                    <span>Registered User Since</span> :::
                                    <span><?php echo date("Y/M/d" , strtotime($registration)); ?></span>
                                </div>
                            </div>
                            
                            <!-- begins here -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="admintab-wrap mg-t-30">
                                        <ul class="nav nav-tabs custom-menu-wrap custon-tab-menu-style1">
                                            <li class="active"><a data-toggle="tab" href="#TabProject"><span class="adminpro-icon adminpro-analytics tab-custon-ic"></span>General</a>
                                            </li>
                                            <li><a data-toggle="tab" href="#TabDetails"><span class="adminpro-icon adminpro-analytics-arrow tab-custon-ic"></span>Bank Details</a>
                                            </li>
                                            <li><a data-toggle="tab" href="#TabDetails1"><span class="adminpro-icon adminpro-analytics-arrow tab-custon-ic"></span>Cash Request</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="TabProject" class="tab-pane in active animated flipInX custon-tab-style1">
                                                <form>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Email Address </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $_SESSION['email'];?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Mobile Number </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $telephone;?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Gender </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $gender;?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Date of Birth </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $dob;?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Level of Education </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $education;?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Occupation </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $occupation;?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Relationship Status </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $relationships;?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Selected Location </label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" disabled class="form-control" placeholder="<?php echo $location;?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="TabDetails" class="tab-pane animated flipInX custon-tab-style1">
                                                <?php 
                                                    if($setBank == 0)
                                                    {
                                                        //button to set bank Details Page;
                                                    ?>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <a class="btn btn-info Primary mg-b-10" href="#" data-toggle="modal" data-target="#PrimaryModalhdbgcl">Set Account Details </a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <form>
                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro">Account Name </label>
                                                                </div>
                                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                    <input type="text" disabled class="form-control" placeholder="<?php echo $accName;?>" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro">Account Number </label>
                                                                </div>
                                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                    <input type="text" disabled class="form-control" placeholder="<?php echo $accNo;?>" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro">Bank Name </label>
                                                                </div>
                                                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                    <input type="text" disabled class="form-control" placeholder="<?php echo $bankName;?>" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>

                                                    <?php
                                                    }
                                                ?>
                                            </div>

                                            <div id="TabDetails1" class="tab-pane animated flipInX custon-tab-style1">
                                                <?php 
                                                    if($setBank == 0)
                                                    {
                                                        //button to set bank Details Page;
                                                    ?>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <a class="btn btn-info Primary mg-b-10" href="#" data-toggle="modal" data-target="#PrimaryModalhdbgcl">Set Account Details </a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <form method="Post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro">Enter Amount </label>
                                                                </div>
                                                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                                   <input type="text" class="form-control" name="cashback" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group-inner">
                                                            <div class="row">
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro"></label>
                                                                </div>
                                                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                                    <input type="submit" class="btn btn-primary" name="cashSumit" Value="Request Cash" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>

                                                    <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ends here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="PrimaryModalhdbgcl" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header header-color-modal bg-color-1">
                            <h4 class="modal-title">Set Bank Details</h4>
                            <div class="modal-close-area modal-close-df">
                                <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                        <form id="bankD" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                        
                        <div class="modal-body">
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="login2 pull-right pull-right-pro">Bank Name </label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <!-- <input type="text" class="form-control" name="bankName" required /> -->
                                        <select class="form-control" name="bankName" required>
                                            <option value="">Select Bank Name</option>
                                            <option value="First Bank"> First Bank </option>
                                            <option value="Guarrantee Trust Bank"> Guarrantee Trust Bank</option>
                                            <option value="Diamond/Access Bank"> Diamond/Access Bank</option>
                                            <option value="Zenith Bank"> Zenith Bank</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="login2 pull-right pull-right-pro">Account Name </label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="accName" required/>
                                </div>
                                </div>
                            </div>

                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="login2 pull-right pull-right-pro">Account Number </label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" name="accNo" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="10" required/>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a data-dismiss="modal" href="#">Cancel</a>
                            <a href="#" id="setBD">Submit  </a>
                        </div>

                        </form>


                    </div>
                </div>
            </div>


        </div>

        <div class="footer-copyright-area">
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

    <script>
        $(document).ready(function(){
            $('#setBD').click(function(){
                var allR = $('input, select').filter('[required]:visible');
                var Req = true;

                allR.each(function(){
                    if($(this).val() == '')
                    {
                        Req = false;
                        $(this).attr('placeholder', 'Please Enter Correct Value For This Column');
                    }
                });
                if(Req)
                {
                    $("#bankD").submit();
                }
                else
                {
                    alert("Please Fill All Columns");
                }

            });
        });
    </script>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>

</html>


