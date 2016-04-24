<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo __('Select Divisions'); ?></h1>
         <?php echo $this->Html->link(__("Add Select Divisions"), array("action" => "add"),array("class"=>"btn btn-info pull-right")); ?>    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                 <?php echo __('All Select Divisions'); ?>                <div class="panel-body">
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                                                            <th><?php echo $this->Paginator->sort('division_id'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('division_name'); ?></th>
                                                                            <th><?php echo $this->Paginator->sort('division_code'); ?></th>
                                                                        <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($selectDivisions as $selectDivision): ?>
	<tr>
		<td><?php echo h($selectDivision['SelectDivision']['division_id']); ?>&nbsp;</td>
		<td><?php echo h($selectDivision['SelectDivision']['division_name']); ?>&nbsp;</td>
		<td><?php echo h($selectDivision['SelectDivision']['division_code']); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Html->link(__('View'), array('action' => 'view', $selectDivision['SelectDivision']['division_id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $selectDivision['SelectDivision']['division_id']),array('class'=>'btn btn-warning')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $selectDivision['SelectDivision']['division_id']), array('class'=>'btn btn-warning'), __('Are you sure you want to delete # %s?', $selectDivision['SelectDivision']['division_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
                            </tbody>
                        </table>
                        <p>
                            <?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>                        </p>
                        <div class="paging">
                            <?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

