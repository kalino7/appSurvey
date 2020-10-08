<?php
  include_once("db.php");
  include('checker.php');

  $flag ='';

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check']) )
  {
    $countMsg = count($_POST['check']);
    if($countMsg > 0)
    {
        foreach($_POST['check'] as $key => $val)
        {
            $del = $db->query("DELETE FROM messages WHERE id = '$val' AND userID = '$_SESSION[id]' ");
        }

        if($del)
        {
            $flag = '<div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Successful! </strong> Message(s) Has Been Deleted.
           </div>';
        }
    }
  }

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Inbox | <?php echo $theme; ?></title>
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
       <?php include("Lsidebar.php");?>
    </div>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
      <?php include('logo.php'); ?>
    
      <div class="header-advance-area">
        <?php include("topnav.php");?>
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
                                                    <th>.</th>
                                                    <th>.</th>
                                                    <th>.</th>
                                                    <th>.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $getMsg = $db->query("SELECT * FROM messages WHERE userID = '$_SESSION[id]' ");
                                                        while($dataMsg = $getMsg->fetch_assoc())
                                                        {
                                                            if($dataMsg['status'] == 'seen')
                                                            {
                                                    ?>
                                                                <tr class="unread">
                                                                    <td class="">
                                                                        <div class="checkbox checkbox-single checkbox-success">
                                                                            <input type="checkbox" name="check[]" id="checkItem" value="<?php echo $dataMsg['id'];?>">
                                                                            <label></label>
                                                                        </div>
                                                                    </td>
                                                                    <td><a href="mailview.php?id=<?php echo $dataMsg['id']; ?>"><?php echo $theme;?></a> </td>
                                                                    <td><a href="mailview.php?id=<?php echo $dataMsg['id']; ?>">
                                                                        <?php echo $msg = strlen($dataMsg['msgText']) > 50 ? substr($dataMsg['msgText'],0,50)."..." : $dataMsg['msgText'];?> </a>
                                                                    </td>
                                                                    <td class="text-right mail-date">
                                                                        <?php echo date("D, d M, Y - h:i a", $dataMsg['created_At']); ?>
                                                                    </td>
                                                                </tr>
                                                    <?php   }
                                                            else
                                                            {
                                                    ?>
                                                                <tr class="active">
                                                                    <td class="">
                                                                        <div class="checkbox checkbox-single checkbox-success">
                                                                            <input type="checkbox" name="check[]" id="checkItem" value="<?php echo $dataMsg['id'];?>">
                                                                            <label></label>
                                                                        </div>
                                                                    </td>
                                                                    <td><a href="mailview.php?id=<?php echo $dataMsg['id']; ?>"><?php echo $theme;?></a> <span class="label label-danger">unread</span> </td>
                                                                    <td><a href="mailview.php?id=<?php echo $dataMsg['id']; ?>">
                                                                      <?php echo $msg = strlen($dataMsg['msgText']) > 50 ? substr($dataMsg['msgText'],0,50)."..." : $dataMsg['msgText'];?> </a>
                                                                    </td>
                                                                    <td class="text-right mail-date">
                                                                        <?php echo date("D, d M, Y - h:i a", $dataMsg['created_At']); ?>
                                                                    </td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <!-- <div class="row"> -->
                                    <!-- <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 mg-b-15"> -->
                                        <div class="btn-group">
                                            <a href="mailbox.php" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
                                            <a class="btn btn-default btn-sm" id="delMsg"><i class="fa fa-trash-o"></i></a>
                                            <a class="btn btn-default btn-sm" id="checkAl"><i class="fa fa-check"></i></a>
                                        </div>
                                    <!-- </div> -->
                                <!-- </div> -->
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

            $("#delMsg").click(function(){
                $("#delForm").submit();
            });
        } );
    </script>
</body>

</html>