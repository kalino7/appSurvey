<?php
  @ob_start();
  session_start();

  unset($_SESSION['user']);
  unset($_SESSION['id']);
  unset($_SESSION['email']);
  session_destroy();
  header('location: login.php');
?>
      <script>
          setTimeout(() => {
            window.location.href = "login.php";
          }, 0000);  
      </script>