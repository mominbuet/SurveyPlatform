<div class="row">
    <div class="col-lg-12">
        <h1 class="inner-page-heading"><?php echo __('Summary Repory'); ?></h1>
    </div>
</div>

<div class="custom-margin-all">
<div class="row">
    <div class="col-lg-12" style="padding-top:10px;">

        <?php
        echo '<div class="col-lg-12"><div class="col-lg-8">';
        echo "<div class='form-group col-lg-4'> <label>Survey Name</label>";
        echo $this->Form->input('survey_id', array('options' => $surveys, "name" => "survey_id", 'empty' => 'Select Survey',
        'label' => false,
        'class' => 'form-control'));
        echo '</div></div><div class="col-lg-8" >';
        echo "<div class='form-group col-lg-4'> <label>Survey Language</label>";
        echo $this->Form->input('language', array('options' => array("0"=>"English","1"=>"Bangla"), "name" => "language", 
        'label' => false,
        'class' => 'form-control'));
        
        echo '</div></div>';
        ?>
        <button class="btn btn-success pull-right " id="GenerateReport">Generate</button>
    </div>
</div>
</div><!-- /.custom-margin-all -->
<script type="text/javascript">
    $(document).ready(function () {
        $("#GenerateReport").on("click", function () {
            $.get(website + "SurveyAPI/generate_table/" + $("#survey_id option:selected").val(), function (data) {
                setTimeout(function () {
                    var win = window.open(website + "report_manager/reports/wizard/new/" + $("#survey_id option:selected").val() + "s", '_blank');
                    if (win)
                        win.focus();
                    else
                        window.location.href = website + "report_manager/reports/wizard/new/"
                    +$("#survey_id option:selected").val() + "s/"+$("#language option:selected").val();
                }, 1500);
            });
        });
    });
</script>