<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('/ReportManager/css/generic');
        echo $this->Html->css('/ReportManager/css/' . $reportStyle);
        
        echo $this->Html->css('bootstrap.min');
        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="main">    

            <?php echo $content_for_layout; ?>    
            <!--<div id="copyright"><br/>© 2012-2013 Report Manager developed by <a href="mailto:momin.aziz.cse@gmail.com">Md. Momin Al Aziz</a> - <a target="blank" href="http://www.mominalaziz.ninja/">Site</a></div>-->        
            <?php // echo $this->element('sql_dump');
           
            ?>      
        </div>
    </body>
</html>