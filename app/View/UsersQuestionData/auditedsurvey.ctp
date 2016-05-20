<div class="row">
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
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $this->Form->create(null, array('url' => array('controller' => 'UsersQuestionData', 'action' => 'auditedsurvey'),
            "type" => "get", 'class' => 'form-horizontal', 'role' => 'form'));
            echo '<div class="col-lg-12"><div class="col-lg-8 col-md-8">';
            echo "<div class='form-group col-lg-4 col-md-6'> <label>Survey</label>";
            echo $this->Form->input('survey_id', array( 'options' => $surveys,'default'=>$set_survey,
            'label' => false, 'class' => 'form-control'));
            echo '</div>';
            echo "<div class='form-group col-lg-4 col-md-4 pull-right'> <label>Users</label>";
            echo $this->Form->input('user_id', array('label' => false, 'class' => 'form-control', 'empty' => 'All','default'=>$set_user,
            'options' => $users));
            echo '</div>';
            echo '</div>';
            ?>
            <div class="col-lg-12">
                <input id="genBarChart" type="submit" class="fa fa-plus btn btn-success pull-right"  value="Submit"/> 
            </div></form>
        </div>
    </div>
</div>
<div class="row" style="margin-left:20px;">
    <div class="panel panel-default col-lg-8">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
            <thead><tr><th>#</th><th>Survey Name</th><th>Field User Name</th><th>Survey Completed</th><th>Survey Audited</th><th>Audited By</th><td> 
                        <button type="button" class="btn" data-toggle="collapse" data-target=".collapseme" id="togglebtn">
                            Toggle</button></td></tr></thead>
            <tbody>
<? $i=1; ?>
                <?php foreach ($results as $result): ?>
                <tr class="collapseme collapse in clickable" userid=<?php echo '"'.$result['User']['id'].'"'; ?> surveyid=<?php echo '"'.$set_survey.'"'; ?>>
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
</div>
<div class="row col-lg-12" id="example2" style="padding-left: 40px;padding-top: 5px;">
    <table class="table table-striped table-bordered table-hover" >
        <thead><tr><th>#</th><th> Survey name saved by user</th><th>Upload Date</th><th>Audited By</th><th>Audited</th><th>Audit Date</th><th>Match (%)</th><th>Comment</th><th>Action</th></tr></thead>
        <tbody id="tbody2">

        </tbody>
    </table>
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

<script type="text/javascript">
    $(document).ready(function () {
        $("#example2").hide();
        $(".clickable").on('click', function () {
            var currtr= $(this);
            $(".clickable").each(function(){
                $(this).css('background-color','');
            });
            currtr.css('background-color','#5CB85C');
            $.getJSON(website + "UIAPI/get_audited_entries/" + $(this).attr("userid") + "/" + $(this).attr("surveyid"), function (data) {
//                document.getElementById('togglebtn').click();
                $("#tbody2").html("");
                for (var i = 0; i < data.length; i++) {
                    var obj = data[i];
                    console.log(obj);
                    $("#tbody2").append("<tr><td>"+(i+1)+"</td><td>" + obj[0].name + "</td><td>" + obj[0].time + "</td><td>" +obj.Users.uname+ "</td><td>" + obj.UserQuestionData.is_audit_done + "</td><td></td><td>" +
                            ((obj.UserQuestionData.is_audit_done == "Y") ? "" : "-") + "<td></td><td>" +
                            ((obj.UserQuestionData.is_audit_done == "Y") ?
                                    "<button class='comparative btn btn-info' flg='" + obj.UserQuestionData.id + "' data-toggle='modal' data-target='#myModal'>Comparison</button>" : "") + "</td>" + "</tr>");
                }
                $("#example2").show();
                $(".comparative").on('click', function () {
                    var res = $(this).attr('flg');

                    
                    $.get(website + "UIAPI/get_comparative_answers/" + res, function (data) {
                        data = JSON.parse(data);
                        var text = ("<table class='table  table-striped table-bordered'><thead><tr><th>Question></th><th>Field user ans</th><th>Supervisor ans</th></tr></thead><tbody>")
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
                                if (data.audited[i]===undefined) {
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
//            alert("here" +$(this).attr("userid")+$(this).attr("surveyid"));
        });

    });
</script>