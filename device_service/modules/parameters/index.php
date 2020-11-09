<div class="row">
  <?php include('modules/' . $option . '/list.php'); ?>
</div>
<script src="<?php echo 'modules/' . $option . '/'; ?>scripts.js?v=<?php echo $inicio->getVersion(); ?>"></script>
<?php if (isset($_GET['configurar']) && $_GET['configurar'] == 'envio_link') { ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#accordion-fe').click();
      $('html').animate({
        scrollTop: '400px'
      }, 400);
    });
  </script>
<?php } ?>