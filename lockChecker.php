<?php

  $curpage = basename($_SERVER['SCRIPT_NAME'], '.php');
  
  if($curpage != 'lock' && isset($_SESSION['user']))
  {
    if((time() - $_SESSION['activity']) > 1800 )
    {
      //inactive for more than 30mins
      unset($_SESSION['user']);
      unset($_SESSION['id']);
      session_destroy();
    }
    else
    {
      $_SESSION['activity'] = time();
    }
  }


  if( isset($_SESSION['user']) && !empty($_SESSION['user']) && $curpage == 'lock' 
  && isset($_GET['tok']) && $_GET['tok'] != '' )
  {
    $token = trim($_GET['tok']);
    $token = htmlspecialchars($token);

    $query = $db->query("SELECT * FROM selected WHERE token = '$token' AND userID = '$_SESSION[id]' ");
    
    if($query->num_rows > 0)
    {
      header('location: answer.php?tok='.$token);
      ?>
        <script>
          setTimeout(() => {
            var x = "<?php echo $token;?>";
            window.location.href="answer.php?tok="+x;
          }, 0000);
        </script>
      <?php
    }
    
  }
  elseif( (!isset($_SESSION['user']) || empty($_SESSION['user']) || !isset($_GET['tok']) || $_GET['tok'] == '' ) 
  && $curpage != 'lock')
  {
    $token = trim($_GET['tok']);
    $token = htmlspecialchars($token);
    header('location: lock.php?tok='.$token);
    ?>
    <script>
      setTimeout(() => {
        var x = "<?php echo $token;?>";
        window.location.href="lock.php"+x;
      }, 0000);
    </script>
  <?php
  }



  //for lock page
  if(isset($_GET['tok']))
  {
    $token = trim($_GET['tok']);
    $token = htmlspecialchars($token);

    $query = $db->query("SELECT * FROM selected WHERE token = '$token' ");
    
    if($query->num_rows > 0)
    {
        $tag = 316;
        $data = $query->fetch_assoc();
        $userid = $data['userID'];
        $surveyID = $data['surveyID'];
    }
    else
    {
      $tag = 0;
      $flag = '
      <h1 class="mg-tb-15">ERROR B<span class="counter"> 104</span></h1>
      <h4 class="mg-t-30">Sorry, Broken Token Link. </h4>
      <a href="#" class="btn btn-lg btn-default">Support Team</a>
          ';
    }
  }
  else
  {
      //invalid token
      $tag = 0;
      $flag = '
      <h1 class="mg-tb-15">ERROR A<span class="counter"> 104</span></h1>
      <h4 class="mg-t-30">Sorry, Invalid Token Link. </h4>
      ';
  }

?>