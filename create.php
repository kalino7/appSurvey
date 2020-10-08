<?php
  include_once("db.php");
  include('checker.php');
  include_once("formfxn.php");

  function selectOpts()
  {
    global $db;
    $query = $db->query("SELECT * FROM pricing");
    while($data = $query->fetch_assoc()){
    ?>
        <option value="<?php echo $data['cashTag'];?>" > <?php echo $data['fieldType']; ?> </option>
    <?php
    }
  }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Survey | <?php echo $theme; ?></title>
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

    <link rel="stylesheet" href="css/alerts.css">
    <!-- select2 CSS
		============================================ -->
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <!-- chosen CSS
		============================================ -->
    <link rel="stylesheet" href="css/chosen/bootstrap-chosen.css">
    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>

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

    <style>
      #surveyColor 
      {
          color: #e12503;
      }

      .loader {
  margin: 100px auto;
  font-size: 25px;
  width: 1em;
  height: 1em;
  border-radius: 50%;
  position: relative;
  text-indent: -9999em;
  -webkit-animation: load5 1.1s infinite ease;
  animation: load5 1.1s infinite ease;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
@-webkit-keyframes load5 {
  0%,
  100% {
    box-shadow: 0em -2.6em 0em 0em #ffffff, 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.5), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
  }
  12.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7), 1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
  }
  25% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff, 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  37.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5), 2.5em 0em 0 0em rgba(255, 255, 255, 0.7), 1.75em 1.75em 0 0em #ffffff, 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  50% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.5), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7), 0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  62.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5), 0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff, -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  75% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.5), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7), -2.6em 0em 0 0em #ffffff, -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  87.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5), -2.6em 0em 0 0em rgba(255, 255, 255, 0.7), -1.8em -1.8em 0 0em #ffffff;
  }
}
@keyframes load5 {
  0%,
  100% {
    box-shadow: 0em -2.6em 0em 0em #ffffff, 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.5), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
  }
  12.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7), 1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
  }
  25% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff, 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  37.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5), 2.5em 0em 0 0em rgba(255, 255, 255, 0.7), 1.75em 1.75em 0 0em #ffffff, 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  50% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.5), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7), 0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  62.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5), 0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff, -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  75% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.5), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7), -2.6em 0em 0 0em #ffffff, -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  87.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5), -2.6em 0em 0 0em rgba(255, 255, 255, 0.7), -1.8em -1.8em 0 0em #ffffff;
  }
}
    </style>
</head>
<!--oncontextmenu="return false;"-->
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
        <!-- Basic Form Start -->
        <div class="basic-form-area mg-tb-15">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline12-list">
                            <div class="sparkline12-hd">
                                <div class="main-sparkline12-hd">
                                    <h1 id="surveyColor">Survey Information</h1>
                                </div>
                            </div>
                            <div class="sparkline12-graph">
                                <div class="basic-login-form-ad">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">
                                                <form action="payment.php" method="Post" id="pays">
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Survey Title</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                <input type="text" name="title" required class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="sparkline12-hd mg-t-30 mg-tb-30">
                                                        <div class="main-sparkline12-hd">
                                                            <h1 id="surveyColor">Questions</h1>
                                                        </div>
                                                    </div>


                                                    <div class="form-group-inner quests">

                                                        <div class="questForms" id="div_1">
                                                        <div class="sid_1 col-lg-12 col-md-12 col-sm-12 col-xs-12"><span id="surveyColor" class="numQuests"> Question: 1</span></div>
                                                            <div class="row mg-tb-15">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro">Question Type</label>
                                                                    <div class="form-select-list">
                                                                        <select class="form-control custom-select-value selectOptd" name="questionType[Q1]" id="selectOpt" >
                                                                            <?php 
                                                                                selectOpts();
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro">Required</label>
                                                                    <div class="form-select-list">
                                                                        <select class="form-control custom-select-value" name="optional[Q1]">
                                                                                <option value="Yes">Yes</option>
                                                                                <option value="No">No</option>
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-t-15">
                                                                    <div class="row">
                                                                        
                                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mg-t-15">
                                                                            <button type="button" class="upward btn btn-custon-rounded-four btn-primary"><i class="fa fa-angle-double-up adminpro-informatio" aria-hidden="true"></i> Move Up</button>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-t-15">
                                                                            <button type="button" class="downward btn btn-custon-rounded-four btn-primary"><i class="fa fa-angle-double-down adminpro-informatio" aria-hidden="true"></i> Move Down</button>
                                                                        </div>
                                                                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 mg-t-15">
                                                                            <button type="button" id="del_1" class="remo btn btn-custon-rounded-four btn-danger"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Question</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mg-tb-15">
                                                                
                                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                    <label class="login2 pull-right pull-right-pro"> Question Text: </label>
                                                                </div>
                                                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                                                    <input type="text" name="questionText[Q1]" required class="form-control" />

                                                                    <div class="choice_cat">
                                                                        <div class="choices row mg-tb-15">
                                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                                <label class="login2 pull-right pull-right-pro"> choice Text: </label>
                                                                            </div>
                                                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                                                <input type="text" name="choiceOpt[Q1][C1]" required class="form-control chx" />
                                                                            </div>
                                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                                <button type="button" id="choice_1" class="choiceRem btn btn-custon-rounded-four btn-danger"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Choice</button>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row btnchoice">
                                                                            <div class="col-lg-3 col-md-6 col-sm-8 col-xs-6 login-horizental pull-left ">
                                                                                <button type="button" id="Q1" class="choiceAdd btn btn-custon-rounded-four btn-primary"><i class="fa fa-plus-circle adminpro-informatio" aria-hidden="true"></i> Add Choice</button>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-6 col-sm-8 col-xs-6 login-horizental pull-left ">
                                                                <button type="button" class="btn btn-custon-rounded-four btn-primary" id="add"><i class="fa fa-plus-circle adminpro-informatio" aria-hidden="true"></i> Add Question</button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>


                                                    <div class="form-group-inner">
                                                        <!-- <div class="row"> -->
                                                            <div class="sparkline12-hd mg-t-30 mg-tb-30">
                                                                <div class="main-sparkline12-hd">
                                                                    <h1 id="surveyColor">Category Sections</h1>
                                                                </div>
                                                            </div>
                                                        <!-- </div> -->
                                                        <div class="row">
                                                            
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Number Of Respondents</label>
                                                                <!-- <div class="form-select-list"> -->
                                                                    <input type="number" name="respondent" id="respondent" required class="form-control" />
                                                                <!-- </div> -->
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Gender</label>
                                                                <div class="form-select-list">
                                                                    <select class="form-control custom-select-value" name="gender" required>
                                                                        <option value="All">All</option>
                                                                        <option value="male">Males Only</option>
                                                                        <option value="female">Females Only</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Minimum Age Range</label>
                                                                <input type="number" name="minage" id="minage" min="1" max="100" step="1" required class="form-control" />
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Maximum Age Range</label>
                                                                <input type="number" name="maxage" id="maxage" min="1" max="100" step="1" required class="form-control" />
                                                            </div>

                                                        </div>


                                                        <div class="row">

                                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Level of Education</label>
                                                                <div class="chosen-select-single">
                                                                    <select class="select2_demo_2 form-control" name="edu[]" multiple="multiple" required>
                                                                        <option value="All">All</option>
                                                                        <option value="FSLC"> First School Leaving Certificate (FSLC)</option>
                                                                        <option value="SSCE"> Secondary Education (SSCE/GCE)</option>
                                                                        <option value="OND"> 2 Year Diploma (OND/NCE)</option>
                                                                        <option value="HND"> 4 year Diploma (HND)</option>
                                                                        <option value="BSC"> Bachelor Degree </option>
                                                                        <option value="MSC"> Postgraduate Degree(Masters) </option>
                                                                        <option value="PHD"> Doctorate Degree</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Occupation</label>
                                                                <div class="chosen-select-single">
                                                                    <select class="select2_demo_2 form-control" name="job[]" multiple="multiple" required>
                                                                        <option value="All">All</option>
                                                                        <option value="UDG"> Undergraduate (Student) </option>
                                                                        <option value="PG"> Postgraduate (Student)</option>
                                                                        <option value="SE"> Self Employed </option>
                                                                        <option value="ECS"> Employed (Civil Servant) </option>
                                                                        <option value="EPS"> Employed (Private Sector) </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Relationships</label>
                                                                <div class="chosen-select-single">
                                                                    <select class="select2_demo_2 form-control" name="rship[]" multiple="multiple" required>
                                                                        <option value="All">All</option>
                                                                        <option value="Single">Single</option>
                                                                        <option value="Married">Married</option>
                                                                        <option value="Divorced">Divorced</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label class="login2 pull-right pull-right-pro">Location</label>
                                                                <div class="chosen-select-single">
                                                                    <select class="select2_demo_2 form-control" name="locating[]" multiple="multiple" required>
                                                                        <option value="All">All</option>
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
                                                            </div>

                                                        </div>


                                                    </div>
                                                   
                                                   
                                                    
                                                    
                                                    <div class="form-group-inner">
                                                        <div class="login-btn-inner">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="login-horizental cancel-wp pull-left">
                                                                        <!-- <button class="btn btn-white" type="submit">Cancel</button>
                                                                        <button class="btn btn-sm btn-primary login-submit-cs" type="submit">Save Change</button> -->
                                                                        <script src="https://js.paystack.co/v1/inline.js"></script>
                                                                         <button type="button" class="btn btn-sm btn-primary" onclick="payWithPaystack()">
                                                                         <i class="fa fa-money adminpro-informatio" aria-hidden="true"></i>   
                                                                         Make Payment 
                                                                        </button> 
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <a class="Primary mg-b-10" id="successTriger" href="#" data-toggle="modal" data-target="#PrimaryModalalert" ></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




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
        <!-- Basic Form End-->
        <div class="footer-copyright-area">
            <?php include("footer.php");?>
        </div>
    </div>

    
        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog" style="opacity: 0.01">
                                <div class="modal-content">
                                    
                                    <div class="modal-body">
                                        
                                    </div>
                                </div>
                            </div>
            <div class="loader"></div>
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

    <script src="js/select2/select2.full.min.js"></script>
    <script src="js/select2/select2-active.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>
      
    <?php include("js/extension.php");?>



    <script>
  function payWithPaystack(){
    var required = $('input,textarea,select').filter('[required]:visible');
    var allRequired = true;
    required.each(function(){
        if($(this).val() == ''){
            allRequired = false;
        }
    });

    if(!allRequired){
        //DO SOMETHING HERE... POPUP AN ERROR MESSAGE, ALERT , ETC.
        alert('Please fill all the fields');
    }          
    else
    {
        //service fee
        var charge = 1500;
        // sms charge based on number
        var smsCharge = $('#respondent').val();
        charge += (Number(smsCharge) * 2.50);

         $(".selectOptd").each(function(i){
            charge += Number($(this).val());
         });
         
         //kobo
         charge = charge * 100; 

        var handler = PaystackPop.setup({
      key: 'pk_test_8a0bbc57ee5a3ce8641a0bd61a6be3fd8714a9ad',
      email: '<?php echo $_SESSION['email']; ?>',
      amount: `${charge}`,
    //   ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: [
            {
                display_name: "<?php echo $_SESSION['user']; ?>",
                variable_name: "Username",
                value: "+234"
            }
         ]
      },
      callback: function(response){
        //   alert('success. transaction ref is ' + response.reference);
          if(response.reference)
          {
            $("#pays").append(`
                <input type="hidden" name="referenceID" value="${response.reference}" />
                <input type="hidden" name="amountRef" value="${charge}" />
            `).submit();
            $('#successTriger').trigger('click');
          }
          
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();


    }



    };
</script>

</body>

</html>