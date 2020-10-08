<?php

  if(isset($_SESSION['Auser']))
  {
    if((time() - $_SESSION['Aactivity']) > 1800 )
    {
      //inactive for more than 30mins
      header('location: adlogout.php');
      ?>
        <script>
          setTimeout(() => {
            window.location.href="adlogout.php";
          }, 0000);
        </script>
      <?php
    }
    else
    {
      $_SESSION['Aactivity'] = time();
    }
  }

  $curpage = basename($_SERVER['SCRIPT_NAME'], '.php');
  
  if( isset($_SESSION['Auser']) && !empty($_SESSION['Auser']) && ($curpage == 'adlogin' && $curpage == 'recovery') )
  {
    header('location: adboard.php');
    ?>
      <script>
        setTimeout(() => {
          window.location.href="adboard.php";
        }, 0000);
      </script>
    <?php
  }
  elseif((!isset($_SESSION['Auser']) || empty($_SESSION['Auser'])) && ($curpage != 'adlogin' && $curpage != 'recovery'))
  {
    header('location: adlogin.php');
    ?>
    <script>
      setTimeout(() => {
        window.location.href="adlogin.php";
      }, 0000);
    </script>
  <?php
  }

?>