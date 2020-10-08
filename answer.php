<?php
  include_once("db.php");
    //   include('checker.php');
    include("lockChecker.php");
    include("question.php");

    // $surveyID = 1;
    $flag = '';
    $tag = '';

  if(isset($_POST['next']) ) 
  {
      //close survey form
      $open = 0;

      //check if userid meets expires condtion
    $curTime = strtotime("now");

    //get the expiring time from when first you load the page
    //use it to do Jquery Count Down

    $expiryTime = htmlspecialchars($_POST['coldplay']);

    $db->autocommit(FALSE);

    //double check for reload purposes
    $query = $db->query("SELECT * FROM selected WHERE token = '$token' AND status = 'alive' ");
    
    if($query->num_rows > 0)
    {
        //remember to change to greater than
        if( $curTime > $expiryTime)
        {
            //echo error. time Has elapsed;
            //set stauts to expired
            try{
                $updateR = $db->query("UPDATE selected SET status='expired' WHERE surveyID = '$surveyID' 
                AND userID = '$_SESSION[id]' ");
                if(!$updateR)
                {
                    throw new Error("Database Error Scripting");
                }
                $db->commit();

                //echo error
                $flag = '
                <div class="alert alert-danger alert-mg-b alert-success-style4">
                <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                    <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                <p><strong>**Oops**, </strong> This Link Is Now Expired; Hence Could Not Be Submitted! </p>
                </div>
            ';
            }
            catch(Exception $e)
            {
                $db->rollback();
            }
            
        }
        else
        {
            $sum =0;
            $specialQuestions = count($_POST['spchoice']);

            foreach($_POST['spchoice'] as $key => $val)
            {
                $newkey = explode("x", $key);
                $newkey[1];
                foreach($val as $gchoice => $ansChoice)
                {
                    $check = $db->query("SELECT * FROM detectorqxt WHERE id = '$newkey[1]' 
                    AND quesAns ='$ansChoice' ");

                    //$db->commit();

                    if($check->num_rows > 0)
                    {
                        //correct
                        $sum +=1;
                    }
                    else
                    {
                        $sum -= 1;
                    }
                }
            }

            if($sum < $specialQuestions)
            {
                //Did not get all special questions right
                //Do not submit form
                //deactivate the link
                //set stauts to failed
            try{
                    $updateR = $db->query("UPDATE selected SET status='failed' WHERE surveyID = '$surveyID' 
                    AND userID = '$_SESSION[id]' ");
                    if(!$updateR)
                    {
                        throw new Error("Database Error Scripting");
                    }
                    $db->commit();

                    //echo error
                    $flag = '
                    <div class="alert alert-danger alert-mg-b alert-success-style4">
                    <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                        <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                    <p><strong>**Sorry**, </strong> You Provided An/Some Incorrect Answer(s); Hereby Deactivating The Link. </p>
                    </div>
                ';
                }
                catch(Exception $e)
                {
                    $db->rollback();
                }
            }
            else
            {
                //get total amount allocated
                $respNumber = responseNumber($surveyID);
                //avoid division by zero error
                if($respNumber == 0)
                {
                    $respNumber += 1;
                }
                
                $surveys = $db->query("SELECT * FROM survey WHERE id = '$surveyID' ");
                //$db->commit();
                $data = $surveys->fetch_assoc();

                $curRespNum = $data['responseNum'];
                $costs = $data['costs'];

                //excluding profit to be shared to answered questions
                $smscharge = ($respNumber * 2.00) + 500;
                $costs = $costs - $smscharge;

                $pay = ($costs / $respNumber);

                if($curRespNum >= $respNumber)
                {
                    //error exceeded required number
                    //close survey
                try{
                        //late entry
                        $updateR = $db->query("UPDATE selected SET status='late' WHERE surveyID = '$surveyID' 
                        AND userID = '$_SESSION[id]' ");

                        //close survey if not Already CLosed
                        $updateR = $db->query("UPDATE survey SET status='closed', updated_At='$curTime' WHERE id = '$surveyID' ");
                        if(!$updateR)
                        {
                            throw new Error("Database Error Scripting");
                        }
                        $db->commit();
        
                        //echo error
                        $flag = '
                        <div class="alert alert-danger alert-mg-b alert-success-style4">
                        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                            <span class="icon-sc-cl" aria-hidden="true">&times;</span>
                        </button>
                        <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
                        <p><strong>**Sorry**, </strong> Maximum Response Number Exceeded For This Survey. </p>
                        </div>
                    ';
                    }
                    catch(Exception $e)
                    {
                        $db->rollback();
                    }
                }
                else
                {
                    //got all the special questions 
                    try
                    {
                        $stmtIns = $db->prepare("INSERT INTO response(surveyID, userID, cash, responseTime) VALUES(?,?,?,?)");
                        $stmtIns->bind_param("iidi", $surveyID, $_SESSION['id'], $pay, $curTime);
                        if(!$stmtIns->execute())
                        {
                            throw new Error("Database Error Scripting");
                        }
                        $db->commit();
                        $stmtIns->close();

                        $getRespId = $db->query("SELECT id FROM response WHERE surveyID = '$surveyID' AND userID='$_SESSION[id]' ORDER BY id DESC LIMIT 1 ");
                        $getRespData = $getRespId->fetch_assoc();
                        $respID = $getRespData['id'];

                        foreach($_POST['choices'] as $key => $val)
                        {

                            if(is_array($val))
                            {
                                // echo "<br/> Question Id: ".$key;
                                foreach($val as $choiceM => $valChoice)
                                {
                                    // echo "<br/> real option: ".$valChoice;
                                
        
                                    // try
                                    // {
                                        $stmtIns = $db->prepare("INSERT INTO answers(questID, ansValue, responseID) VALUES(?,?,?)");
                                        $stmtIns->bind_param("isi", $key, $valChoice, $respID);
                                        if(!$stmtIns->execute())
                                        {
                                            throw new Error("Database Error Scripting");
                                        }
                                        $stmtIns->close();
                                    // }
                                    // catch(Exeception $e)
                                    // {
                                        // $db->rollback();
                                    // }
                                }
                            }
                            else
                            {
                                // echo "<br/> Question Id: ".$key." <=> ".$val."<br/>";
                                // try
                                // {
                                    $stmtIns = $db->prepare("INSERT INTO answers(questID, ansValue, responseID) VALUES(?,?,?)");
                                    $stmtIns->bind_param("isi", $key, $val, $respID);
                                    if(!$stmtIns->execute())
                                    {
                                        throw new Error("Database Error Scripting");
                                    }
                                    $stmtIns->close();
                                // }
                                // catch(Exeception $e)
                                // {
                                //     $db->rollback();
                                // }
                            }
                        }

                        //add cash to users wallet
                        $updateR = $db->query("UPDATE account SET bal=bal+'$pay', total_earned=total_earned+'$pay', forms=forms+'1' 
                        WHERE userID = '$_SESSION[id]' ");

                        //update link
                        $updateR = $db->query("UPDATE selected SET status='used' WHERE surveyID = '$surveyID' 
                        AND userID = '$_SESSION[id]' ");

                        $updateR = $db->query("UPDATE survey SET responseNum=responseNum+'1' WHERE id = '$surveyID' ");

                        if(!$updateR)
                        {
                            throw new Error("Database Error Scripting");
                        }

                        $msgtext = "<p>Your Wallet Has been Credited with the sum of 
                        <b>₦".number_format($pay)."</b> For Having Succesfully Completed A Survey. </p>
                        <p>Signed</p>
                        <p>Management Team</p>
                        ";
                        $stmt = $db->prepare("INSERT INTO messages(msgText, userID, created_At) VALUES(?,?,?) ");
                        $stmt->bind_param("sii", $msgtext, $_SESSION['id'], $curTime);
                        $stmt->execute();
                        $stmt->close();

                        $db->commit();

                        $tag = 100;
                    }
                    catch(Exeception $e)
                    {
                        //echo $e->getMessage();
                        $db->rollback();
                    }

                }


            }

        }
    }
    else
    {
        //token has been used, expired or deactivated as a result of wrong info in answering special questions
        //$open = 0 means survey is closed to this particular user;
        $open = 0;
        $tag = 500;
        $flag = '
        <div class="alert alert-danger alert-mg-b alert-success-style4">
        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
          <span class="icon-sc-cl" aria-hidden="true">&times;</span>
        </button>
        <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
        <p><strong>**Oops**, </strong> Either The Token Is Expired Or You Have Already Used It For This Survey ! </p>
        </div>
        ';
    }

    $db->autocommit(TRUE); 
}

if(!isset($_POST['next']) )
{
    $db->autocommit(FALSE);
    //check if the survey is closed;
    $query = $db->query("SELECT * FROM survey WHERE id = '$surveyID' AND status = 'open' ");
    
    if($query->num_rows > 0)
    {
        //survey is still open
        //check if token is active and not yet used
        $query = $db->query("SELECT * FROM selected WHERE token = '$token' AND status = 'alive' AND userID ='$_SESSION[id]' ");

        if($query->num_rows > 0)
        {
            //the token is active
            //keep form still open
            $open = 1;
            //fetch token expiring time
            //check on form submission and update token column if expired
            $data = $query->fetch_assoc();
            $expiryTime = $data['expires_at'];
        }
        else
        {
            //token has been used, expired or deactivated as a result of wrong info in answering special questions
            //$open = 0 means survey is closed to this particular user;
            $open = 0;
            $tag = 500;
            $flag = '
            <div class="alert alert-danger alert-mg-b alert-success-style4">
              <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                  <span class="icon-sc-cl" aria-hidden="true">&times;</span>
              </button>
              <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
              <p><strong>**Oops**, </strong> The Token Is Either Expired, Has Been Used By You Or
                Does Not Exist For This User Account! </p>
            </div>
          ';
        }

    }
    else
    {
        //survey closed to all
        $open = 0;
        $tag = 403;
        //echo error
        $flag = '
        <div class="alert alert-danger alert-mg-b alert-success-style4">
          <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
              <span class="icon-sc-cl" aria-hidden="true">&times;</span>
          </button>
          <i class="fa fa-times adminpro-danger-error admin-check-pro" aria-hidden="true"></i>
          <p><strong>**Oops**, </strong> This Survey Is Now CLosed! </p>
        </div>
      ';
    }

    $db->autocommit(TRUE);
}


  function responseNumber($surveyID)
  {
    global $db;

    $getNum = $db->query("SELECT consValue FROM criteria WHERE surveyID = '$surveyID' AND consText = 'respNumber' ");
    $dataNum = $getNum->fetch_assoc();
    return $dataNum['consValue'];
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
    <!-- duallistbox CSS
		============================================ -->
        <link rel="stylesheet" href="css/modals.css">
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

    <style>
    
    /* * {
    margin: 0;
    padding: 0
}

html {
    height: 100%
} */

p {
    color: grey
}

#heading {
    text-transform: uppercase;
    color: #673AB7;
    font-weight: normal
}

#msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

.form-card {
    text-align: left
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform input,
#msform textarea {
    padding: 8px 15px 8px 15px;
    border: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: montserrat;
    color: #2C3E50;
    background-color: #ECEFF1;
    font-size: 16px;
    letter-spacing: 1px
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #673AB7;
    outline-width: 0
}

#msform .action-button {
    width: 100px;
    background: #673AB7;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 0px 10px 5px;
    float: right
}

#msform .action-button:hover,
#msform .action-button:focus {
    background-color: #311B92
}

#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px 10px 0px;
    float: right
}

#msform .action-button-previous:hover,
#msform .action-button-previous:focus {
    background-color: #000000
}

.card {
    z-index: 0;
    border: none;
    position: relative
}

.fs-title {
    font-size: 25px;
    color: #673AB7;
    margin-bottom: 15px;
    font-weight: normal;
    text-align: left
}

.purple-text {
    color: #673AB7;
    font-weight: normal
}

.steps {
    font-size: 25px;
    color: gray;
    margin-bottom: 10px;
    font-weight: normal;
    text-align: right
}

.fieldlabels {
    color: gray;
    text-align: left
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey
}

#progressbar .active {
    color: #673AB7
}

#progressbar li {
    list-style-type: none;
    font-size: 15px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400
}

#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f13e"
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f030"
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c"
}

#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: #673AB7
}

.progress {
    height: 20px
}

.progress-bar {
    background-color: #673AB7
}

.fit-image {
    width: 100%;
    margin-left: 0;
    object-fit: contain;
    height: 100px;  
}
    </style>
    <!-- modernizr JS
		============================================ -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="left-sidebar-pro">
      <?php include("LsideAns.php");?>
    </div>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
      <?php include('logo.php'); ?>
        <div class="header-advance-area">
          <?php include("topnav.php");?>
        </div>

        <!-- dual list Start -->
        <div class="dual-list-box-area mg-tb-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline10-list">
                            <div class="sparkline10-hd">
                                <div class="main-sparkline10-hd">
                                    <h1>Survey Forms</h1>
                                </div>
                            </div>
                            <div class="sparkline10-graph">
                                <div class="basic-login-form-ad">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="dual-list-box-inner">
                                            <form id="msform" action="<?php echo htmlspecialchars('answer.php?tok='.$token); ?>" method="post">
                                            <!-- progressbar -->
                                            <?php echo $flag; ?>
                                            <!-- <ul id="progressbar"> -->
                                            <!-- <div class="pull-right" id="time-left"></div> -->
                                                <!-- <li class="active" id="account"><strong>Account</strong></li>
                                                <li id="personal"><strong>Personal</strong></li>
                                                <li id="payment"><strong>Image</strong></li>
                                                <li id="confirm"><strong>Finish</strong></li> -->
                                            <!-- </ul> -->
                                            <?php 
                                            if( ($open == 1) )
                                            {
                                            ?>
                                                                                        <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div> <br> <!-- fieldsets -->

                                                <input type="hidden" name="coldplay" value = "<?php echo $expiryTime; ?>" />
                                            <?php
                                                getQuestions($surveyID);
                                            }
                                            elseif($tag == 100)
                                            {
                                        ?>
                                            <fieldset>
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="fs-title">Finish:</h2>
                                                        </div>
                                                        <div class="col-5">
                                                            <h2 class="steps">Completed</h2>
                                                        </div>
                                                    </div> <br><br>
                                                    <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                                                    <div class="row justify-content-center">
                                                        <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png" alt="Image Here" class="fit-image"> </div>
                                                    </div> <br><br>
                                                    <div class="row justify-content-center">
                                                        <div class="col-7 text-center">
                                                            <h5 class="purple-text text-center">You Have Successfully Completed This Survey</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        <?php
                                            }
                                        ?>

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

        <!-- dual list End-->
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

    <script src="js/icheck/icheck.min.js"></script>
    <script src="js/icheck/icheck-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="js/tab.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>

    <script>
    $(document).ready(function(){

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;
var current = 1;
var steps = $("fieldset").length;

setProgressBar(current);

$(".next").click(function(e){

    var allRequired = true;
    var getFieldo = $(this).parent().find('.question_text[data-is-required="Yes"]');

    getFieldo.each(function(i, obj){
        var questionID = $(this).data('question-id');
        var questionType = $(this).data('question-type');
        var answerCount = 0;

        switch(questionType)
        {
            case 'text':
                answerCount += $('input[name="choices[' + questionID + ']"]').val().length > 0 ? 1 : 0;
            break;

            case 'textarea':
                answerCount += $('textarea[name="choices[' + questionID + ']"]').val().length > 0 ? 1 : 0;
            break;

            case 'radio':
            case 'checkbox':
                answerCount += $('input[name="choices[' + questionID + '][]"]:checked').length;
                answerCount += $('input[name="spchoice[' + questionID + '][]"]:checked').length;
            break;
        }

        if(answerCount == 0)
        {
            allRequired = false;
        }
    });

    

    if(!allRequired && e.cancelable){
        //DO SOMETHING HERE... POPUP AN ERROR MESSAGE, ALERT , ETC.
        alert('This Field Must Not Be Empty');
    }
    else
    {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
        // for making fielset appear animation
        opacity = 1 - now;

        current_fs.css({
        'display': 'none',
        'position': 'relative'
        });
        next_fs.css({'opacity': opacity});
        },
        duration: 500
        });
        setProgressBar(++current);
    }


});

$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 500
});
setProgressBar(--current);
});

function setProgressBar(curStep){
var percent = parseFloat(100 / steps) * curStep;
percent = percent.toFixed();
$(".progress-bar")
.css("width",percent+"%")
}

$(".submit").click(function(e){

    var allRequired = true;
    var getFieldo = $(this).parent().find('.question_text[data-is-required="Yes"]');

    getFieldo.each(function(i, obj){
        var questionID = $(this).data('question-id');
        var questionType = $(this).data('question-type');
        var answerCount = 0;

        switch(questionType)
        {
            case 'text':
                answerCount += $('input[name="choices[' + questionID + ']"]').val().length > 0 ? 1 : 0;
            break;

            case 'textarea':
                answerCount += $('textarea[name="choices[' + questionID + ']"]').val().length > 0 ? 1 : 0;
            break;

            case 'radio':
            case 'checkbox':
                answerCount += $('input[name="choices[' + questionID + '][]"]:checked').length;
                answerCount += $('input[name="spchoice['+ questionID +'][]"]:checked').length;
            break;
        }

        if(answerCount == 0)
        {
            allRequired = false;
        }
    });

    

    if(!allRequired && e.cancelable){
        //DO SOMETHING HERE... POPUP AN ERROR MESSAGE, ALERT , ETC.
        alert('This Field Must Not Be Empty');
        e.preventDefault();
    }
    else
    {
        return true;
    }
});

});

    </script>

    </body>
</html>