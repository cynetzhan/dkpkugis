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




echo Assets::css('leaflet.css');

echo Assets::js( 
	array('leaflet-src.js'
		, 'Leaflet.draw.js'
		, 'Leaflet.Draw.Event.js'
		, 'ext/TouchEvents.js'
		, 'edit/handler/Edit.Poly.js'
		, 'edit/handler/Edit.SimpleShape.js'
	//	, 'edit/handler/Edit.Circle.js'
	//	, 'edit/handler/Edit.Rectangle.js'
	//	, 'edit/handler/Edit.Marker.js'
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
                    <input id='nama' type='text' name='nama' maxlength='50' value="<?php echo set_value('nama', isset($jalan->nama) ? $jalan->nama : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('nama'); ?></span>
                </div>
            </div>
            
            
            <div class="control-group<?php echo form_error('armada') ? ' error' : ''; ?>">
                <?php echo form_label(lang('jalan_field_armada'), 'armada', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'armada', 'id' => 'armada', 'rows' => '5', 'cols' => '80', 'value' => set_value('armada', isset($jalan->armada) ? $jalan->armada : ''))); ?>
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
		var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			osm = L.tileLayer(osmUrl, {
				//maxZoom: 18, 
				attribution: osmAttrib});
			map = new L.Map('map', {
				layers: [osm]
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

		map.addLayer(polyline);

		// saat di edit, jangan lupa update textarea kita agar bisa disimpa di MySQL
		// perhatikan bahwa kita perlu ambil bentuk GeoJSON dulu dari polyline kita, lalu ambil koordinatnya
		polyline.on('edit', function() {
			//console.log('Polyline was edited!');
			//console.log(JSON.stringify(polyline.getLatLngs()));
			//document.getElementById('geom').value = JSON.stringify(polyline.getLatLngs());
			document.getElementById('geom').value = JSON.stringify(polyline.toGeoJSON().geometry.coordinates);
		});
	</script>

