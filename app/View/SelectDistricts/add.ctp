<div class="row">
    <div class="col-lg-12">
        <h1 class="inner-page-heading"><?php echo __('Select Districts'); ?></h1>
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Select Districts        </h1>
    </div>
</div> -->
<div class="custom-margin-all">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                add Select Districts                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $this->Form->create('SelectDistrict', array('class' => 'form-horizontal', 'role' => 'form')); ?>


                            <?php
                            echo "<div class=\"form-group\"> <label>district_name</label>";
                            echo $this->Form->input('district_name', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>division_id</label>";
                            echo $this->Form->input('division_id', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>district_code</label>";
                            echo $this->Form->input('district_code', array('label' => false,'type'=>'text', 'class' => 'form-control'));
                            echo '</div>';
                            ?>
                            <input type="submit" class="fa fa-plus btn btn-success" value="Add/Edit"/> </form>                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
</div><!-- /.custom-margin-all -->