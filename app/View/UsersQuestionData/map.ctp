<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-4 col-md-4">
            <label>Select Survey </label>
            <?php
            echo $this->Form->input('survey_id', array('default' => $set_survey,
            'options' => $questionSets, "name" => "survey_id",
            'empty' => 'Select Survey',
            'label' => false,
            'class' => 'form-control'));
            ?>
        </div>
        <div class="col-lg-4  col-md-4 pull-right">
            <label>Select User </label>
            <?php
            echo $this->Form->input('user_id', array('default' => $set_user,
            "name" => "user_id",
            'empty' => 'Select User',
            'label' => false,
            'class' => 'form-control'));
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-4 col-md-4">
            <label>Select Question </label>
            <?php
            echo $this->Form->input('question_id', array('default' => $set_question,
            "name" => "question_id",
            'empty' => 'Select Question',
            'label' => false,
            'class' => 'form-control'));
            ?>
        </div>
        <div class="col-lg-4  col-md-4 pull-right" style="display:none;">
            <label>Select Answer </label>
            <?php
            echo $this->Form->input('answer_id', array('default' => $set_answer,
            "name" => "answer_id",
            'empty' => 'Select Answer',
            'label' => false,
            'class' => 'form-control'));
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-right"><button id="btnSubmit" class="btn btn-primary">Submit</button></div>
    </div>  
</div>

<?php // debug($usersQuestionData); ?>
<div id="legend">
</div>
<div class="col-lg-12">
    <div id="map-canvas" style="width: 100%;height:800px;margin: 0px;padding: 10px;margin-bottom:2% /* position: absolute */ ">
        
    </div>
<style>
  #legend {
        font-family: Arial, sans-serif;
        background: #fff;
        padding: 10px;
        margin: 10px;
        border: 1px solid #000;
  }
</style>

<script>

    var inputs = <?php echo json_encode($usersQuestionData); ?> ;
            $(document).ready(function () {
        function getUsers(user) {

            if ($("#survey_id").val() != 0) {
                $.get(website + "UIAPI/get_users_for_survey/" +
                        $("#survey_id  option:selected").val(), function (data) {
                    $('#user_id').html(data);
                    if (user !== 0) {
                        $('#user_id option[value="' + user + '"]').attr('selected', "selected");
                    }
                });
            }

        }
        function getQuestions(user) {

            if ($("#survey_id").val() != 0) {
                $.get(website + "UIAPI/getQuestionsOnlyMultiple/" +
                        $("#survey_id  option:selected").val(), function (data) {
                    $('#question_id').html(data);
                    if (user !== 0) {
                        $('#question_id option[value="' + user + '"]').attr('selected', "selected");
                    }
                });
            }
        }
//        $("#question_id").change(function () {
//            $.get(website + "UIAPI/getAnswersOnlyMultiple/" +
//                    $("#question_id  option:selected").val(), function (data) {
//                $('#answer_id').html(data);
//            });
//        });
        $("#survey_id").change(function () {
            getUsers();
            getQuestions();
        });
        $("#btnSubmit").on("click", function () {
            if ($("#survey_id  option:selected").val() != 0) {
//                if ($("#user_id  option:selected").val() == 0)
                    window.location.replace(website + "UsersQuestionData/map?survey_id=" + $("#survey_id  option:selected").val()+"&user_id="+
                            $("#user_id  option:selected").val()+"&question_id="+
                        + $("#question_id  option:selected").val()+"&answer_id="+ ($("#answer_id  option:selected").val()));
//                else
//                    window.location.replace(website + "UsersQuestionData/map/" + $("#survey_id  option:selected").val() +
//                            "/" + $("#user_id  option:selected").val());
            } else
                alert("Please select a Survey first.");
        });
        if ($("#survey_id").val() != 0) {
                $.get(website + "UIAPI/getQuestionsOnlyMultiple/" +
                        $("#survey_id").val(), function (data) {
                    $('#question_id').html(data);
                    var question = <?php echo $set_question;?>;
                    if (question !== 0) {
                        $('#question_id option[value="' + question + '"]').attr('selected', "selected");
                        $.get(website + "UIAPI/getAnswersOnlyMultiple/" + question, function (data) {
                            $('#answer_id').html(data);
                            var answer = <?php echo $set_answer;?>;
                            if (answer !== 0) {
                                $('#answer_id option[value="' + answer + '"]').attr('selected', "selected");
                            }
                        });
                    }
            });
        }
         
    });
    var colorMap = new Object();
    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    function initialize() {
//        console.log(inputs);
//        var locations = [
//            ['Bondi Beach', -33.890542, 151.274856, 4],
//            ['Coogee Beach', -33.923036, 151.259052, 5],
//            ['Cronulla Beach', -34.028249, 151.157507, 3],
//            ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
//            ['Maroubra Beach', -33.950198, 151.259302, 1]
//        ];
        var mapOptions = {
            zoom: 8,
            zoomControl: true,
            zoomControlOptions: {position: google.maps.ControlPosition.RIGHT_TOP},
            center: new google.maps.LatLng(24.4362706, 89.7367567),
            scaleControl: true,
            mapTypeControl: true,
            mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
              mapTypeIds: [
                google.maps.MapTypeId.ROADMAP,
                google.maps.MapTypeId.TERRAIN,
                google.maps.MapTypeId.HYBRID,
                google.maps.MapTypeId.SATELLITE 
              ]
            }
//            center: new google.maps.LatLng(23.7806365, 90.4193257)
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);
        
//        for (i = 0; i < locations.length; i++) {
//            marker = new google.maps.Marker({
//                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
//                map: map
//            });
//
//            google.maps.event.addListener(marker, 'click', (function(marker, i) {
//                return function() {
//                    infowindow.setContent(locations[i][0]);
//                    infowindow.open(map, marker);
//                }
//            })(marker, i));
//        }
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        var markers = [];
        var legend = document.getElementById('legend');

        for (i = 0; i < inputs.data.length; i++) {
            if(inputs.data[i].hasOwnProperty('QuestionAnswer'))
                if(inputs.data[i].QuestionAnswer.hasOwnProperty('QuestionAnswers'))
//                    if(inputs.data[i].QuestionAnswer.QuestionAnswers.hasOwnProperty('qsn_answer'))

                    {
//                        console.log(inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer);
                        if(!(inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer in colorMap)){
                            colorMap[inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer]=getRandomColor();
                             var name = inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer;
                            var color = colorMap[inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer];
                            var div = document.createElement('div');
                            div.innerHTML = '<span style="background-color:' + color+ ';"> &nbsp;&nbsp;&nbsp;';
                            div.innerHTML += '</span> <span> '+name+'</span> ';
                            legend.appendChild(div);
//                            console.log(colorMap[inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer]);
                        }
                }
        }
        var div = document.createElement('div');
                            div.innerHTML = '<span style="background-color:red;"> &nbsp;&nbsp;&nbsp;';
                            div.innerHTML += '</span> <span> অনির্দিষ্ট</span> ';
                            legend.appendChild(div);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('legend'));
//        colorMap.forEach(function(value, key) {
//            console.log(key + " = " + value);
//          }, colorMap)
        for (i = 0; i < inputs.data.length; i++) {
            
//                    console.log(inputs.data[i].hasOwnProperty('QuestionAnswer')?(inputs.data[i].QuestionAnswer.hasOwnProperty('QuestionAnswers'))
//                    ?colorMap[inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer]:"red"
//                            :"red");
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(inputs.data[i].UsersQuestionData.geo_lat, inputs.data[i].UsersQuestionData.geo_lon),
                animation: google.maps.Animation.DROP,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 10,
                    fillColor: (inputs.data[i].hasOwnProperty('QuestionAnswer'))?(inputs.data[i].QuestionAnswer.hasOwnProperty('QuestionAnswers'))
                    ?colorMap[inputs.data[i].QuestionAnswer.QuestionAnswers.qsn_answer]:"red"
                            :"red",
                    fillOpacity: 0.7,
                    strokeColor: 'black',
                    strokeWeight: .5
                },
                title: inputs.data[i].QuestionSet.qsn_set_name + ""
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    var contentString = "<h5>" + inputs.data[i].QuestionSet.qsn_set_name + "</h5>" +
                            "<table class='table table-responsive'>" +
                            "<tr><td>User:</td><td> " + inputs.data[i].User.user_name + "</td><tr>" +
                            "<tr><td>Time:</td><td> " + inputs.data[i].UsersQuestionData.insert_time + "</td><tr>";
                    $.getJSON(website + "SurveyAPI/get_answers/" + inputs.data[i].UsersQuestionData.id,
                            function (data) {
                                $.each(data, function (key, val) {
//                                    console.log(key);
//                                    console.log(val);
//                                    items.push("<p>" + val +" : "+ "</p>");
                                    contentString += "<tr><td>" + val.Question.qsn_desc + ":</td><td> " +
                                            ((val.QuestionAnswer.qsn_answer.lastIndexOf("image/") > -1) ?
                                                    '<img width="100" src="/CUB/SurveyAPI/get_image_answer_id/' + val.QuestionAnswer.qsn_answer + '"/>'
                                                    : val.QuestionAnswer.qsn_answer)
                                            + "</td></tr>";

                                });
                                infowindow.setContent(contentString);
                                infowindow.open(map, marker);
                            });



//                    if (marker.getAnimation() != null) {
//                        marker.setAnimation(null);
//                    } else {
//                        marker.setAnimation(google.maps.Animation.BOUNCE);
//                    }
                }
            })(marker, i));
//            markers.push(marker);
        }
//        var mcOptions = {gridSize: 50, maxZoom: 15};
//        var markerCluster = new MarkerClusterer(map, markers, mcOptions);
    }

    function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp' +
                '&signed_in=true&callback=initialize';
        document.body.appendChild(script);
    }

    window.onload = loadScript;

</script>
<?php echo $this->Html->script('marker_clusterer'); ?>

