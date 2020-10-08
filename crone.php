<?php
  include('sendmail.php');
  include_once("db.php");

  ini_set('max_execution_time', 300);

  $db->autocommit(FALSE);

  //select all surveys with open status
  $surveyStats = $db->query("SELECT * FROM survey WHERE status = 'open' ");
  
  if($surveyStats->num_rows > 0)
  {
    //some open surveys
    while( $dataOpen = $surveyStats->fetch_assoc())
    {
      //get time, survey id, current response number
      $survyID = $dataOpen['id'];
      $survyTime = $dataOpen['updated_At'];
      //add an hr to it
      $survyTime = ($survyTime + 3600);
      $respNumber = $dataOpen['responseNum'];
      $creator = $dataOpen['userID'];

      //get current time
      $curTime = strtotime("now");

      //check if the response has reached it's destined Number
      $arrShip = [];
      $arrLoc = [];
      $arrEdu = [];
      $arrJob = [];
      $RsetAll = 0;
      $LsetAll = 0;
      $EsetAll = 0;
      $JsetAll = 0;
      $surveyResp = $db->query("SELECT * FROM criteria WHERE surveyID = '$survyID' ");
      while($dataResp = $surveyResp->fetch_assoc())
      {
        switch($dataResp['consText'])
        {
          case 'respNumber':
              $desiredNum = $dataResp['consValue'];
          break;
          case 'minage':
              $minage = $dataResp['consValue'];
          break;
          case 'maxage':
              $maxage = $dataResp['consValue'];
          break;
          case 'gender':
            $gender = $dataResp['consValue'];
          break;
          case 'rship':
              if($dataResp['consValue'] == 'All')
              {
                  $RsetAll = 1;
              }
              array_push( $arrShip , $dataResp['consValue']);
          break;
          case 'locating':
              if($dataResp['consValue'] == 'All')
              {
                  $LsetAll = 1;
              }
              array_push( $arrLoc , $dataResp['consValue']);
          break;
          case 'edu':
            if($dataResp['consValue'] == 'All')
            {
                $EsetAll = 1;
            }
            array_push( $arrEdu , $dataResp['consValue']);
          break;
          case 'job':
            if($dataResp['consValue'] == 'All')
            {
                $JsetAll = 1;
            }
            array_push( $arrJob , $dataResp['consValue']);
          break;
          
          default:
          break;
        }
      }

      if($respNumber < $desiredNum)
      {
        //actual number not yet attained
        //check if it's over an when the survey was created
        if($curTime > $survyTime)
        {
          //means all unused links must have been deactivated

          //select new users based on the criteria
          $queryst = "SELECT * FROM users WHERE NOT id= '$creator' AND  userStats='Active' AND (age >= '$minage' AND age <= '$maxage') ";
          
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
                $userID = $dataSel['id'];
                $fullname = $dataSel['fullname'];
                $userEmail = $dataSel['email'];
                $created = strtotime("now");
                $mix = $dataSel['username']."_".$created;
                $token = sha1(uniqid($mix, true));
                $expires = strtotime("+1 hour");
                $stmtSel->execute();

                sleep(1);
                //send email
                SenderToken($token, $userEmail, $fullname);
            }
            $stmtSel->close();

            //update survey created time
            $newSurTime = $db->query("UPDATE survey SET updated_At='$curTime' WHERE id = '$survyID'");
          }


          //delete all expired links
          $delExpiredToks = $db->query("DELETE FROM selected WHERE status='Expired' ");

        }
        //else the links sent out are still valid

        //update survey created time
        // $newSurTime = $db->query("UPDATE survey SET updated_At='$curTime' WHERE id = '$survyID'");
      }
      else
      {
        //close survey
        $closeSur = $db->query("UPDATE survey SET status='closed', updated_At='$curTime' WHERE id = '$survyID'");
      }

      sleep(4);
    }
  }

  $db->commit();
  $db->autocommit(TRUE);
?>