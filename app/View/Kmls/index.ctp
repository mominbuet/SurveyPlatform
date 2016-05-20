<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            KML Views        </h1>
    </div>
</div>
<?php // debug($Kmls);?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo __('All Kmls'); ?>                <div class="panel-body">
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Parent'); ?></th>
                                    <th><?php echo $this->Paginator->sort('link'); ?></th>
                                    <th><?php echo $this->Paginator->sort('File'); ?></th>
                                    <th><?php echo $this->Paginator->sort('inserted'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Inserted By'); ?></th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Kmls as $device): ?>
                                <tr>
                                    <td><?php echo h($device['Kml']['id']); ?>&nbsp;</td>
                                    <td><?php echo h($device['Kml']['name']); ?>&nbsp;</td>
                                    <td><?php echo h($device['ParentKml']['name']); ?>&nbsp;</td>
                                    <td><a href="<?php echo ($device['ParentKml']['link']); ?>" target="_blank">Link</a>&nbsp;</td>
                                    <td><button onclick="viewKML('<?php echo $device['Kml']['file_location']; ?>', '<?php echo $device['Kml']['id']; ?>', '<?php echo $device['Kml']['link']; ?>');" class="btn btn-info">View</button> &nbsp;</td>
                                    <td><?php echo h($device['Kml']['inserted']); ?>&nbsp;</td>    
                                    <td><?php echo h($device['User']['first_name']) . ' ' . h($device['User']['last_name']); ?>&nbsp;</td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $device['Kml']['id']),array('class'=>'btn btn-warning')); ?>
                                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $device['Kml']['id']), array('class'=>'btn btn-danger'), __('Are you sure you want to delete # %s?', $device['Kml']['id'])); ?>
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
<div id="legend">
</div>
<div class="row">
    <div class="col-lg-12" id="map" style="min-height: 500px;">

    </div>
</div>
<style>
    #legend {
        font-family: Arial, sans-serif;
        background: #fff;
        padding: 10px;
        margin: 10px;
        border: 1px solid #000;
    }
</style>
<script type="text/javascript">
    var map;
    $(document).ready(function () {
        $('.kmlchild').change(function () {
            var thiselem = $(this);
            if (thiselem.is(":checked")) {
                var ctaLayer = new google.maps.KmlLayer({
//                    url: website + 'UIAPI/get_kml/' + thiselem.attr('info'),
                    url: thiselem.attr('info'),
                    map: map
                });
            }
        });
    });
    function viewKML(filelocation, kmlid,link) {
        var legend = document.getElementById('legend');
        $.getJSON(website + "UIAPI/get_kml_child/" + kmlid, function (data) {
//            console.log(data);


            for (var i = 0; i < data.length; i++) {
                var obj = data[i];
                console.log(obj.Kml.name);
                var div = document.createElement('div');
                div.innerHTML = '<input type="checkbox" class="kmlchild" info="' + obj.Kml.link + '"> &nbsp;&nbsp; ' + obj.Kml.name + '</input> ';
                legend.appendChild(div);
            }

        });
        console.log(link);
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9,
            center: {lat: 24.4362706, lng: 89.7367567}
//            center: {lat:41.876, lng: -87.624}
//center: {lat: 49.496675, lng: -102.65625}
        });
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(document.getElementById('legend'));
        var ctaLayer = new google.maps.KmlLayer({
//            url: "http://dflbd.com" +website + 'uploads/Kml/' + kmlid + "/" + filelocation,
            url:link,
//            url: 'http://googlemaps.github.io/js-v2-samples/ggeoxml/cta.kml',
            map: map,
            preserveViewport: true,
//url:'http://api.flickr.com/services/feeds/geo/C?g=322338@N20&lang=en-us&format=feed-georss'
        });

        console.log(ctaLayer);
//        ctaLayer.setMap(map);
    }
    function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA6UbP2n-WHNIsJ_6l9C_Ooz7nfbVCP21A' +
                '&signed_in=true';
        document.body.appendChild(script);
    }

    window.onload = loadScript;
</script>
