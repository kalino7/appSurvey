<script>
$(document).ready(function(){
    $("#add").click(function(){
    var nums = $(".questForms").length;

    if(nums > 0)
      {
        var nextid = nums + 1;
                    
        $(".quests").append(`
          
          <div class="questForms" id="div_${nextid}">
          <div class="sid_${nextid} col-lg-12 col-md-12 col-sm-12 col-xs-12"><span id="surveyColor" class="numQuests"> Question: ${nextid}</span></div>    
              <div class="row mg-tb-15">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Question Type</label>
                      <div class="form-select-list">
                      <select class="form-control custom-select-value selectOptd" name="questionType[Q${nextid}]" id="selectOpt" >
                              <?php 
                                  selectOpts();
                              ?>
                          </select>
                  </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Required</label>
                      <div class="form-select-list">
                          <select class="form-control custom-select-value" name="optional[Q${nextid}]">
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                              </select>
                      </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-t-15">
                  <div class="row">
                      
                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mg-t-15">
                          <button type="button" class="upward btn btn-custon-rounded-four btn-primary"><i class="fa fa-angle-double-up adminpro-informatio" aria-hidden="true"></i> Move Up</button>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-t-15">
                          <button type="button" class="downward btn btn-custon-rounded-four btn-primary"><i class="fa fa-angle-double-down adminpro-informatio" aria-hidden="true"></i> Move Down</button>
                      </div>
                      <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 mg-t-15">
                          <button type="button" class="remo btn btn-custon-rounded-four btn-danger" id="del_${nextid}"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Question</button>
                      </div>

                  </div>
                  </div>
              </div>

              <div class="row mg-tb-15">
                  
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                      <label class="login2 pull-right pull-right-pro"> Question Text: </label>
                  </div>
                  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                      <input type="text" name="questionText[Q${nextid}]" required class="form-control" />

                      <div class="choice_cat">
                          <div class="choices row mg-tb-15">
                              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                  <label class="login2 pull-right pull-right-pro"> choice Text: </label>
                              </div>
                              <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                  <input type="text" name="choiceOpt[Q${nextid}][C1]" required class="form-control chx" />
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                  <button type="button" class="choiceRem btn btn-custon-rounded-four btn-danger"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Choice</button>
                              </div>
                          </div>

                          <div class="row btnchoice">
                              <div class="col-lg-3 col-md-6 col-sm-8 col-xs-6 login-horizental pull-left ">
                                  <button type="button" id="Q${nextid}" class="choiceAdd btn btn-custon-rounded-four btn-primary"><i class="fa fa-plus-circle adminpro-informatio" aria-hidden="true"></i> Add Choice</button>
                              </div>
                          </div>

                      </div>

                  </div>
              </div>

          </div>
          `);
      }
      else
      {
        $(".quests").append(`
        
        <div class="questForms" id="div_1">
        <div class="sid_1 col-lg-12 col-md-12 col-sm-12 col-xs-12"><span id="surveyColor" class="numQuests"> Question: 1</span></div>    
            <div class="row mg-tb-15">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label class="login2 pull-right pull-right-pro">Question Type</label>
                    <div class="form-select-list">
                    <select class="form-control custom-select-value selectOptd" name="questionType[Q1]" id="selectOpt" >
                            <?php 
                                selectOpts();
                            ?>
                        </select>
                </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label class="login2 pull-right pull-right-pro">Required</label>
                    <div class="form-select-list">
                        <select class="form-control custom-select-value" name="optional[Q1]">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mg-t-15">
                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mg-t-15">
                            <button type="button" class="upward btn btn-custon-rounded-four btn-primary"><i class="fa fa-angle-double-up adminpro-informatio" aria-hidden="true"></i> Move Up</button>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mg-t-15">
                            <button type="button" class="downward btn btn-custon-rounded-four btn-primary"><i class="fa fa-angle-double-down adminpro-informatio" aria-hidden="true"></i> Move Down</button>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 mg-t-15">
                            <button type="button" id="del_1" class="remo btn btn-custon-rounded-four btn-danger"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Question</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mg-tb-15">
                
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label class="login2 pull-right pull-right-pro"> Question Text: </label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                    <input type="text" name="questionText[Q1]" required class="form-control" />

                    <div class="choice_cat">
                        <div class="choices row mg-tb-15">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label class="login2 pull-right pull-right-pro"> choice Text: </label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                <input type="text" name="choiceOpt[Q1][C1]" required class="form-control chx" />
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <button type="button" class="choiceRem btn btn-custon-rounded-four btn-danger"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Choice</button>
                            </div>
                        </div>

                        <div class="row btnchoice">
                            <div class="col-lg-3 col-md-6 col-sm-8 col-xs-6 login-horizental pull-left ">
                                <button type="button" id="Q1" class="choiceAdd btn btn-custon-rounded-four btn-primary"><i class="fa fa-plus-circle adminpro-informatio" aria-hidden="true"></i> Add Choice</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        `);
      }
});


$(".quests").on("click", ".upward", function(){

    var wraper = $(this).closest(".questForms");
    wraper.insertBefore(wraper.prev());
    $(".numQuests").each(function(i){
        ++i;
        $(this).text('Question: '+i);
    });
  });

  $(".quests").on("click", ".downward", function(){
    var wraper = $(this).closest(".questForms");
    wraper.insertAfter(wraper.next());
    $(".numQuests").each(function(i){
        ++i;
        $(this).text('Question: '+i);
    });
  });


  $(".quests").on("click", ".remo", function(){

    var id = $(this).attr('id');
    var splitId = id.split("_");
    var deleteIndex = Number(splitId[1]);

    $("#div_"+deleteIndex).remove();

    var numsRemains = $(".questForms").length;

    if(numsRemains > 0)
    {
      $(".questForms").each(function(i){
        ++i;
        $(this).attr('id', 'div_'+i);
      });

      $(".numQuests").each(function(i){
        ++i;
        $(this).text('Question: '+i);
      });

      $(".choiceAdd").each(function(i){
        ++i;
        $(this).attr('id', 'Q'+i);
      });

      $(".remo").each(function(i){
        ++i;
        $(this).attr('id', 'del_'+i);
      });

    }

  });

//   $("#selectOpt").change(function(){
//   var content = $("#selectOpt").val()
//   if((content == 'radio') || (content == 'checkbox'))
//   {
//     $(".choice_cat").show();
//   }
//   else{
//     $(".choice_cat").hide();
//   }
// });

$(".quests").on("change", "#selectOpt", function(){
    var cont = $(this).val();
    var wrap = $(this).closest(".questForms").find('.choice_cat');
    var props = $(this).closest(".questForms").find('.choice_cat :input');

    if((cont == <?php echo $arrayPrices[0]; ?>) || (cont == <?php echo $arrayPrices[1]; ?>))
    {
        wrap.show();
        props.prop("required", true);
    }
    else
    {
        wrap.hide();
        props.prop("required", null);
    }
});

$(".quests").on("click", ".choiceAdd", function(){
    var questChoice = $(this).attr("id");
    var placed = $(this).closest(".choice_cat").find(".choices:last");
    var choiceNum = $(this).closest(".choice_cat").find(".choices").length;

    choiceNum = choiceNum + 1;
    
    if(placed.length > 0)
    {
        var wrap = `
            <div class="choices row mg-tb-15">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label class="login2 pull-right pull-right-pro"> choice Text: </label>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                    <input type="text" name="choiceOpt[${questChoice}][C${choiceNum}]" required class="form-control chx" />
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <button type="button" id="choice_1" class="choiceRem btn btn-custon-rounded-four btn-danger"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Choice</button>
                </div>
            </div>
        `;
        $(wrap).insertAfter(placed);
    }
    else
    {
        var firstPlace = $(this).closest(".choice_cat").find(".btnchoice");
        var wrap = `
            <div class="choices row mg-tb-15">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label class="login2 pull-right pull-right-pro"> choice Text: </label>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                    <input type="text" name="choiceOpt[${questChoice}][C${choiceNum}]" required class="form-control chx" />
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <button type="button" id="choice_1" class="choiceRem btn btn-custon-rounded-four btn-danger"><i class="fa fa-trash adminpro-informatio" aria-hidden="true"></i> Delete Choice</button>
                </div>
            </div>
        `;
        $(wrap).insertBefore(firstPlace);
    }

});

$(".quests").on("click", ".choiceRem", function(){

    var choiceId = $(this).closest(".choice_cat").find(".choiceAdd").attr('id');
    var vessel = $(this).closest(".choices");
    vessel.remove();

    var getChoice = $("#"+choiceId+"").closest(".choice_cat").find(".chx");

    if(getChoice.length > 0)
    {
        getChoice.each(function(i){
            ++i;
            $(this).attr('name', `choiceOpt[${choiceId}][C${i}]`);
        });
    }

});




});

</script>
