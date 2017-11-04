  <footer class="footer">
   <div class="container">
    <div class="clearfix">
     <span class="footer-copyright text-center">Sistem Informasi Geografis Dinas Kebersihan dan Pertamanan</span>
    </div>
   </div>
  </footer>
    
    <?php 
    if(isset($hal)){
      if($hal == 'GIS') { 
     echo Assets::external_js(array('jquery.min.js','bootstrap.min.js','typeahead.bundle.min.js','handlebars.min.js','list.min.js','leaflet.js','leaflet.markercluster.js','L.Control.Locate.min.js')); ?>
     <script src="../assets/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js"></script>
     <script src="../assets/js/app.js"></script>
    <?php } } ?>
</body>
</html>