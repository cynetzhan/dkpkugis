<div class="container" style="margin-top:70px;min-height:90vh">
 <div class="row">
  <div class="col-sm-6 col-sm-offset-3">
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3><?php echo lang('us_login'); ?></h3>
    </div>
    <div class="panel-body">
   <?php
    $site_open = $this->settings_lib->item('auth.allow_register');
   ?>
   <p><br/><a href="<?php echo site_url(); ?>">&larr; <?php echo lang('us_back_to') . $this->settings_lib->item('site.title'); ?></a></p>
    <?php echo Template::message(); ?>

    <?php
     if (validation_errors()) :
    ?>
      <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       <?php echo validation_errors(); ?>
      </div>
    <?php endif; ?>

    <?php echo form_open(LOGIN_URL, array('autocomplete' => 'off','class' => 'form-horizontal', 'style' => 'padding:20px')); ?>

     <div class="form-group <?php echo iif( form_error('login') , 'error') ;?>">
       <input class="form-control" type="text" name="login" id="login_value" value="<?php echo set_value('login'); ?>" tabindex="1" placeholder="<?php echo $this->settings_lib->item('auth.login_type') == 'both' ? lang('bf_username') .'/'. lang('bf_email') : ucwords($this->settings_lib->item('auth.login_type')) ?>" />
     </div>

     <div class="form-group <?php echo iif( form_error('password') , 'error') ;?>">
       <input class="form-control" type="password" name="password" id="password" value="" tabindex="2" placeholder="<?php echo lang('bf_password'); ?>" />
     </div>

     <?php if ($this->settings_lib->item('auth.allow_remember')) : ?>
      <div class="form-group">
       <div class="controls">
         <input type="checkbox" name="remember_me" id="remember_me" value="1" tabindex="3" />
         <span><?php echo lang('us_remember_note'); ?></span>
       </div>
      </div>
     <?php endif; ?>

     <div class="control-group">
       <input class="btn btn-lg btn-primary" type="submit" name="log-me-in" id="submit" value="<?php e(lang('us_let_me_in')); ?>" tabindex="5" />
     </div>
    <?php echo form_close(); ?>

    <?php // show for Email Activation (1) only
     if ($this->settings_lib->item('auth.user_activation_method') == 1) : ?>
    <!-- Activation Block -->
      <p style="text-align: left" class="well">
       <?php echo lang('bf_login_activate_title'); ?><br />
       <?php
       $activate_str = str_replace('[ACCOUNT_ACTIVATE_URL]',anchor('/activate', lang('bf_activate')),lang('bf_login_activate_email'));
       $activate_str = str_replace('[ACTIVATE_RESEND_URL]',anchor('/resend_activation', lang('bf_activate_resend')),$activate_str);
       echo $activate_str; ?>
      </p>
    <?php endif; ?>

    <p style="text-align: center">
     <?php if ( $site_open ) : ?>
      <?php echo anchor(REGISTER_URL, lang('us_sign_up')); ?>
     <?php endif; ?>

     <br/><?php echo anchor('/forgot_password', lang('us_forgot_your_password')); ?>
    </p>

     </div>
    </div>
   </div>
  </div>
 </div>
</div>