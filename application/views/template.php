<!DOCTYPE html>
<html lang="en">

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
    <!-- iCheck -->
    <link href="<?php echo base_url();?>assets/gentelella/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>assets/gentelella/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/gentelella/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="<?php echo base_url();?>assets/gentelella/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/gentelella/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/gentelella/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <!-- Datatables -->
    <!-- <link href="<?php echo base_url();?>assets/gentelella/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/gentelella/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/gentelella/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url();?>assets/gentelella/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="<?php echo base_url(); ?>assets/gentelella/tambahan-select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- <link href="<?php echo base_url(); ?>assets/gentelella/select2/dist/css/select2.css" rel="stylesheet"> -->

    <!-- Sweetalert Css -->
    <link href="<?php echo base_url(); ?>assets/gentelella/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="<?php echo base_url(); ?>assets/gentelella/dropzone/dist/dropzone.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/gentelella/build/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/gentelella/build/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
        .dropzone {
            background: white;
            border-radius: 5px;
            border: 2px dashed rgb(0, 135, 247);
            border-image: none;
            width: 390px;
            height: 100px;
            min-height: 0px !important;
            margin-left: auto;
            margin-right: auto;
        }
        .dropzone .dz-preview .dz-image {
            width: 90px;
            height: 90px;
        }
        .dropzone .dz-preview {
            margin-top: -5%;
            margin-left: 35%;
        }

        #loading {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
            display: block;
            opacity: 0.7;
            background-color: #fff;
            z-index: 99;
            text-align: center;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }
    </style>
    <script type="text/javascript">
    var base_url = "<?php echo base_url();?>";
    </script>
</head>

<body class="nav-md footer_fixed">
    <div id="loading" style="display: none;">
        <img id="loading-image" src="<?php echo base_url(); ?>assets/images/loading.gif" alt="Loading..." height="150" width="150" />
    </div>
    
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title">
                            <!-- <span>SI PANJI</span> -->
                            <img src="<?php echo base_url();?>assets/images/sipakar-white.png" style="height:42px;border:0;">
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <?php if($this->session->userdata('gender') == 'F'){ ?>
                                <img src="<?php echo base_url();?>assets/images/user.png" class="img-circle profile_img">
                            <?php } else { ?>
                                <img src="<?php echo base_url();?>assets/images/user2.png" class="img-circle profile_img">
                            <?php } ?>
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo $this->session->userdata('nama_payroll'); ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <?php if ($this->session->userdata('is_golatasxiii')) { ?>
                            <!-- <ul class="nav side-menu">
                            
                                <li>
                                <a>
                                   <i class="fa fa-list"></i>
                                   Master Data
                                   <span class="fa fa-chevron-down"></span> 
                                </a>
                                <ul class="nav child_menu">
                                <li><a href="<?php echo base_url('MasterPotongan');?>"><i class="fa fa-inbox "></i> Master Varibale Gaji </a></li>
                                <li><a href="<?php echo base_url('HakAkses');?>"><i class="fa fa-key "></i> Hak Akses </a></li>
                                <li><a href="<?php echo base_url('UploadGapok');?>"><i class="fa fa-upload"></i> Gapok</a></li>
                                 </ul>  
                                </li>
                                
                            </ul> -->

                            <ul class="nav side-menu">
                                <li><a href="<?php echo base_url('HakAkses');?>"><i class="fa fa-key"></i> Hak Akses </a></li>
                            </ul>

                            <ul class="nav side-menu">
                                <li>
                                    <a>
                                       <i class="fa fa-folder-open"></i>
                                       Pengelolaan Gaji Golongan XIII Keatas
                                       <span class="fa fa-chevron-down"></span> 
                                    </a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?php echo base_url('Upload/uploadAtasXIII');?>"><i class="fa fa-cloud-upload"></i> Upload Data Gaji</a></li>
                                        <li><a href="<?php echo base_url('DataGajiKaryawan/daftarAtasXIII');?>"><i class="fa fa-list-alt"></i> Data Gaji Karyawan</a></li>
                                        <li><a href="<?php echo base_url('LapGajipergolongan/lapAtasXIII');?>"><i class="fa fa-list-alt"></i> Laporan Gaji Pergolongan</a></li>
                                        <li><a href="<?php echo base_url('LapGajiperunit/lapPerunitAtasXIII');?>"><i class="fa fa-list-alt"></i> Laporan Gaji Perbagian</a></li>
                                    </ul>  
                                </li>
                            </ul>

                            <?php } ?>

                            <?php if ($this->session->userdata('is_golbawahxiii')) { ?>

                            <ul class="nav side-menu">
                                <li>
                                    <a>
                                       <i class="fa fa-folder-open-o"></i>
                                       Pengelolaan Gaji Golongan I-XII
                                       <span class="fa fa-chevron-down"></span> 
                                    </a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?php echo base_url('Upload/uploadBawahXIII');?>"><i class="fa fa-cloud-upload"></i> Upload Data Gaji</a></li>
                                        <li><a href="<?php echo base_url('DataGajiKaryawan/daftarBawahXIII');?>"><i class="fa fa-list-alt"></i> Data Gaji Karyawan</a></li>
                                        <li><a href="<?php echo base_url('LapGajipergolongan/lapBawahXIII');?>"><i class="fa fa-list-alt"></i> Laporan Gaji Pergolongan</a></li>
                                        <li><a href="<?php echo base_url('LapGajiperunit/lapPerunitBawahXII');?>"><i class="fa fa-list-alt"></i> Laporan Gaji Perunit</a></li>
                                    </ul>  
                                </li>
                            </ul>

                            <?php } ?>

                            <ul class="nav side-menu">
                                <li><a href="<?php echo base_url(); ?>assets/USER GUIDE SIPAKAR.pdf" target="_blank">
                                <i class="fa fa-file-image-o"></i> User Guide</a></li>
                            </ul>

                            <ul class="nav side-menu">
                                <li><a href="<?php echo base_url('Log');?>"><i class="fa fa-file-text-o"></i> Log </a></li>
                            </ul>

                            <ul class="nav side-menu">
                                <li><a href="<?php echo base_url('Administrator/logout');?>"><i class="fa fa-power-off"></i> Logout </a></li>
                            </ul>
                            
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main" style="background-image: url(<?php echo base_url(); ?>assets/images/bg2.jpg);">
                <?php $this->load->view($content);?>
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
    <!-- <script src="<?php echo base_url();?>assets/gentelella/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script> -->
    <!-- <script src="<?php echo base_url();?>assets/gentelella/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/datatables.net-scroller/js/dataTables.scroller.min.js"></script> -->
    
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/gentelella/jquery-datatable/extensions/export/buttons.html5.min.js"></script>

    <script src="<?php echo base_url();?>assets/gentelella/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/pdfmake/build/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url();?>assets/gentelella/tambahan-select2/dist/js/select2.full.min.js"></script>
    
    <script src="<?php echo base_url();?>assets/gentelella/parsleyjs/dist/parsley.min.js"></script>
    <script src="<?php echo base_url();?>assets/gentelella/parsleyjs/dist/i18n/id.js"></script>
    <script src="<?php echo base_url();?>assets/js/validate.min.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/js/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script> -->

    <!-- SweetAlert Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/gentelella/sweetalert/sweetalert.min.js"></script>

    <!-- Numeral -->
    <script src="<?php echo base_url(); ?>assets/gentelella/numeral/min/numeral.min.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>assets/gentelella/build/js/custom.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/gentelella/dropzone/dist/dropzone.js"></script>

    <!-- <script src="<?php echo base_url();?>assets/gentelella/build/js/custom.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/js/print.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/potongan.js"></script>
    <script src="<?php echo base_url();?>assets/js/gaji.js"></script>
    <script src="<?php echo base_url();?>assets/js/karyawan.js"></script>
    <script src="<?php echo base_url();?>assets/js/hakakses.js"></script>
    <script src="<?php echo base_url();?>assets/js/datagajikaryawan.js"></script>
    <script src="<?php echo base_url();?>assets/js/lapgajipergolongan.js"></script>
    <script src="<?php echo base_url();?>assets/js/lapgajiperunit.js"></script>

    <?php if ($this->session->flashdata('berhasil')): ?>
        <script>
            swal({
                title: "Berhasil",
                text: "<?php echo $this->session->flashdata('berhasil'); ?>",
                timer: 2500,
                showConfirmButton: false,
                type: 'success'
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('gagal')): ?>
        <script>
            swal({
                title: "Gagal !",
                text: "<?php echo $this->session->flashdata('gagal'); ?>",
                timer: 2500,
                showConfirmButton: false,
                type: 'error'
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('data_salah')): ?>
        <script>
            swal({
                title: "Ada Data Yang Salah !",
                text: "<?php echo $this->session->flashdata('data_salah'); ?>",
                //timer: 3000,
                //showConfirmButton: true,
                type: 'warning'
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('test')): ?>
        <script>
            swal({
                title: "Gagal",
                text: "<?php echo $this->session->flashdata('test'); ?>",
                //timer: 3000,
                //showConfirmButton: true,
                type: 'warning'
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('message')): ?>
        <script type="text/javascript">
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