<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('jalan_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($jalan->id) ? $jalan->id : '';

// add CSS dan JavaScript yang digunakan untuk Create Feature

echo Assets::css('leaflet.css');
echo Assets::css('leaflet.draw.css');

echo Assets::js( 
	array('leaflet-src.js'
		, 'Leaflet.draw.js'
		, 'Leaflet.Draw.Event.js'

		, 'Toolbar.js'
		, 'Tooltip.js'
		, 'ext/GeometryUtil.js'
		, 'ext/LatLngUtil.js'
		, 'ext/LineUtil.Intersect.js'
		, 'ext/Polygon.Intersect.js'
		, 'ext/Polyline.Intersect.js'
		, 'ext/TouchEvents.js'
		, 'draw/DrawToolbar.js'
		, 'draw/handler/Draw.Feature.js'
		, 'draw/handler/Draw.SimpleShape.js'
		, 'draw/handler/Draw.Polyline.js'
		, 'draw/handler/Draw.Circle.js'
		, 'draw/handler/Draw.Marker.js'
		, 'draw/handler/Draw.Polygon.js'
		, 'draw/handler/Draw.Rectangle.js'
		, 'edit/EditToolbar.js'
		, 'edit/handler/EditToolbar.Edit.js'
		, 'edit/handler/EditToolbar.Delete.js'
		, 'Control.Draw.js'
		, 'edit/handler/Edit.Poly.js'
		, 'edit/handler/Edit.SimpleShape.js'
		, 'edit/handler/Edit.Circle.js'
		, 'edit/handler/Edit.Rectangle.js'
		, 'edit/handler/Edit.Marker.js'

		
	), 'external' ); //external or inline

?>
<div class='admin-box'>
    <h3>jalan</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <div class="column size1of2 fist-column">
        
		<fieldset>
            

            <div class="control-group<?php echo form_error('nama') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_nama'), 'nama', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='nama' type='text' name='nama' maxlength='50' value="<?php echo set_value('nama', isset($jalan->nama) ? $jalan->nama : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('nama'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('armada') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_armada'), 'armada', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'armada', 'id' => 'armada', 'rows' => '5', 'cols' => '80', 'value' => set_value('html', isset($jalan->html) ? $jalan->html : ''))); ?>
                    <span class='help-inline'><?php echo form_error('armada'); ?></span>
                </div>
            </div>


            <div class="control-group<?php echo form_error('html') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_html'), 'html', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'html', 'id' => 'html', 'rows' => '5', 'cols' => '80', 'value' => set_value('html', isset($jalan->html) ? $jalan->html : ''))); ?>
                    <span class='help-inline'><?php echo form_error('html'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('geom') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_geom'), 'geom', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'geom', 'id' => 'geom', 'rows' => '5', 'cols' => '80', 'value' => set_value('geom', isset($jalan->geom) ? $jalan->geom : ''))); ?>
                    <span class='help-inline'><?php echo form_error('geom'); ?></span>
                </div>
            </div>
        </fieldset>
		</div>
        <div class="column size1of2 last-column">
			<div id="map" style="min-width: 300px; min-height: 400px; border: 1px solid #ccc"></div>
		</div>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('jalan_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/jalan', lang('jalan_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>


<script>
    var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            osm = L.tileLayer(osmUrl, { 
				maxZoom: 18
				, attribution: osmAttrib 
			}),
            map = new L.Map('map', { 
				center: new L.LatLng(0.51861, 101.44728)
				, zoom: 13 
			}),
            drawnItems = L.featureGroup().addTo(map);
    L.control.layers({
        //'osm': osm.addTo(map),
        //"google": L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
        //    attribution: 'google'
        //})
//    }, { 'drawlayer': drawnItems }, { position: 'topleft', collapsed: false }).addTo(map);
    }, { 'drawlayer': drawnItems }, { position: 'bottomright', collapsed: false }).addTo(map);
    map.addControl(new L.Control.Draw({
        edit: {
            featureGroup: drawnItems,
            poly: {
                allowIntersection: false
            }
        },
        draw: {
            polygon: {
                allowIntersection: false,
                showArea: true
            }
        }, position: 'topright'
    }));

	var latestLayer;
    map.on(L.Draw.Event.CREATED, function (event) {
        var layer = event.layer;
		latestLayer = layer;
		console.log('L.Draw.Event.CREATED');
		document.getElementById('geom').value = JSON.stringify(latestLayer.toGeoJSON().geometry.coordinates);

        drawnItems.addLayer(layer);
    });

</script>
