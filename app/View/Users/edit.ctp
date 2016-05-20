<div class="row">
    <div class="col-lg-12">
        <h1 class="inner-page-heading"><?php echo __('Users'); ?></h1>
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Users        </h1>
    </div>
</div> -->
<div class="custom-margin-all">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                edit Users                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $this->Form->create('User', array('class' => 'form-horizontal', 'role' => 'form')); ?>


                            <?php
                            echo "<div class=\"form-group\"> ";
                            echo $this->Form->input('id', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>User Name</label>";
                            echo $this->Form->input('user_name', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>password</label>";
                            echo $this->Form->input('password', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>first_name</label>";
                            echo $this->Form->input('first_name', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';
                            echo "<div class=\"form-group\"> <label>last_name</label>";
                            echo $this->Form->input('last_name', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';
/*                            echo "<div class=\"form-group\"> <label>msisdn</label>";
                            echo $this->Form->input('msisdn', array('label' => false, 'class' => 'form-control'));
                            echo '</div>';*/
                            echo "<div class=\"form-group\"> <label>Device name</label>";
                            echo $this->Form->input('device_id', array('label' => false,'empty'=>'<--Unassigned-->', 'class' => 'form-control'));
                            echo '</div>';
                            echo "<div class=\"form-group form-inline\"> <label>Active</label>";
                            echo $this->Form->input('is_active', array('type'=>'checkbox','label' => false, 'class' => 'form-control'));
                            echo '</div>';
                            ?>
                            <?php if ($this->Session->read('Auth.User.User.superuser') == '1'):
                             echo "<div class=\"form-group\"> <label>Parent id</label>&nbsp;&nbsp;&nbsp;";
                                echo $this->Form->input('parent_id', array('options' => array($parent_ids) , 'empty' => '<--Unassigned-->','label' => false, 'class' => 'form-control'));
                                echo '</div>';
                                echo "<div class=\"form-group form-inline\"> <label>SuperUser</label>&nbsp;&nbsp;&nbsp;";
                                echo $this->Form->input('superuser', array('type' => 'checkbox', 'label' => false, 'class' => 'form-control'));
                                echo '</div>';
                            endif; ?>
                            <input type="submit" class="fa fa-plus btn btn-success" value="Edit"/> 
							<input type="button" style="margin-left:3%;" class="fa btn btn-success" value="Cancel" onclick="javascript:history.back();" />
							</form>                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
</div><!-- /.custom-margin-all -->