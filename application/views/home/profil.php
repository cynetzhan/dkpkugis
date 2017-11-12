<div class="container" style="margin:70px auto;min-height:80vh">
 <div class="row">
  <div class="col-md-8">
  <ol class="breadcrumb">
   <li><a href="<?= base_url('') ?>">Home</a></li>
   <li class="active"><span><?= $profil->judul_profil ?></span></li>
  </ol>
  <h2><?= $profil->judul_profil ?></h2>
  <p><small>Ditulis pada <?= tanggal($profil->tgl_terbit_profil,true) ?></small></p>
      <?= specialRemove($profil->isi_profil) ?>
  </div>
  <div class="col-md-4">
  <h4>Profil DKP Kota Pekanbaru</h4>
  <ul class="nav nav-pills nav-stacked">
   <?php foreach($prolist as $pro) { ?>
    <li <?= ($profil->id_profil == $pro->id_profil)?"class='active'":"" ?>><a href="<?= base_url('home/profil/'.$pro->id_profil) ?>"><?= $pro->judul_profil ?></a></li>
   <?php } ?>
  </ul>
  </div>
 </div>
</div>