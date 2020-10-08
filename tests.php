<?php

  include('db.php');
  // $db->autocommit(FALSE);
  // try{
  //   $updateR = $db->query("UPDATE account SET bal='100', total_earned='100', forms='1' 
  //   WHERE userID = '2' ");

  //   if(!$updateR)
  //   {
  //     throw new Error("Database Error Scripting");
  //   }

  //   $db->commit();

  // }catch(Exeception $e){
  //   echo $e->getMessage();
  // }

  // echo"Noting";

  // $updateR = $db->query("UPDATE selected SET status='expired' WHERE surveyID = '1' 
  // AND userID = '3' ");

  // $updateR = $db->query("UPDATE account SET bal=bal+'100', total_earned=total_earned+'100', forms=forms+'1' 
  // WHERE userID = '2' ");

  //   $db->commit();
  //  $db->autocommit(TRUE);
 
  // $getRespId = $db->query("SELECT id FROM response WHERE surveyID = '1' AND userID='4' ORDER BY id DESC LIMIT 1 ");
  // $getRespData = $getRespId->fetch_assoc();
  // echo $respID = $getRespData['id'];

  $arr =  array(
    [
      'id' => ['piechart1'],
      'labels' => ['red', 'black'], 
      'background' => ['#443094', '#123023'],
      'data' => [27, 20]
    ],
    [ 
      'id' => ['piechart2'],
      'labels' => ['yellow', 'purple'], 
      'background' => ['#443094', '#223023'],
      'data' => [27, 20]
      ]
  );

  $phone = '(0706) 354-5900';
  $x = explode('(', $phone);
  $phx = '';
  // foreach($x as $k=>$val)
  // {
  //   $b = explode(')', $val);
  //   foreach($b as $c=>$vals)
  //   {
  //     $t = explode('-', $vals);
  //     foreach($t as $it=>$ival)
  //     {
  //       $phx .= trim($ival);
  //     }
  //   }
  // }
$k = explode(')', $x[1]);
$l = explode('-', $k[1]);

$ptn = "/^0/";  // Regex
$rpltxt = "+234";  // Replacement string
$k[0] = preg_replace($ptn, $rpltxt, $k[0]);


$phx = $k[0].trim($l[0]).$l[1];
  echo $phx;
  // foreach($arr as $num)
  // {
  //     $num['labels'];
  // }
?>