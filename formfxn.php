<?php

  function getSurId($surveyName, $userid, $refid){
    global $db;

    $query = $db->query("SELECT id FROM survey WHERE surveyName = '$surveyName' 
    AND userID = '$userid' AND referenceID = '$refid' ORDER BY id DESC LIMIT 1 ");

    $data = $query->fetch_assoc();
    return $data['id'];
  }

  function getQuestId($surveyID, $quesType, $value){
    global $db;

    $query = $db->query("SELECT id FROM questions WHERE surveyID = '$surveyID' 
    AND quesType = '$quesType' AND costs = '$value' ORDER BY id DESC LIMIT 1 ");

    $data = $query->fetch_assoc();
    return $data['id'];
  }

  $arrayPrices = [];
  $priceQuery = $db->query("SELECT * FROM pricing ");
  while($dataPrice = $priceQuery->fetch_assoc())
  {
    array_push($arrayPrices, $dataPrice['cashTag']);
  }

?>