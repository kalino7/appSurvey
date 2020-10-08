<?php
  include_once("db.php");
  include('adchecker.php');

  $flag ='';

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check']) )
  {
    $curtime = strtotime("now");
    $countMsg = count($_POST['check']);
    if($countMsg > 0)
    {
        $db->autocommit(FALSE);

        $tasks = htmlspecialchars($_POST['task']);
        foreach($_POST['check'] as $key => $val)
        {
          $xotp = 0;
          if($tasks == 'cancel')
          {
              //cancel and refund payment
              $now = strtotime("now");
              $dataIDs = explode('_', $val);
              $dataId = trim($dataIDs[0]);
              $dataAmt = trim($dataIDs[1]);
              $datausrId = trim($dataIDs[2]);

              $upd = $db->query("UPDATE cash SET status = 'Canceled', adminID = '$_SESSION[Aid]', updated_At = '$now' WHERE id = '$dataId'");

              if($upd)
              {
                $upd = $db->query("UPDATE account SET bal = bal+'$dataAmt' WHERE userID = '$datausrId'");
                if($upd)
                {
                  $msgtext = "<p>Your Request For Cash Payment Has Been Declined; Hence The Sum Of 
                  <b>₦".number_format($dataAmt)."</b> Has Been Credited Back To Your Wallet. </p>
                  <p>You May However Choose To Re-Apply For Payment After <i>24</i> hours</p>
                  <p>Signed</p>
                  <p>Management Team</p>
                  ";
                  $stmt = $db->prepare("INSERT INTO messages(msgText, userID, created_At) VALUES(?,?,?) ");
                  $stmt->bind_param("sii", $msgtext, $datausrId, $curtime);
                  $stmt->execute();
                  $stmt->close();
                }
                $xotp = 1;
              }
              else
              {
                $db->rollback();
              }
          }
          elseif($tasks == 'approve')
          {
              //set status to approved
              $now = strtotime("now");
              $dataIDs = explode('_', $val);
              $dataId = trim($dataIDs[0]);
              $dataAmt = trim($dataIDs[1]);
              $datausrId = trim($dataIDs[2]);

              $upd = $db->query("UPDATE cash SET status = 'Approved', adminID='$_SESSION[Aid]', updated_At='$now' WHERE id = '$dataId'");

              if($upd)
              {
                $upd = $db->query("UPDATE account SET withdrawn = withdrawn+'$dataAmt' WHERE userID = '$datausrId'");
                if($upd)
                {
                  $msgtext = "<p>Your Request For Cash Payment Of The Sum <b>₦".number_format($dataAmt)."</b> Has Been Approved. </p>
                  <p>The Status Of Your Request Has Changed; You May View The Transaction History Section To Be Sure.</p>
                  <p>Thanks For Using Our Service</p>
                  <p>Signed</p>
                  <p>Management Team</p>
                  ";
                  $stmt = $db->prepare("INSERT INTO messages(msgText, userID, created_At) VALUES(?,?,?) ");
                  $stmt->bind_param("sii", $msgtext, $datausrId, $curtime);
                  $stmt->execute();
                  $stmt->close();
                }
                $xotp = 2;
              }
              else
              {
                $db->rollback();
              }

          }

        }

        if($upd)
        {
          $db->commit();
            if($xotp == 2)
            {
             $flag = '
             <div class="alert alert-success alert-success-style1">
             <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
             <span class="icon-sc-cl" aria-hidden="true">&times;</span>
             </button>
                 <i class="fa fa-check adminpro-checked-pro admin-check-pro" aria-hidden="true"></i>
                 <p><strong>Successful! </strong> Request(s) Has Been Approved.</p>
             </div>
     ';
            }
            elseif($xotp == 1)
            {
             $flag = '
             <div class="alert alert-warning alert-mg-b alert-success-style4">
                   <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
               <span class="icon-sc-cl" aria-hidden="true">&times;</span>
               </button>
                   <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                   <p><strong>Successful! </strong> Request(s) Was Canceled And Refunded Back To Customers Accont.</p>
               </div>
              ';
            }
        }

        $db->autocommit(TRUE);
    }
  }

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cash List | <?php echo $theme; ?></title>
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
    <link rel="stylesheet" href="css/alerts.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="css/responsive.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">

    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
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


        <div class="mailbox-area mg-tb-15">
            <div class="container-fluid">
                <div class="row">
                    
                    <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="hpanel mg-b-15">
                            <div class="panel-heading hbuilt mailbox-hd">
                            </div>
                            <div class="panel-body">

                                <div class="table-responsive">
                                    <form id="delForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >
                                        <?php echo $flag; ?>
                                        <table id="example" style="width: 100%" class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>
                                                          <div class="checkbox checkbox-single checkbox-success">
                                                              <input type="checkbox" id="checkAl" >
                                                              <label></label>
                                                          </div>
                                                    </th>
                                                    <th>Username</th>
                                                    <th>Request Sum</th>
                                                    <th>Account Name</th>
                                                    <th>Account Number</th>
                                                    <th>Bank Name</th>
                                                    <th>Time of Request</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                  if(isset($cashListArr) && !empty($cashListArr))
                                                  {
                                                    echo $cashListArr;
                                                  }
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <div class="panel-footer">
                                        <div class="btn-group">
                                          <div class="row">
                                            <div class="col-md-4 col-md-4 col-sm-4 col-xs-12">
                                                <a href="cashlist.php" class="btn btn-default btn-md"><i class="fa fa-refresh"></i> Refresh </a>
                                            </div>
                                            
                                            <div class="col-md-4 col-md-4 col-sm-4 col-xs-12">
                                                <a class="btn btn-danger btn-md" id="cancelForm"><i class="fa fa-times"></i> Cancel Transaction </a>
                                            </div>
                                            
                                            <div class="col-md-4 col-md-4 col-sm-4 col-xs-12 ">
                                               <a class="btn btn-success btn-md" id="approveForm"><i class="fa fa-check"></i> Approved Transaction </a>
                                            </div>
                                          </div>
                                            
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable();

            $("#checkAl").click(function () {
                ///$('input:checkbox').prop('checked', 'checked');
                var checkBoxes = $('input:checkbox');
                 checkBoxes.prop("checked", !checkBoxes.prop("checked"));
            });

            $("#cancelForm").click(function(){
                $("#delForm").append(`
                <input type="hidden" name="task" value="cancel" />
            `).submit();
            });

            $("#approveForm").click(function(){
                $("#delForm").append(`
                <input type="hidden" name="task" value="approve" />
            `).submit();
            });

        } );
    </script>
    <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>

</html>