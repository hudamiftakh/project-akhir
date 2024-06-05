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
        <?php
        $id = $_REQUEST['id'];
        $showDetaiMobil = $this->db->get_where('m_kendaraan', array('kendaraan_id' => $id))->row_array();
        ?>
        <img src="<?php echo base_url('storage/' . $showDetaiMobil['']); ?>" alt="">


        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $no = 1;
                $showDetailGambar = $this->db->get_where('m_foto_kendaraan', array('kendaraan_id' => $id))->result_array();
                foreach ($showDetailGambar as $key => $value):
                    ?>
                    <div class="carousel-item <?php echo ($no <= 1) ? 'active' : ''; ?>">
                        <img class="d-block w-100" src="<?php echo base_url('storage/' . $value['file_foto']) ?>"
                            style="width: 100% !important; Height : 300px !important;" alt="First slide">
                    </div>
                    <?php
                    $no++;
                endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <table class="table table-stripped">
            <tr class="bg-danger text-white">
                <td colspan="2"
                    style="text-align: center !important;padding-top: 8px !important;padding-bottom: 5px !important;">
                    <h4 style="color: white;"><?= $showDetaiMobil['nama'] ?></h4>
                </td>
            </tr>
            <tr>
                <td width="1px" nowrap style="background-color: grey; color: white; font-weight: bold;">Harga</td>
                <td style="font-weight : bold">Rp. <?= number_format($showDetaiMobil['harga']) ?></td>
            </tr>
            <tr>
                <td nowrap style="background-color: grey; color: white; font-weight: bold;">Jenis Transmisi</td>
                <td><?= $showDetaiMobil['jenis_transmisi'] ?></td>
            </tr>
            <tr>
                <td style="background-color: grey; color: white; font-weight: bold;">Deskripsi</td>
                <td><?= $showDetaiMobil['deskripsi'] ?></td>
            </tr>
            <tr>
                <td style="background-color: grey; color: white; font-weight: bold;">Merek</td>
                <td><?= $showDetaiMobil['merek'] ?></td>
            </tr>
            <tr>
                <td style="background-color: grey; color: white; font-weight: bold;">Merek</td>
                <td><?= $showDetaiMobil['merek'] ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="d-grid gap-1">
                        <a class="btn btn-primary" href="<?php echo base_url('/api/proses_booking'); ?>?id=<?php echo $_REQUEST['id']; ?>&tgl_awal=<?php echo $_REQUEST['tgl_awal']; ?>&tgl_akhir=<?php echo $_REQUEST['tgl_akhir']; ?>&id_user=<?php echo $_REQUEST['id_user']; ?>" type="button">Proses</a>
                        <button class="btn btn-danger" onclick="window.parent.backtoHome();" type="button">Kembali</button>
                    </div>  
                </td>
            </tr>
        </table>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<script src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/js/vendor.min.js"></script>
<!-- Import Js Files -->
<script src="<?php echo base_url(); ?>dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</html>