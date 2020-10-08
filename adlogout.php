<?php
  @ob_start();
  session_start();

  unset($_SESSION['Auser']);
  unset($_SESSION['Aid']);

  session_destroy();

  header('location: adlogin.php');
?>
      <script>
          setTimeout(() => {
            window.location.href = "adlogin.php";
          }, 0000);  
      </script>