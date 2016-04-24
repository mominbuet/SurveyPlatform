<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Users Question Data        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                edit Users Question Data                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
<?php echo $this->Form->create('UsersQuestionData',array('class'=>'form-horizontal', 'role'=>'form')); ?>


	<?php
echo "<div class=\"form-group\"> <label>id</label>";		echo $this->Form->input('id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>user_id</label>";		echo $this->Form->input('user_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>group_visible_id</label>";		echo $this->Form->input('group_visible_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>qsn_set_master_id</label>";		echo $this->Form->input('qsn_set_master_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>geo_lat</label>";		echo $this->Form->input('geo_lat',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>geo_lon</label>";		echo $this->Form->input('geo_lon',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>division_id</label>";		echo $this->Form->input('division_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>district_id</label>";		echo $this->Form->input('district_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>thana_id</label>";		echo $this->Form->input('thana_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>union_id</label>";		echo $this->Form->input('union_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>insert_time</label>";		echo $this->Form->input('insert_time',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>insert_user_id</label>";		echo $this->Form->input('insert_user_id',array('label' => false,'class' => 'form-control'));
		echo '</div>';
echo "<div class=\"form-group\"> <label>user_form_id</label>";		echo $this->Form->input('user_form_id',array('label' => false,'class' => 'form-control'));
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
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>

        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UsersQuestionData.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('UsersQuestionData.id'))); ?></li>
        <li><?php echo $this->Html->link(__('List Users Question Data'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Question Sets'), array('controller' => 'question_sets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question Set'), array('controller' => 'question_sets', 'action' => 'add')); ?> </li>
    </ul>
</div>
