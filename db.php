<?php 
    @ob_start();
    session_start();

    date_default_timezone_set("Africa/Lagos");
    
    $server = "localhost";
    $host = "root";
    $dbname = "appSurvey";
    $dbpass = "";

    $db = new mysqli($server, $host, $dbpass, $dbname);

    if($db->connect_error)
    {
        die("connection failed: ". $db->connect_error);
    }

    $theme = "AppSurvey";

?>