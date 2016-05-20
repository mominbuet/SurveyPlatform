<div class="row">
    <div class="col-lg-12">
        <h1 class="inner-page-heading"><?php echo __('Districts'); ?></h1>
    </div>
</div>
<!-- <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo __('Districts'); ?></h1>
        <?php echo $this->Html->link(__("Add Districts"), array("action" => "add"), array("class" => "btn btn-info pull-right")); ?>    </div>
</div> -->
<div class="custom-margin-all">
<div class="row" style="padding-bottom: 20px">
    <?php
    echo $this->Form->create("SelectDistrict", array('class' => 'form-horizontal'));
    echo '<div class="col-lg-12">';
    echo "<div class=' col-lg-3'> <label>District Code </label>";
    echo $this->Form->input('district_code', array('label' => false, 'type' => 'text', 'class' => 'form-control'));
    echo '</div>';
    echo "<div class='col-lg-3 col-lg-offset-1' > <label>District Name</label>";
    echo $this->Form->input('district_name', array('label' => false, 'class' => 'form-control'));
    echo '</div>';

    echo "<div class='col-lg-3 col-lg-offset-1 form-inline' > <label>Active &nbsp;&nbsp;&nbsp;</label>";
    echo $this->Form->input('is_active', array('label' => false,'type'=>'checkbox', 'class' => ''));
    echo '</div>';
    echo '</div><div class="col-lg-12">';
    echo $this->Form->submit(__('Submit'), array('class' => "fa fa-plus btn btn-success pull-right"));
    echo '</div>';
    echo $this->Form->end();
    ?>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php //echo __('All Select Districts'); ?>                
                <div class="row">
                    <div class="col-lg-3">
                        <?php echo __('All Select Districts'); ?>      
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Html->link(__("Add Districts"), array("action" => "add"), array("class" => "btn btn-info pull-right")); ?>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <!--<th><?php // echo $this->Paginator->sort('district_id');        ?></th>-->
                                    <th><?php echo $this->Paginator->sort('district_name'); ?></th>
                                    <!-- th><?php echo $this->Paginator->sort('division_id'); ?></th -->
                                    <th><?php echo $this->Paginator->sort('district_code'); ?></th>
                                    <th><?php echo $this->Paginator->sort('is_active'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($selectDistricts as $selectDistrict): ?>
                                    <tr>
                                        <!--<td><?php // echo h($selectDistrict['SelectDistrict']['district_id']);        ?>&nbsp;</td>-->
                                        <td><?php echo h($selectDistrict['SelectDistrict']['district_name']); ?>&nbsp;</td>
                                        <!-- td>
                                            <?php echo $this->Html->link($selectDistrict['SelectDivision']['division_name'], array('controller' => 'select_divisions', 'action' => 'view', $selectDistrict['SelectDivision']['division_id'])); ?>
                                        </td -->
                                        <td><?php echo h($selectDistrict['SelectDistrict']['district_code']); ?>&nbsp;</td>
                                        <td><?php echo h($selectDistrict['SelectDistrict']['is_active']); ?>&nbsp;</td>
                                        <td class="actions">
                                            <?php //echo $this->Html->link(__('View'), array('action' => 'view', $selectDistrict['SelectDistrict']['district_id'])); ?>
                                            <?php
                                            echo $this->Html->link(__('Edit'), array('action' => 'edit',
                                                $selectDistrict['SelectDistrict']['district_id']), array('class' => 'btn btn-warning'));
                                            ?>
                                            <?php
                                            echo $this->Form->postLink(__('Delete'), array('action' => 'delete',
                                                $selectDistrict['SelectDistrict']['district_id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete # %s?', $selectDistrict['SelectDistrict']['district_id']));
                                            ?>
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

</div><!-- /.custom-margin-all -->