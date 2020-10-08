<?php
    include('sendmail.php');
    require('vendor/autoload.php');
    include_once("db.php");
    include('checker.php');
    include_once("formfxn.php");

    $xox = 0;

    if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($_POST) && isset($_POST['amountRef']))
    {

        $surveyName = $_POST['title'];
        $refid = $_POST['referenceID'];
        $amount = ($_POST['amountRef']/100);
        $curTime = strtotime("now");
        //get survey Id

        $stmtQ = $db->prepare("INSERT INTO survey(surveyName, userID, costs, referenceID, created_At, updated_At) VALUES(?,?,?,?,?,?)");
        $stmtQ->bind_param("sidsii", $surveyName, $_SESSION['id'], $amount, $refid, $curTime, $curTime);

        if($stmtQ->execute())
        {
            $stmtQ->close();

            $checkQustns  = count($_POST['questionType']);

            if($checkQustns > 0 )
            {
                //user submitted at least one question on the form
                $surveyID = getSurId($surveyName, $_SESSION['id'], $refid);
                
                            //question time
                
                            foreach($_POST['questionType'] as $key => $value)
                            {
                    
                                // print_r("question ".$key." is: ".$_POST['questionText'][$key]);
                                $stmtQxt = $db->prepare("INSERT INTO questions(surveyID, quesType, quesText, isRequired, costs) VALUES(?,?,?,?,?)");
                                
                                if($value == $arrayPrices[0])
                                {
                                    $quesType = 'radio';
                                }
                                elseif($value == $arrayPrices[1])
                                {
                                    $quesType = 'checkbox';
                                }
                                elseif($value == $arrayPrices[2])
                                {
                                    $quesType = 'text';
                                }
                                else
                                {
                                    $quesType = 'textarea';
                                }
                
                                $stmtQxt->bind_param("isssd", $surveyID, $quesType, $_POST['questionText'][$key], $_POST['optional'][$key], $value);
                
                                if($stmtQxt->execute())
                                {
                                    //choice time
                
                                    if( ($quesType == 'radio') || ($quesType == 'checkbox') )
                                    {
                                        //get question ID
                                        $questionID = getQuestId($surveyID, $quesType, $value);
                
                                        if(isset($_POST['choiceOpt'][$key]) && !empty($_POST['choiceOpt'][$key]) )
                                        {
                                            foreach($_POST['choiceOpt'][$key] as $choiceKey => $choiceVal)
                                            {
                                                if(!empty($choiceVal))
                                                {
                                                    // print_r("<br/>option(s) for Question ".$key." is: ".$choiceVal);
                                                    $stmtChx = $db->prepare("INSERT INTO choice(questID, choiceText) VALUES(?,?)");
                                                    $stmtChx->bind_param("is", $questionID, $choiceVal);
                                                    $stmtChx->execute();
                                                    $stmtChx->close();
                                                }
                                            }
                                        }
                                    }
                
                                    $stmtQxt->close();
                                }
                
                            }
                
                            //Lie Detector
                            $detquery = $db->query("SELECT id FROM detectorqxt ORDER BY RAND() limit 2");
                            while($detfetch = $detquery->fetch_assoc())
                            {
                              $detID = $detfetch['id'];
                              $stmtDxt = $db->prepare("INSERT INTO detector(surveyID, detectorID) VALUES(?,?)");
                              $stmtDxt->bind_param("ii", $surveyID, $detID);
                              $stmtDxt->execute();
                              $stmtDxt->close();
                            }
                
                            $respondent = $_POST['respondent'];
                            $gender = $_POST['gender'];
                            $minage = $_POST['minage'];
                            $maxage = $_POST['maxage'];
                
                            $stmtCat = $db->prepare("INSERT INTO criteria(surveyID, consText, consValue) VALUES(?,?,?)");
                            $stmtCat->bind_param("iss", $survyID, $constext, $consval);
                
                            $survyID = $surveyID;
                            $constext = 'respNumber';
                            $consval = $respondent;
                            $stmtCat->execute();
                
                            $survyID = $surveyID;
                            $constext = 'gender';
                            $consval = $gender;
                            $stmtCat->execute();
                
                            $survyID = $surveyID;
                            $constext = 'minage';
                            $consval = $minage;
                            $stmtCat->execute();
                
                            $survyID = $surveyID;
                            $constext = 'maxage';
                            $consval = $maxage;
                            $stmtCat->execute();
                
                            $arrShip = [];
                            $arrLoc = [];
                            $arrEdu = [];
                            $arrJob = [];
                            $RsetAll = 0;
                            $LsetAll = 0;
                            $EsetAll = 0;
                            $JsetAll = 0;
                
                            foreach($_POST['rship'] as $reyKey => $reyVal)
                            {
                                $survyID = $surveyID;
                                $constext = 'rship';
                                $consval = $reyVal;
                                if($reyVal == 'All')
                                {
                                    $RsetAll = 1;
                                }
                                array_push($arrShip, $reyVal);
                                $stmtCat->execute();
                            }
                
                            foreach($_POST['locating'] as $locKey => $locVal)
                            {
                                $survyID = $surveyID;
                                $constext = 'locating';
                                $consval = $locVal;
                                if($locVal == 'All')
                                {
                                    $LsetAll = 1;
                                }
                                array_push($arrLoc, $locVal);
                                $stmtCat->execute();
                            }

                            foreach($_POST['edu'] as $eduKey => $eduVal)
                            {
                                $survyID = $surveyID;
                                $constext = 'edu';
                                $consval = $eduVal;
                                if($eduVal == 'All')
                                {
                                    $EsetAll = 1;
                                }
                                array_push($arrEdu, $eduVal);
                                $stmtCat->execute();
                            }

                            foreach($_POST['job'] as $jobKey => $jobVal)
                            {
                                $survyID = $surveyID;
                                $constext = 'job';
                                $consval = $jobVal;
                                if($jobVal == 'All')
                                {
                                    $JsetAll = 1;
                                }
                                array_push($arrJob, $jobVal);
                                $stmtCat->execute();
                            }
                
                            $stmtCat->close();
                
                
                            //selection tab
                            $queryst = "SELECT * FROM users WHERE NOT id= '$_SESSION[id]' AND  userStats='Active' AND (age >= '$minage' AND age <= '$maxage') ";
                            
                            if($gender != 'All')
                            {
                                $queryst .= "AND ( gender = '$gender' ) ";
                            }

                            if(!empty($arrShip) && $RsetAll == 0)
                            {
                                $arrLength = count($arrShip);
                                $k = $arrLength - 1;
                                for( $i=0; $i < $arrLength; $i++)
                                {
                                    if($i == 0)
                                    {
                                        $queryst .= "AND ( ";
                                    }
                                    
                                    if($i == $k)
                                    {
                                        $queryst .= " relationship = '$arrShip[$i]' )";
                                    }
                                    else
                                    {
                                        $queryst .= " relationship = '$arrShip[$i]' OR ";
                                    }
                                }
                            }
                
                            if(!empty($arrLoc) && $LsetAll == 0)
                            {
                                $arrLength = count($arrLoc);
                                $k = $arrLength - 1;
                                for( $i=0; $i < $arrLength; $i++)
                                {
                                    if($i == 0)
                                    {
                                        $queryst .= "AND ( ";
                                    }
                                    
                                    if($i == $k)
                                    {
                                        $queryst .= " located = '$arrLoc[$i]' )";
                                    }
                                    else
                                    {
                                        $queryst .= " located = '$arrLoc[$i]' OR ";
                                    }
                                }
                            }

                            if(!empty($arrEdu) && $EsetAll == 0)
                            {
                                $arrLength = count($arrEdu);
                                $k = $arrLength - 1;
                                for( $i=0; $i < $arrLength; $i++)
                                {
                                    if($i == 0)
                                    {
                                        $queryst .= "AND ( ";
                                    }
                                    
                                    if($i == $k)
                                    {
                                        $queryst .= " education = '$arrEdu[$i]' )";
                                    }
                                    else
                                    {
                                        $queryst .= " education = '$arrEdu[$i]' OR ";
                                    }
                                }
                            }

                            if(!empty($arrJob) && $JsetAll == 0)
                            {
                                $arrLength = count($arrJob);
                                $k = $arrLength - 1;
                                for( $i=0; $i < $arrLength; $i++)
                                {
                                    if($i == 0)
                                    {
                                        $queryst .= "AND ( ";
                                    }
                                    
                                    if($i == $k)
                                    {
                                        $queryst .= " occupation = '$arrJob[$i]' )";
                                    }
                                    else
                                    {
                                        $queryst .= " occupation = '$arrJob[$i]' OR ";
                                    }
                                }
                            }

                            $stmtSel = $db->prepare("INSERT INTO selected(surveyID, userID, token, created_at, expires_at) VALUES(?,?,?,?,?)");
                            $stmtSel->bind_param("iisii", $survyID, $userID, $token, $created, $expires);
                
                            $querySel = $db->query($queryst);
                
                            if($querySel->num_rows > 0)
                            {
                                while($dataSel = $querySel->fetch_assoc())
                                {
                                    $survyID = $surveyID;
                                    $userID = $dataSel['id'];
                                    $fullname = $dataSel['fullname'];
                                    $userEmail = $dataSel['email'];
                                    $created = strtotime("now");
                                    $mix = $dataSel['username']."_".$created;
                                    $token = sha1(uniqid($mix, true));
                                    $expires = strtotime("+1 hour");
                                    $stmtSel->execute();
                
                                    //send SMS
                                    //$phone = $dataSel['telephone'];
                                    //$url = "http://localhost/appSurvey/lock.php?tok=".$token;
                                    if($xox == 0)
                                    {
                                        // $basic  = new \Nexmo\Client\Credentials\Basic('1bbce512', '47eb826b167e6716');
                                        // $client = new \Nexmo\Client($basic);
                
                                        // $response = $client->sms()->send(
                                        //     new \Nexmo\SMS\Message\SMS('2347063545910', 'App_Survey', "http://localhost/appSurvey/lock.php?tok='.$token.'")
                                        // );
                                        
                                        // $message = $response->current();
                                        
                                        // if ($message->getStatus() == 0) {
                                        //     echo "The message was sent successfully\n";
                                        // } else {
                                        //     echo "The message failed with status: " . $message->getStatus() . "\n";
                                        // }
                                        
                
                
                
                                        $xox = 1;
                                    }
                
                
                                    //send email
                                    SenderToken($token, $userEmail, $fullname);
                                }
                                $stmtSel->close();
                            }
                                    //successful
             header('location: criteria.php?id='.$surveyID);
             ?>
                     <script>
                       setTimeout(() => {
                         window.location.href = "criteria.php?id="<?php echo $surveyID; ?>;
                       }, 0000);  
                     </script>
             <?php
            }
            else
            {
                //send mail to admin stating user submitted an empty question form
                header('location: dashboard.php');
            }

        }


    }
    else{
        header('location: create.php');
        echo "Form Not Submitted";
    }
?>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>