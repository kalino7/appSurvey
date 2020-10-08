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
        ///later decide whether users are to view survey responses while status is open
  
      }
    }


    function dynamiColor()
    {
      return 'rgb(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ')';
    }
  ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Graphical Representation | <?php echo $theme; ?></title>
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


        <!-- Charts Start-->
        <div class="charts-area mg-tb-15">
            <div class="container-fluid">
            <?php
                $getAllQuest = $db->query("SELECT * FROM questions WHERE surveyID = '$surveyID' AND (quesType = 'radio' OR quesType = 'checkbox') ");
                if($getAllQuest->num_rows > 0)
                {

                  $arrPhase = [];

                  while($dataQuest = $getAllQuest->fetch_assoc())
                  {

                    $arrID = [];
                    $arrLabels = [];
                    $arrColor = [];
                    $arrNums = [];



                    $qustID = $dataQuest['id'];
                    $questText = $dataQuest['quesText'];

                    array_push($arrID, 'piechart'.$qustID);

                    //get choices
                    $getChoice = $db->query("SELECT * FROM choice WHERE questID = '$qustID' ");
                    while($dataChoice = $getChoice->fetch_assoc())
                    {
                      //serves as label
                      $choiceTxt = $dataChoice['choiceText'];
                      array_push($arrLabels, $choiceTxt);

                      array_push($arrColor, dynamiColor());

                      //get count val
                      $getCount = $db->query("SELECT * FROM answers WHERE questID = '$qustID' AND ansValue = '$choiceTxt' ");
                      $countNum = $getCount->num_rows;
                      array_push($arrNums, $countNum);
                    }
            ?>
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="charts-single-pro responsive-mg-b-30">
                              <div class="alert-title">
                                  <h2><?php echo $questText; ?></h2>
                                  <p>A Pie chart showing data values for this survey question.</p>
                              </div>
                              <div id="pie-chart">
                                  <canvas id="<?php echo "piechart".$qustID; ?>" style="height: 30%"></canvas>
                              </div>
                          </div>
                      </div>
                  </div>
            <?php
                    array_push($arrPhase, [ 'id' => $arrID, 'labels'=> $arrLabels, 
                    'bkColor'=> $arrColor, 'countData'=> $arrNums]);
                  }
                }else
                {
            ?>
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="charts-single-pro responsive-mg-b-30">
                              <div class="alert-title">
                                  <h2>NONE</h2>
                                  <p>A Graph Could Not Be Plotted For This Survey Type Unfortunately</p>
                              </div>
                          </div>
                      </div>
                  </div>
            <?php
                }
            ?>
            
            </div>
        </div>
        <!-- Charts End-->
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
    <!-- Charts JS
		============================================ -->
    <script src="js/charts/Chart.js"></script>
    <!-- <script src="js/charts/rounded-chart.js"></script> -->
    <!-- metisMenu JS
		============================================ -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
    <script src="js/metisMenu/metisMenu-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="js/tab.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>

  <?php
    if($getAllQuest->num_rows > 0)
    {
      foreach($arrPhase as $phase)
      {
?>
    <script>
        (function ($) {
          "use strict";
          
            /*----------------------------------------*/
            /*  1.  pie Chart
            /*----------------------------------------*/
            var ctx = document.getElementById("<?php echo $phase['id'][0]; ?>");
            var piechart = new Chart(ctx, {
              type: 'pie',
              data: {
                labels: <?php echo json_encode($phase['labels'], JSON_NUMERIC_CHECK); ?>,
                datasets: [{
                  label: 'pie Chart',
                          backgroundColor: <?php echo json_encode($phase['bkColor'], JSON_NUMERIC_CHECK); ?>,
                  data: <?php echo json_encode($phase['countData'], JSON_NUMERIC_CHECK); ?>
                      }]
              },
              options: {
                responsive: true
              }
            });
            
          })(jQuery);

    </script>

<?php
      }
    }
  ?>


</body>

</html>