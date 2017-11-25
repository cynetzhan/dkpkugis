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




echo Assets::css('leaflet-0.7.css');
echo Assets::css('leaflet.draw.css');
echo Assets::js( 
	array('leaflet-0.7.js'
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
    <h3>Jalan</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <div class="column size1of2 fist-column">
		<fieldset>
            

            <div class="control-group<?php echo form_error('nama') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_nama'), 'nama', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='nama' type='text' name='nama' maxlength='100' value="<?php echo set_value('nama', isset($jalan->nama) ? $jalan->nama : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('nama'); ?></span>
                </div>
            </div>
            
            
            <div class="control-group<?php echo form_error('armada') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_armada'), 'armada', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <select name="armada">
                     <option value="L-300" <?= (set_value('armada', $jalan->armada) == "L-300") ? 'selected' : ''; ?> >L-300</option>
                     <option value="Dump Truck" <?= (set_value('armada',$jalan->armada) == "Dump Truck") ? 'selected' : ''; ?> >Dump Truck</option>
                     </select>
                    <span class='help-inline'><?php echo form_error('armada'); ?></span>
                </div>
            </div>
            
            <div class="control-group<?php echo form_error('kecamatan') ? ' error' : ''; ?>">
                <?php echo form_label("Kecamatan", 'kecamatan', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <select name="kecamatan" id="kecamatan">
                     <option value="Bukit Raya" <?= (set_value('kecamatan', $jalan->kecamatan) == "Bukit Raya") ? 'selected' : ''; ?>>Bukit Raya</option>
                     <option value="Lima Puluh" <?= (set_value('kecamatan', $jalan->kecamatan) == "Lima Puluh") ? 'selected' : ''; ?>>Lima Puluh</option>
                     <option value="Marpoyan" <?= (set_value('kecamatan', $jalan->kecamatan) == "Marpoyan") ? 'selected' : ''; ?>>Marpoyan</option>
                     <option value="Payung Sekaki" <?= (set_value('kecamatan', $jalan->kecamatan) == "Payung Sekaki") ? 'selected' : ''; ?>>Payung Sekaki</option>
                     <option value="Pekanbaru Kota" <?= (set_value('kecamatan', $jalan->kecamatan) == "Pekanbaru Kota") ? 'selected' : ''; ?>>Pekanbaru Kota</option>
                     <option value="Rumbai Pesisir" <?= (set_value('kecamatan', $jalan->kecamatan) == "Rumbai Pesisir") ? 'selected' : ''; ?>>Rumbai Pesisir</option>
                     <option value="Rumbai" <?= (set_value('kecamatan', $jalan->kecamatan) == "Rumbai") ? 'selected' : ''; ?>>Rumbai</option>
                     <option value="Sail" <?= (set_value('kecamatan', $jalan->kecamatan) == "Sail") ? 'selected' : ''; ?>>Sail</option>
                     <option value="Senapelan" <?= (set_value('kecamatan', $jalan->kecamatan) == "Senapelan") ? 'selected' : ''; ?>>Senapelan</option>
                     <option value="Sukajadi" <?= (set_value('kecamatan', $jalan->kecamatan) == "Sukajadi") ? 'selected' : ''; ?>>Sukajadi</option>
                     <option value="Tampan" <?= (set_value('kecamatan', $jalan->kecamatan) == "Tampan") ? 'selected' : ''; ?>>Tampan</option>
                     <option value="Tenayan Raya" <?= (set_value('kecamatan', $jalan->kecamatan) == "Tenayan Raya") ? 'selected' : ''; ?>>Tenayan Raya</option>
                    </select>
                    <span class='help-inline'><?php echo form_error('kecamatan'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('geom') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_geom'), 'geom', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'geom', 'id' => 'geom', 'rows' => '5', 'cols' => '80', 'value' => set_value('geom', isset($jalan->geom) ? $jalan->geom : ''))); ?>
                    <span class='help-inline'><?php echo form_error('geom'); ?></span>
                </div>
            </div>
            
            <div class="control-group<?php echo form_error('jadwal_mulai') ? ' error' : ''; ?>">
                <?php echo form_label("Jadwal Mulai", 'jadwal_mulai', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='jadwal_mulai' type='time' name='jadwal_mulai' maxlength='50' pattern="[0-9]{2}:[0-9]{2}" value="<?php echo set_value('jadwal_mulai', isset($jalan->jadwal_mulai) ? $jalan->jadwal_mulai : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('jadwal_mulai'); ?></span>
                </div>
            </div>
            
            <div class="control-group<?php echo form_error('jadwal_selesai') ? ' error' : ''; ?>">
                <?php echo form_label("Jadwal selesai", 'jadwal_selesai', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='jadwal_selesai' type='time' name='jadwal_selesai' maxlength='50' pattern="[0-9]{2}:[0-9]{2}" value="<?php echo set_value('jadwal_selesai', isset($jalan->jadwal_selesai) ? $jalan->jadwal_selesai : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('jadwal_selesai'); ?></span>
                </div>
            </div>
        </fieldset>
		</div>
        <div class="column size1of2 last-column">
			<div id="map" style="min-width: 300px; min-height: 400px; border: 1px solid #ccc"></div>
		</div>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('jalan_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/jalan', lang('jalan_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Jalan.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('jalan_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('jalan_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>



	<script>
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
    		opacity: 0.5,
    		color: 'rgba(0,0,0,0.1)',
    		dashArray: '',
    		lineCap: 'butt',
    		lineJoin: 'miter',
    		weight: 1.0,
    		fillOpacity: 0.1,
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
     var osm = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
    		maxZoom: 20,
    		subdomains: ['a','b','c'],
    		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>"'
    	});
			map = new L.Map('map', {
				layers: [osm, pekanbaru]
				, center: new L.LatLng(0.51861, 101.44728)
				, zoom: 18});


		
		var jalan_geom =<?php echo $jalan->geom;?>;
		
		// fungsi untuk membalik geom karena disimpan di MySQL dalam [long,lat], sedangkan
		// Leaflet butuh dalam latLng
		function balik(a){
			var out=[];
			for(i=0;i<a.length;i++){
				out.push([a[i][1],a[i][0]]);
			}
			return out;
		}
		
		var polyline = new L.Polyline(balik(jalan_geom));
		
		//pastikan agar peta kita sekarang zoom ke polyline kita
		map.fitBounds(polyline.getBounds());

		polyline.editing.enable();
  drawnItems = L.featureGroup([polyline]).addTo(map);

		//map.addLayer(polyline);
  
  L.control.layers(
    {
     'OpenStreetMap': osm,
     'Google Maps': googleMap
    }, {
    	'Layer Titik Rute': drawnItems
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
		// saat di edit, jangan lupa update textarea kita agar bisa disimpa di MySQL
		// perhatikan bahwa kita perlu ambil bentuk GeoJSON dulu dari polyline kita, lalu ambil koordinatnya
		polyline.on('edit', function() {
			//console.log('Polyline was edited!');
			//console.log(JSON.stringify(polyline.getLatLngs()));
			//document.getElementById('geom').value = JSON.stringify(polyline.getLatLngs());
			document.getElementById('geom').value = JSON.stringify(polyline.toGeoJSON().geometry.coordinates);
		});
	</script>

