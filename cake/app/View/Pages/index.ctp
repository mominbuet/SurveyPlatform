
<?php echo $this->Html->css('morris');
echo $this->Html->css('timeline');?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$answerCount?></div>
                        <div>New Survey Entries!</div>
                    </div>
                </div>
            </div>
            <a href="./UsersQuestionData/">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$qsetCount?></div>
                        <div>Surveys</div>
                    </div>
                </div>
            </div>
            <a href="./QuestionSets/">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$usersCount?></div>
                        <div>Active Users</div>
                    </div>
                </div>
            </div>
            <a href="./Users/">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Survey Entries
                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-area-chart"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Date wise Survey Entries
                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Survey No</th>
                                        <th>Date</th>
                                        <th>User Count</th>
                                        <th>Entries</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>01/21/2015</td>
                                        <td>154</td>
                                        <td>547</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>01/22/2015</td>
                                        <td>158</td>
                                        <td>744</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>01/23/2015</td>
                                        <td>145</td>
                                        <td>502</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.col-lg-4 (nested) -->
                    <div class="col-lg-8">
                        <div id="morris-bar-chart"></div>
                    </div>
                    <!-- /.col-lg-8 (nested) -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
<!--        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Notifications Panel
            </div>
             /.panel-heading 
            <div class="panel-body">
                <div class="list-group">
                    <a href="#" class="list-group-item">
                        <i class="fa fa-comment fa-fw"></i> New Entry
                        <span class="pull-right text-muted small"><em>4 minutes ago</em>
                        </span>
                    </a>
                    <a href="#" class="list-group-item">
                        <i class="fa fa-twitter fa-fw"></i> 3 New Users
                        <span class="pull-right text-muted small"><em>12 minutes ago</em>
                        </span>
                    </a>
                    <a href="#" class="list-group-item">
                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                        <span class="pull-right text-muted small"><em>27 minutes ago</em>
                        </span>
                    </a>
                    <a href="#" class="list-group-item">
                        <i class="fa fa-tasks fa-fw"></i> New Task
                        <span class="pull-right text-muted small"><em>43 minutes ago</em>
                        </span>
                    </a>

                </div>
                 /.list-group 
                <a href="#" class="btn btn-default btn-block">View All Alerts</a>
            </div>
             /.panel-body 
        </div>-->
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Today's Entry count
            </div>
            <div class="panel-body">
                <div id="morris-donut-chart"></div>
                <a href="#" class="btn btn-default btn-block">View Details</a>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

    </div>
    <!-- /.col-lg-4 -->
</div>

<?php  echo $this->Html->script('raphael-min');
echo $this->Html->script('morris.min');echo $this->Html->script('morris-data');

?>
<script type="text/javascript" >
    
</script>