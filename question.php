<?php

function getQuestions($surveyID)
  {
    global $db;
    $step = 1;
    $getQuest = $db->query("SELECT * FROM questions WHERE surveyID = '$surveyID' ");
    $getCount = $getQuest->num_rows;
    $getCount += 2;
    while($data = $getQuest->fetch_assoc())
    {
        if($step == 1)
        {
?>
      <fieldset>
        <div class="form-card">
          <div class="row">
            <div class="col-7">
              <h2 class="fs-title">Question: <?php echo $step;?></h2>
            </div>
            <div class="col-5">
                <h2 class="steps">Step <?php echo $step;?> out of <?php echo $getCount; ?> </h2>
            </div>
          </div>

          <label class="fieldlabels question_text" data-question-id = "<?php echo $data['id']; ?>"
          data-question-type = "<?php echo $data['quesType']; ?>" data-is-required = "<?php echo $data['isRequired']; ?>">
          <?php echo $data['quesText']?>: *</label>

        <?php
            if(($data['quesType'] == 'checkbox') || ($data['quesType'] == 'radio') )
            {
                $choiceStep = 1;
                $getChoices = $db->query("SELECT * FROM choice WHERE questID = '$data[id]' ");
                while($getData = $getChoices->fetch_assoc())
                {
        ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="i-checks pull-left">
                            <label class ="" >
                                <input type="<?php echo $data['quesType']; ?>" 
                                value="<?php echo $getData['choiceText'];?>" name="choices[<?php echo $data['id']; ?>][]"  /> <i></i> <?php echo $getData['choiceText']; ?> 
                            </label>
                            </div>
                        </div>
                    </div>
        <?php
                $choiceStep += 1;
                }
        ?>
            
        <?php
            }
            elseif(($data['quesType'] == 'textarea'))
            {
        ?>
                <textarea name="choices[<?php echo $data['id']; ?>]" rows="5" cols="50"></textarea>
        <?php
            }
            else
            {
        ?>
                <input type="text" name="choices[<?php echo $data['id']; ?>]" />
        <?php
            }
        ?> 
        </div>
        <input type="button" name="next" class="next action-button" value="Next" />
      </fieldset>

<?php
        }
        elseif($step != 1)
        {
?>
      <fieldset>
        <div class="form-card">
          <div class="row">
            <div class="col-7">
              <h2 class="fs-title">Question: <?php echo $step;?></h2>
            </div>
            <div class="col-5">
                <h2 class="steps">Step <?php echo $step;?> out of <?php echo $getCount; ?> </h2>
            </div>
          </div>

          <label class="fieldlabels question_text" data-question-id = "<?php echo $data['id']; ?>"
          data-question-type = "<?php echo $data['quesType']; ?>" data-is-required = "<?php echo $data['isRequired']; ?>">
          <?php echo $data['quesText']?>: *</label>

        <?php
            if(($data['quesType'] == 'checkbox') || ($data['quesType'] == 'radio') )
            {
                $choiceStep = 1;
                $getChoices = $db->query("SELECT * FROM choice WHERE questID = '$data[id]' ");
                while($getData = $getChoices->fetch_assoc())
                {
?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="i-checks pull-left">
                            <label class="<?php echo $required; ?>">
                                <input type="<?php echo $data['quesType']; ?>" value="<?php echo $getData['choiceText'];?>" 
                                name="choices[<?php echo $data['id']; ?>][]"> <i></i> <?php echo $getData['choiceText']; ?> </label>
                            </div>
                        </div>
                    </div>
<?php
                $choiceStep += 1;
                }
        ?>
            
        <?php
            }
            elseif(($data['quesType'] == 'textarea'))
            {
        ?>
                <textarea name="choices[<?php echo $data['id']; ?>]" rows="5" cols="50"></textarea>
        <?php
            }
            else
            {
        ?>
                <input type="text" name="choices[<?php echo $data['id']; ?>]" />
        <?php
            }
        ?> 
        </div>
        <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
      </fieldset>

<?php
        }

         $step+=1;
    }


    //select special questions
    $questionSpecial = $db->query("SELECT detectorID FROM detector WHERE surveyID ='$surveyID' ");
    while($getSpecial = $questionSpecial->fetch_assoc())
    {
        $questSpId = $getSpecial['detectorID'];
        $newQuest = $db->query("SELECT * FROM detectorqxt WHERE id = '$questSpId' ");
        while($dataNew = $newQuest->fetch_assoc())
        {

?>

<fieldset>
        <div class="form-card">
          <div class="row">
            <div class="col-7">
              <h2 class="fs-title">Question: <?php echo $step;?></h2>
            </div>
            <div class="col-5">
                <h2 class="steps">Step <?php echo $step;?> out of <?php echo $getCount; ?> </h2>
            </div>
          </div>

          <label class="fieldlabels question_text" data-question-id = "<?php echo "x".$dataNew['id']; ?>"
          data-question-type = "<?php echo $dataNew['fieldType']; ?>" data-is-required = "Yes">
          <?php echo $dataNew['quesText']?>: *</label>

        <?php
                $choiceStep = 1;
                $getChoices = $db->query("SELECT * FROM detectoropt WHERE detectorID = '$questSpId' ");
                while($getData = $getChoices->fetch_assoc())
                {
?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="i-checks pull-left">
                            <label>
                                <input type="<?php echo $dataNew['fieldType']; ?>" value="<?php echo $getData['optValues']?>" 
                                name="spchoice[x<?php echo $dataNew['id']; ?>][]"> <i></i> <?php echo $getData['displayValues']; ?> 
                            </label>
                            </div>
                        </div>
                    </div>
<?php
                     $choiceStep += 1;
                }
        ?>
         
        </div>
        <?php
            if($step >= $getCount)
            {
        ?>
            <input type="submit" name="next" class="submit action-button" value="Submit" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
        <?php
            }
            else
            {
        ?>
            <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
        <?php
            }
        ?>
      </fieldset>

<?php
        $step+=1;
        }

    }

  }
?>