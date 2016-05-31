<?php //debug($results);?><div class="row">
    <div class="col-lg-12">
        <h1 class="inner-page-heading"><?php echo __('Audited Report'); ?></h1>
    </div>
</div>
<div class="custom-margin-all">
    <div class="row">
        <!-- <div class="col-lg-12">
            <h1 class="page-header">
                <?php //echo __('Audited Report'); ?></h1>
        </div> -->
        
            
            <?php
            echo $this->Form->create(null, array('url' => array('controller' => 'UsersQuestionData', 'action' => 'auditedsurvey'),
            "type" => "get", 'class' => 'form-horizontal', 'role' => 'form'));
                echo '<div class="col-lg-5">';
                    echo $this->Form->input('survey_id', array( 'options' => $surveys,'default'=>$set_survey,
                    'label' => 'Survey', 'class' => 'form-control'));
                echo '</div>';    
                echo "<div class='col-lg-5'>";
                echo $this->Form->input('user_id', array('label' => 'Users', 'class' => 'form-control', 'empty' => 'All','default'=>$set_user,
                'options' => $users));
                echo '</div>';
            ?>
            <div class="col-lg-2">
                <div class="button-margin text-center">
                    <input id="genBarChart" type="submit" class="btn btn-success"  value="Submit"/> 
                </div>
            </div>
        </form>
            
        
    </div>
    
    <div class="panel panel-default row-margin">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
            <thead><tr><th>#</th><th>Survey Name</th><th>Field User Name</th><th>Survey Completed</th><th>Survey Audited</th><th>Audited By</th><td> 
                        <button type="button" class="btn" data-toggle="collapse" data-target=".collapseme" id="togglebtn">
                            Toggle</button></td></tr></thead>
            <tbody>
                <? $i=1; ?>
                <?php foreach ($results as $result): ?>
                <tr class="collapseme collapse in clickable" userid=<?php echo '"'.$result['User']['id'].'"'; ?> surveyid=<?php echo '"'.$set_survey.'"'; ?>
                    >
                    <td><?php echo $i++;?></td>
                    <td><?php echo h($result['Qsets']['qsn_set_name']); ?>&nbsp;</td>
                    <td><?php echo h($result['User']['user_name']); ?>&nbsp;</td>
                    <td><?php echo h($result['0']['countsurvey']); ?>&nbsp;</td>
                    <td><?php echo h($result['0']['auditedsurvey']); ?>&nbsp;</td>
                    <td></td>
                    <td></td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    
    <div class="row" id="example2">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <tr>
                        <th>#</th>
                        <th> Survey name BY user</th>
                        <th>Upload Date</th>
                        <th>Audited</th>
                        <th>Audited By</th>
                        <th>Audit Date</th>
                        <th>Match (%)</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody2">

                </tbody>
            </table>    
        </div>
        
    </div>
</div><!-- /.custom-margin-all -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Comparative View</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>.control-label .text-info { display:inline-block; }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $("#example2").hide();
        $(".clickable").on('click', function () {
            var currtr = $(this);
            $(".clickable").each(function () {
                $(this).css('background-color', '');
            });
            currtr.css('background-color', '#5CB85C');
            var surveyID = $(this).attr("surveyid");
            var entryID= $(this).attr("entryID");
            $.getJSON(website + "UIAPI/get_audited_entries/" + $(this).attr("userid") + "/" +surveyID , function (data) {
                console.log(website + "UIAPI/get_audited_comment/" + entryID);
                $.getJSON(website + "UIAPI/get_audited_comment/" + entryID, function (data2) {
//                document.getElementById('togglebtn').click();
                    console.log(data);
                    console.log(data2);
                    $("#tbody2").html("");
                    /*for (var i = 0; i < data.length; i++) {
                     var obj = data[i];
                     console.log(obj);
                     $("#tbody2").append("<tr><td>"+(i+1)+"</td><td>" + obj[0].name + "</td><td>" + obj[0].time + "</td><td>" +obj.Users.uname+ "</td><td>" + obj.UserQuestionData.is_audit_done + "</td><td></td><td>" +
                     ((obj.UserQuestionData.is_audit_done == "Y") ? "" : "-") + "<td></td><td>" +
                     ((obj.UserQuestionData.is_audit_done == "Y") ?
                     "<button class='comparative btn btn-info' flg='" + obj.UserQuestionData.id + "' data-toggle='modal' data-target='#myModal'>Comparison</button>" : "") + "</td>" + "</tr>");
                     }*/

                    for (var i = 0; i < data.length; i++) {
                        var obj = data[i];

                        $("#tbody2").append("<tr><td>" + (i + 1) + "</td><td>" + obj.Child_Surveys.user_survey_name + "</td><td>" + obj.Child_Surveys.time + "</td><td>" + obj.Child_Surveys.is_audit_done + "</td><td>" + obj.Audit_Surveys.supervisor_uname + "</td><td>" + obj.Audit_Surveys.audit_time + "</td><td>" +
                                ((obj.Child_Surveys.is_audit_done == "Y") ? "" : "-") +
                                "<td><label for='name' class='control-label'><p class='text-info'>" + data2 + "</p></label>" +
                                "<a class='commentbox pull-right' flg='" + obj.Child_Surveys.user_survey_id + "'>Edit</a></td><td>" +
                                ((obj.Child_Surveys.is_audit_done == "Y") ?
                                        "<button class='comparative btn btn-info' flg='" + obj.Child_Surveys.user_survey_id+"/"+ obj.Audit_Surveys.su_survey_id + "' data-toggle='modal' data-target='#myModal'>Comparison</button>" : "") + "</td>" + "</tr>");
                        $('#edit').click(function () {
                            var text = $('.text-info').text();
                            var input = $('<input id="attribute" type="text" value="' + text + '" />')
                            $('.text-info').text('').append(input);
                            input.select();

                            input.blur(function () {
                                var text = $('#attribute').val();
                                $('#attribute').parent().text(text);
                                $('#attribute').remove();
                            });
                        });
                    }
                    $("#example2").show();
                    $(".comparative").on('click', function () {
                        var res = $(this).attr('flg');


                        $.get(website + "UIAPI/get_comparative_answers/" + res, function (data) {
                            data = JSON.parse(data);
                            var text = ("<table class='table  table-striped table-bordered'><thead><tr><th>Questions</th><th>Field user ans</th><th>Supervisor ans</th></tr></thead><tbody>")
//                $('.modal-body').append('<p><b>Image:</b><img src="' + website + "SurveyAPI/get_image_answer_id/" + data[0].UsersQuestionData.id + '" /></p>');
                            console.log(data.original.length);
                            for (i = 0; i < data.original.length; i++) {
//                    console.log(data[i]);
                                text += ('<tr><td> ' + data.original[i].Question.qsn_desc + '</td>');
                                if ((!data.original[i].QuestionAnswer.qsn_answer)) {
                                    text += ('<td>-</td>');
                                }
                                else {
                                    if (data.original[i].QuestionAnswer.qsn_answer.indexOf("image/") > -1)
                                        text += ('<td> ' +
                                                '<img width="200" src="/CUB/SurveyAPI/get_image_id/' +
                                                data.original[i].QuestionAnswer.id + '"/>' + '</td>');
                                    else
                                        text += ('<td> ' + data.original[i].QuestionAnswer.qsn_answer + '</td>');
                                }

                                if (data.audited.length > i) {
//                                console.log(data.audited[i][0].ansid);
//                            console.log(data.original[i]);
                                    if (data.audited[i] === undefined) {
                                        text += ('<td>-</td>');
                                    }
                                    else {
                                        if (data.audited[i][0].ans.indexOf("image/") > -1)
                                            text += ('<td> ' +
                                                    '<img width="200" src="http://dflbd.com/CUB/SurveyAPI/get_image_id/' +
                                                    data.audited[i][0].ansid + '"/>' + '</td>');
                                        else
                                            text += ('<td> ' + data.audited[i][0].ans + '</td>');
                                    }
                                    text += ("</tr>");
                                } else {
                                    text += ("<td></td></tr>");
                                }
                            }
                            $('.modal-body').html(text + "</tbody></table>");

                        });
                    });
                });
            });
//            alert("here" +$(this).attr("userid")+$(this).attr("surveyid"));
        });

    });
</script>