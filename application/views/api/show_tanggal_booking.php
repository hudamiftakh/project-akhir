<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->

    <title>Market Mobil dan Sopir</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/logo.png" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/style.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('dist/whatsapp/css/whatsapp-editor.css'); ?>" />
    <link rel="stylesheet"
        href="<?php echo base_url('dist/material-design-iconic-font/css/material-design-iconic-font.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/libs/dropzone/dropzone.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link href="<?= base_url('dist/font/css/font-awesome.css') ?>" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('dist/css/whatsapp.css'); ?>" />
    <script src="<?php echo base_url(); ?>dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/datatable/datatable-basic.init.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <br>
        <br>
        <br>
        <div class="card p-2">
            <h5 for=""><i class="fa fa-filter"></i> Pilih Filter</h5>
            <label for="">Tanggal Awal</label>
            <input type="date" name="tgl_awal"  min="<?= date('Y-m-d'); ?>" value="<?php echo $_REQUEST['tgl_awal']; ?>" id="tgl_awal" class="form-control"
                placeholder="Pilih Tanggal Awal" required>
            <label for="">Sampai Akhir</label>
            <input type="date" name="tgl_akhir"  min="<?= date('Y-m-d'); ?>" value="<?php echo $_REQUEST['tgl_akhir']; ?>"  id="tgl_akhir" class="form-control"
                placeholder="Pilih Tanggal Akhir" required>
            <br>
            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-block" onclick="showMobil();" name="showTanggal" value="Test">Cari Mobil</button>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/app.minisidebar.init.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/sidebarmenu.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>dist/js/ckeditor.js"></script>
    <script src="<?php echo base_url(); ?>dist/libs/dropzone/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('dist/whatsapp/js/whatsapp-editor.js'); ?>"></script>
    <script>
        function showMobil() {
            // Memanggil fungsi di window induk
            var tgl_awal = $("#tgl_awal").val();
            var tgl_akhir = $("#tgl_akhir").val();
            window.parent.showKendaraan(tgl_awal, tgl_akhir);
        }
    </script>

</body>

</html>