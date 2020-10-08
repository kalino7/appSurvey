<?php

    //check if username or email or telephone has been taken
    function unqiueVals($dbfield, $data)
    {
        global $db;

        $query = $db->query(" SELECT * FROM users WHERE $dbfield = '$data' ");
        if($query->num_rows > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function trimdata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function calculateage($BirthDate)
    {
      
      list($Year, $Month, $Day) = explode("-", $BirthDate);
      
      $YearDiff = date("Y") - $Year;
      
      if(date("m") < $Month || (date("m") == $Month && date("d") < $Day))
      {
          $YearDiff--;
      }
      return $YearDiff;
    }

    function getUserID($email)
    {
        global $db;

        $query = $db->query("SELECT id FROM users WHERE email = '$email'");
        $data = $query->fetch_assoc();
        return $data['id'];
    }

    function DeleteEmail($email)
    {
        global $db;

        $query = $db->query("DELETE FROM users WHERE email = '$email'");
        
        if($query){
            return true;
        }

        return false;
    }

?>