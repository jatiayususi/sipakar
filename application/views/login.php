<!DOCTYPE html>
<html lang="en">
<link href="https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url(); ?>/assets/images/logo dr oen back putih.png">

    <title>SI PAKAR Dr.Oen Kandang Sapi Solo</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/gentelella/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/gentelella/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/gentelella/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url();?>assets/gentelella/animate.css/animate.min.css" rel="stylesheet">

    <!-- Sweetalert Css -->
    <link href="<?php echo base_url(); ?>assets/gentelella/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/gentelella/build/css/custom.min.css" rel="stylesheet">

    <script type="text/javascript">
    var base_url = "<?php echo base_url();?>";
    </script>

  </head>

  <body class="login" style="background-image: url(<?php echo base_url(); ?>assets/images/background-2.jpg); background-size: cover;">
    <div>
      <div class="login_wrapper">

        <div class="animate form login_form">
          <div class="clearfix" align="center"><img src="<?php echo base_url()?>assets/images/logo dr oen.png" height="200" width="190"></div>

          <section class="login_content">

              <p style="font-family: Merriweather, serif; font-size: 30px; "><b>SI PAKAR</b></p>
              <?php echo form_open('Administrator/validasi'); ?>
              <div>
                <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <div>
                <input type="password" class="form-control" name="keyword" placeholder="Keyword">
              </div>
              <div>
                <button class="btn btn-success" type="submit"><b><i class="fa fa-sign-in"> SIGN IN</i></b></button>
              </div>
              <?php echo form_close(); ?>

          </section>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/gentelella/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>assets/gentelella/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>assets/gentelella/fastclick/lib/fastclick.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>assets/gentelella/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url();?>assets/gentelella/skycons/skycons.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url();?>assets/gentelella/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url();?>assets/gentelella/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="<?php echo base_url();?>assets/gentelella/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- numbro Js -->
    <script src="<?php echo base_url();?>assets/js/numbro.min.js"></script>
    <!-- PNotify -->
    <script src="<?php echo base_url();?>assets/gentelella/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/pnotify/dist/pnotify.nonblock.js"></script>
    <!-- datatables -->
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/pdfmake/build/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url();?>assets/gentelella/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/parsleyjs/dist/parsley.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/parsleyjs/dist/i18n/id.js"></script>
    <script src="<?php echo base_url();?>assets/js/validate.min.js"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/gentelella/sweetalert/sweetalert.min.js"></script>

    <!-- Numeral -->
    <script src="<?php echo base_url(); ?>assets/gentelella/numeral/min/numeral.min.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>assets/gentelella/build/js/custom.js"></script>

    <?php if ($this->session->flashdata('message')): ?>
        <script>
            swal({
                title: "Login Gagal!",
                text: "<?php echo $this->session->flashdata('message'); ?>",
                timer: 1500,
                showConfirmButton: false,
                type: 'error'
            });
        </script>
    <?php endif; ?>

  </body>
</html>
