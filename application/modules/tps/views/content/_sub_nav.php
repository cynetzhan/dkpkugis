<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/tps';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == '' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl); ?>" id='list'>
            <?php echo lang('tps_list'); ?>
        </a>
	</li>
 <li>
  <a href="<?= base_url('admin/content/tps/downloadPdf'); ?>" id="pdf">Unduh PDF</a>
 </li>
	<?php if ($this->auth->has_permission('Tps.Content.Create')) : ?>
	<li<?php echo $checkSegment == 'create' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . '/create'); ?>" id='create_new'>
            <?php echo lang('tps_new'); ?>
        </a>
	</li>
	<?php endif; ?>
</ul>