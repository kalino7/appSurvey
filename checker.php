<?php

  if(isset($_SESSION['user']))
  {
    if((time() - $_SESSION['activity']) > 1800 )
    {
      //inactive for more than 30mins
      header('location: logout.php');
      ?>
        <script>
          setTimeout(() => {
            window.location.href="logout.php";
          }, 0000);
        </script>
      <?php
    }
    else
    {
      $_SESSION['activity'] = time();
    }
  }

  $curpage = basename($_SERVER['SCRIPT_NAME'], '.php');
  
  if( isset($_SESSION['user']) && !empty($_SESSION['user']) && ($curpage == 'login' && $curpage == 'recovery') )
  {
    header('location: dashboard.php');
    ?>
      <script>
        setTimeout(() => {
          window.location.href="dasboard.php";
        }, 0000);
      </script>
    <?php
  }
  elseif((!isset($_SESSION['user']) || empty($_SESSION['user'])) && ($curpage != 'login' && $curpage != 'recovery'))
  {
    header('location: login.php');
    ?>
    <script>
      setTimeout(() => {
        window.location.href="login.php";
      }, 0000);
    </script>
  <?php
  }

?>