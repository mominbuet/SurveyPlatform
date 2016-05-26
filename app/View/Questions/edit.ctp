<div class="row">
    <h1>Edit question</h1>
    <div class="col-lg-12">
        <div class="">
            <div class="panel">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="questions form">
                                <?php echo $this->Form->create('Question', array('class' => 'form-horizontal', 'role' => 'form')); ?>
                                <?php
                                echo $this->Form->input('id', array('label' => false, 'type' => 'hidden',
                                'id' => 'qsn_desc', 'class' => 'form-control'));
                                ?>
                                <div class="form-group ">
                                    <label>Question Section</label>
                                    <div class="form-inline col-lg-12">

                                        <?php
                                        echo $this->Form->input('section_id', array('label' => false,
                                        'options' => $qsnSections, 'div' => false,
                                        'default' => $prev_section['prev_id'],
                                        'class' => 'form-control pull-left'));
                                        ?>
                                        <input class="form-control" 
                                               value="<?= $prev_section['name'] ?>"
                                               type="text" name="data[Question][section_name]"
                                               id="section_name" placeholder="Insert the name of this section otherwise it will be default"/>&nbsp;&nbsp;&nbsp;
  <input class="form-control" 
                                           value="<?= $prev_section['serial'] ?>"
                                           type="text" name="data[Question][section_serial]"
                                           id="section_serial" placeholder="Serial inside the section"/>
				     &nbsp;&nbsp;&nbsp;
                                    </div>

                                    <p class="help-block">Please select the Section of the Question.</p>
                                </div>
                                <div class="form-group ">
                                    <label>Question</label>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <?php
                                            echo $this->Form->input('qsn_desc', array('label' => false, 'class' => 'form-control','placeholder'=>'In English '));
                                            ?></div>
                                        <div class="col-lg-4">
                                            <?php
                                            echo $this->Form->input('qsn_desc_bangla',array('label' => false, 'lang'=>'bd', 'class' => 'form-control','placeholder'=>'In Bangla '));
                                            ?>
                                        </div>
                                    </div>
                                    <p class="help-block">Enter the question here...</p>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Question help text</label>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <?php
                                            echo $this->Form->input('qsn_help', array('label' => false,
                                            'class' => 'form-control','placeholder'=>'In English '));
                                            ?>
                                        </div>
                                        <div class="col-lg-4">
                                            <?php
                                            echo $this->Form->input('qsn_help_bangla', array('label' => false,
                                            'class' => 'form-control','placeholder'=>'In Bangla '));
                                            ?>
                                        </div>
                                        <p class="help-block">Enter the help here...</p>
                                    </div>
                                </div>
                                <div class="form-group form-inline">
                                    <label>Is required</label>
                                    <?php
                                    echo $this->Form->input('is_ans_required', array('type' => 'checkbox', 'label' => false, 'class' => 'form-control',
                                    'id' => 'is_ans_required'));
                                    ?>
                                    <p class="help-block">Is this field required?</p>
                                </div>
                                <div class="form-group">
                                    <label>Question type</label>
                                    <?php
                                    echo $this->Form->input('qsn_type_id', array('label' => false,
                                    'id' => 'qsn_type_id', 'class' => 'form-control'));
                                    ?>
                                    <p class="help-block">Enter the description here...</p>
                                </div>
                                <div class="form-group" id="extraDiv" >
                                    <label>Add selections</label>
                                    <div class="col-lg-12">
                                        <div  class="col-lg-8">Option Name</div>
                                        <div  class="col-lg-4">Skip to Section</div>
                                        <div  class="col-lg-2"></div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div  id="txtThings" class="col-lg-7">
                                        <div class="col-lg-3">
                                            <input type="text" placeholder="In English" class="form-control" name="data[SelectMisc][]" />
                                        </div><div class="col-lg-3">
                                            <input type="text" placeholder="In Bangla" class="form-control" name="data[SelectMiscBangla][]" />
                                        </div> 
                                    </div>
                                        
                                        <div  id="skipThings" class="col-lg-3">
                                            <?php
                                            echo $this->Form->input('next_section_id', array('label' => false,
                                            'name' => 'data[SelectMiscNext][]',
                                            'tag' => 'nextSkip',
                                            'options' => array_merge(array("0" => "<--No Skip-->"), $qsnSections),
                                            'class' => 'form-control'));
                                            ?>
                                        </div> 
                                        <div class="col-lg-1" id="btns">
                                            <button id="btnAddMore" class="fa fa-plus " style="width:100%;height: 35px;" ></button>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="help-block">Enter the options here...</p>
                                </div>
                                <div class="form-group" id="div_answer_length">
                                    <label>Answer length</label>
                                    <?php
                                    echo $this->Form->input('answer_length', array('label' => false,
                                    'id' => 'answer_length','placeholder'=>'default 200', 'class' => 'form-control'));
                                    ?>
                                    <p class="help-block">Enter the help here...</p>
                                </div>
                                <!--div class="form-group form-inline">
                                    <label>Required?</label>
                                    <?php echo $this->Form->input('is_ans_required', array('label' => false, 'id' => 'is_ans_required', 'class' => 'form-control')); ?>
                                    <p class="help-block">Is this field required(1 for yes)?</p>
                                </div-->
<!--                                <div class="form-group ">
                                    <label>Question Section</label>
                                    <div class="form-inline">

                                        <?php
                                        echo $this->Form->input('section_id', array('label' => false,
                                        'options' => $qsnSections, 'div' => false,
                                        'default' => $prev_section['prev_id'],
                                        'class' => 'form-control pull-left'));
                                        ?>
                                        <input class="form-control"
                                               value="<?= $prev_section['name'] ?>"
                                               type="text" name="data[Question][section_name]"
                                               id="section_name" placeholder="Insert the name of this section otherwise it will be default"/>

                                    </div>

                                    <p class="help-block">Please select the Section of the Question.</p>
                                </div>-->
                                <!--                                <div class="form-group">
                                                                    <label>Question Rule</label>
                                <?php // echo $this->Form->input('validity_rule_id', array('label' => false, 'empty' => true, 'id' => 'qsn_rules', 'class' => 'form-control')); ?>
                                                                    <p class="help-block">Enter the rule(optional) here...</p>
                                                                </div>-->

                                <div class="form-group form-inline col-lg-12" id="validblock">


                                    <select class="form-control pull-left" name="data[Question][validity_rule_id]" id="validpar">
                                        <option value="">Select Validation</option>
                                    </select>

                                    <!--<input type="text" class="form-control col-lg-1" placeholder="From" style="display:none;" name="data[Question][validation_text1]">-->
                                    <?php
                                    echo $this->Form->input('validation_text1', array('label' => false,
                                    'div' => false,
                                    'style'=>'display:none;',
                                    'class' => 'form-control col-lg-1'));
                                    ?>
                                    <?php
                                    echo $this->Form->input('validation_text2', array('label' => false,
                                    'div' => false,
                                    'style'=>'display:none;',
                                    'class' => 'form-control col-lg-1'));
                                    ?>
                                    <!--<input type="text" class="form-control col-lg-1" placeholder="To" style="display:none;" name="data[Question][validation_text2]">-->

                                    <!--<input type="text" class="form-control col-lg-2" placeholder="What" name="data[Question][validation_text]">-->
                                    <?php
                                    echo $this->Form->input('validation_text', array('label' => false,'placeholder'=>'Values',
                                    'div' => false,
                                    'class' => 'form-control col-lg-2'));
                                    ?>
                                    <?php
                                    echo $this->Form->input('validation_error_text', array('label' => false,'placeholder'=>'English Text for error ',
                                    'div' => false,
                                    'class' => 'form-control col-lg-4'));
                                    ?>
                                    <?php
                                    echo $this->Form->input('validation_error_text_bangla', array('label' => false,'placeholder'=>'Bangla Text for error',
                                    'div' => false,
                                    'class' => 'form-control col-lg-4'));
                                    ?>
                                    <!--<p class="help-block">Validate the field</p>-->
                                </div>
                                <!--    <div class="form-group">
                                        <label>Question Order</label>
                                <?php // echo $this->Form->input('qsu_order', array('label' => false, 'id' => 'qsu_order', 'class' => 'form-control')); ?>
                                        <p class="help-block">Enter any numeric code or the order of the question here</p>
                                    </div>-->
                                <input type="submit" class="fa fa-plus btn btn-success" value="Edit Question"/> 
                                <input type="button" style="margin-left:3%;" class="fa btn btn-success" value="Cancel" onclick="cancel_page_update_qsn();" />

                                </form>
                            </div></div></div></div></div></div></div></div>
<script type="text/javascript">
            function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
            }
    $(document).ready(function () {
    $.get(website + "UIAPI/getValidationEdit/" + <?php echo $setID; ?> + "/" + $('#qsn_type_id option:selected').val(), function (data) {
    $("#validpar").html(data);
            $("#validpar").val( <?php echo $validity_rule_id[0]['Question']['validity_rule_id']; ?> );
    });
            var elems = 0;
            var obj = <?php echo json_encode($data_array); ?> ;
            $('#QuestionSectionId').on('change', function () {
//            $('input[name="data[Question][section_name]"]').val('');
    });
            $('#validpar').on('change', function () {
    if ($("#validpar option:selected").text() == "Between") {
    $('input[name="data[Question][validation_text]"]').hide();
            $('input[name="data[Question][validation_text1]"]').show();
            $('input[name="data[Question][validation_text2]"]').show();
    } else {
    $('input[name="data[Question][validation_text]"]').show();
            $('input[name="data[Question][validation_text1]"]').hide();
            $('input[name="data[Question][validation_text2]"]').hide();
    }
    });
            if (obj[$('#qsn_type_id option:selected').val() + "id"] != "1")
            $('#extraDiv').hide();
            else {
            $('#extraDiv').show();
                    $.get(website + "UIAPI/get_options_for_question_edit/" + <?php echo $this->data['Question']['id'] ?> + "/" + <?php echo $setID; ?> , function (data) {
                    $.get(website + "UIAPI/get_options_skip_for_question_edit/" + <?php echo  $this->data['Question']['id'] ?> + "/" + <?php echo $setID; ?> , function (data2) {
                    $('#txtThings').html('');
//                    console.log(data);
                            //$('#skipThings').html('');
                            $.each(data, function (key, value) {
                            console.log(key+" "+value.SelectMisc);
                                    elems++;
                                    $('#txtThings').append('<input name="data[SelectMiscId][]" value="' + value.SelectMisc.misc_id + '" type="hidden"/>');
                                    $('#txtThings').append('<div class="col-lg-5"><input value="' + value.SelectMisc.misc_option + '" placeholder="In English"  type="text" class="pull-left form-control" id ="things' + elems + '" name="data[SelectMisc][]" /></div>');
                                    $('#txtThings').append('<div class="col-lg-5"><input value="'+value.SelectMisc.misc_option_bangla+'" type="text" class="form-control" placeholder="In Bangla" id ="thingsbd' + elems + '" name="data[SelectMiscBangla][]" /></div>');
                                    if (elems > 1)
                                    $('#skipThings').append($("#QuestionNextSectionId")[0].outerHTML);
                                    if (isNumeric(data2[key]))
                                    $($('select[tag^="nextSkip"]').get(elems - 1)).val(data2[key]);
                                    //console.log(data2[key]);
                                    $('#btns').append('<button  style="width:100%;height: 34px;" id="btnRemoveElem' + elems + '" class="fa fa-minus rmbelem" flag="' + elems + '"'
                                    + ' onclick="$(\'#things' + elems + '\').remove();$(this).remove();"></button>');
                            });
                    }, 'json');
                    }, 'json');
            }
    $('#btnAddMore').click(function (event) {
    event.preventDefault();
            var not_empty_fields = true;
            $('input[name="data[SelectMisc][]"]').each(function (index) {
    if (this.value == "") {
    alert("Please insert the options correctly");
            not_empty_fields = false;
            return false;
    }
    else {
    /*elems++;
     $('#txtThings').prepend('<input type="text" class="form-control" id ="things' + elems + '" name="data[SelectMisc][]" />');
     $('#btns').append('<button  style="height: 34px;" id="btnRemoveElem' + elems + '" class="fa fa-minus rmbelem" flag="' + elems + '"'
     + ' onclick="$(\'#things' + elems + '\').remove();$(this).remove();"></button>');*/
    }
    });
            if (not_empty_fields) {
    elems++;
            $('#txtThings').append('<input type="text" class="form-control" id ="things' + elems + '" name="data[SelectMisc][]" />');
            $('#txtThings').append('<input type="text" class="form-control" id ="things' + elems + '" name="data[SelectMiscBangla][]" />');
            $('#skipThings').append($("#QuestionNextSectionId")[0].outerHTML);
            $('#btns').append('<button  style="height: 34px;" id="btnRemoveElem' + elems + '" class="fa fa-minus rmbelem" flag="' + elems + '"'
            + ' onclick="$(\'#things' + elems + '\').remove();$(this).remove();"></button>');
    }
    //return false;

    });
//        $('#div_answer_length').hide();
            $('#qsn_type_id').on('change', function () {
    //alert($('#qsn_type_id option:selected').val());
    $.get(website + "UIAPI/getValidation1/" + $('#qsn_type_id option:selected').val(), function (data) {
    $("#validpar").html(data);
    });
            var val = $('#qsn_type_id').val() + "id";
            //console.log(val + "  " + obj[val]);
//            if ($('#qsn_type_id').val() == 1 || $('#qsn_type_id').val() == 13)
//                $('#div_answer_length').show();
//            else
//                $('#div_answer_length').hide();
            if (obj[ val] == "1") {
    $('#extraDiv').show();
//                    $('#extraDiv').slideDown("slow", function() {
//                        //alert('found');
//                    });
    }
    else
            $('#extraDiv').hide();
//                }
    });
    });
            function cancel_page_update_qsn(){

            var setID = '<?php echo $setID;?>';
                    setTimeout(function(){
                    window.location.href = '/CUB/Questions/index/' + setID;
                    }, 1000);
            }
</script>
