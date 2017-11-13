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
        <div class="column size1of2 first-column">
        
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
    var highlight = L.geoJson(null);
    var highlightStyle = {
    	stroke: false,
    	fillColor: "#00FFFF",
    	fillOpacity: 0.7,
    	radius: 10
    };

    var kecamatanColors = {
    	"Bukit Raya": "rgba(210,199,72,1.0)",
    	"Lima Puluh": "rgba(130,233,209,1.0)",
    	"Marpoyan Damai": "rgba(46,187,230,1.0)",
    	"Payung Sekaki": "rgba(132,116,220,1.0)",
    	"Pekanbaru": "rgba(218,63,63,1.0)",
    	"Rumbai": "rgba(107,214,139,1.0)",
    	"Rumbai Pesisir": "rgba(162,218,72,1.0)",
    	"Sail": "rgba(221,112,212,1.0)",
    	"Senapelan": "rgba(121,151,219,1.0)",
    	"Sukajadi": "rgba(204,156,117,1.0)",
    	"Tampan": "rgba(89,222,62,1.0)",
    	"Tenayan Raya": "rgba(159,78,209,1.0)"
    };

    /** fungsi untuk style kelurahan dikategorikan ke kecamatan
     */
    function style_kelurahan(feature) {
    	return {
    		opacity: 1,
    		color: 'rgba(0,0,0,0.1)',
    		dashArray: '',
    		lineCap: 'butt',
    		lineJoin: 'miter',
    		weight: 1.0,
    		fillOpacity: 0.2,
    		fillColor: kecamatanColors[feature.properties['Kecamatan']]
    	};
    }

    var pekanbaru = L.geoJson(null, {
    		style: style_kelurahan,
    		onEachFeature: function (feature, layer) {
    			//tampilkan modal kalau kelurahan di click
    			layer.on({
    				click: function (e) {
    					highlight.clearLayers().addLayer(
    						L.marker([lat, lng], {
    							icon: L.icon({
    								iconUrl: "<?= base_url() ?>assets/images/bin.png",
    								iconSize: [24, 28],
    								iconAnchor: [12, 28],
    								popupAnchor: [0, -25]
    							}),
    							riseOnHover: true
    						}));
    					$("span#coord").html(lat + ", " + lng);
    					$("input#lat").val(lat);
    					$("input#long").val(lng);
    					$("input#zoom").val(map.getZoom());
    				}
    			});
    		}
    	});
    $.getJSON("<?= base_url('data/kelurahan.php') ?>", function (data) {
    	pekanbaru.addData(data);
    });
    var cartoLight = L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png", {
    		maxZoom: 19,
    		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>'
    	});
    var googleMap = L.tileLayer("http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", {
    		maxZoom: 20,
    		subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    		attribution: "Provided by <a href='http://maps.google.com'>Google Maps</a>"
    	});
    var map = new L.Map('map', {
    		center: new L.LatLng(0.51861, 101.44728),
    		layers: [cartoLight, pekanbaru],
    		zoom: 13
    	}),
    drawnItems = L.featureGroup().addTo(map);
    
    L.control.layers(
    {
     'OpenStreetMap': cartoLight,
     'Google Maps': googleMap
    }, {
    	'Layer Titik Gambar': drawnItems
    }, {
    	position: 'bottomright',
    	collapsed: false
    }).addTo(map);
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
    		},
    		position: 'topright'
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
