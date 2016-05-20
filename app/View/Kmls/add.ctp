<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            KML Upload        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Upload New KML File<div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $this->Form->create('Kml', array('class' => 'form-horizontal', 'type' => 'file', 'role' => 'form')); ?>


                            <?php
                            echo "<div class=\"form-group\"> <label>Menu Name</label>";
                            echo $this->Form->input('name', array('label' => false, 'class' => 'form-control', 'type' => 'text'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>Link</label>";
                            echo $this->Form->input('link', array('label' => false, 'class' => 'form-control', 'type' => 'text'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>Parent Name</label>";
                            echo $this->Form->input('parent_id', array('label' => false,'options'=>$kmls, 'class' => 'form-control','empty' => 'Select Parent'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>File(not necessary)</label>";
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
                            <input type="submit" class="fa fa-plus btn btn-success" value="Upload"/> </form>                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
