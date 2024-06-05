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
        <div class="card">
            <div class="col-lg-12">
                <div class="row">
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="card p-2">
                        <h5 for=""><i class="fa fa-filter"></i> Login untuk memulai</h5>
                        <form id="loginForm">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <br>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-block" name="showTanggal" value="Test">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        $("#loginForm").on("submit", function (event) {
            event.preventDefault(); // Mencegah pengiriman form secara default
            var formData = $(this).serialize(); // Serialisasi data form
            window.parent.login(formData);
        });
    });
</script>

</html>