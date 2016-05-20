<div class="row">
    <div class="col-lg-12">
        <h1 class="inner-page-heading"><?php echo __('Edit Kml'); ?></h1>
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Edit Kml        </h1>
    </div>
</div> -->

<div class="custom-margin-all">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit KML files                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $this->Form->create('Kml', array('class' => 'form-horizontal', 'role' => 'form')); ?>

 <?php
                            echo "<div class=\"form-group\"> ";
                            echo $this->Form->input('id', array('label' => false, 'class' => 'form-control','type'=>'hidden'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>File Name</label>";
                            echo $this->Form->input('name', array('label' => false, 'class' => 'form-control', 'type' => 'text'));
                            echo '</div>';
                           
                            echo "<div class=\"form-group\"> <label>File</label>";
                            echo $this->Form->input('kml', array('label' => false, 'type' => 'file',));
                            echo '</div>';
                            ?>
<!--                            <div class="form-group"><label>Type</label>
                                <select class="form-control" name="data[AndroidApps][type]"><option value="">No type</option>
                                    <option value="apk">Android app</option>
                                    <option value="pdf">User manual</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>-->
                            <input type="submit" class="fa fa-plus btn btn-success" value="Edit"/> </form>                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
</div><!-- /.custom-margin-all -->