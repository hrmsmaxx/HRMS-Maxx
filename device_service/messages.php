<div class="col-xs col-sm col-lg">
  <?php
  $class_div = '';
  $ico = 'warning';
  foreach ($seccion->message as $mensaje) :
    if (!empty($mensaje['msg_style'])) {
      $class_div = ' alert-' . $mensaje['msg_style'];
      switch ($mensaje['msg_style']) {
        case 'success':
          $ico = 'glyphicon glyphicon-ok';
          break;
        case 'danger':
          $ico = 'md md-error';
          break;
        case 'info':
          $ico = 'md md-info-outline';
          break;
        case 'warning':
          $ico = 'fa fa-exclamation';
          break;
      }
    }
  ?>
    <div class="alert<?php echo $class_div; ?>">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <i class="<?php echo $ico; ?>" style="padding-right: 5px;"></i> <?php echo $mensaje['msg']; ?>
    </div>
  <?php endforeach; ?>
</div>