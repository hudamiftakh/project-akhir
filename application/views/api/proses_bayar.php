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
        <?php
        $check_transaksi = $this->db->get_where('m_order', array('nomor_order' => $_REQUEST['kode_transaksi']))->row_array();
        if ($check_transaksi >= 1): ?>
            <?php if ($check_transaksi['jenis_pembayaran'] == 'transfer'): ?>
                <div class="alert alert-danger">
                    Pembaran menggunakan Ke rekening dibawah ini.
                    <table class="table">
                        <tr>
                            <td>BNI</td>
                            <td>000399485</td>
                            <td>PT Rentalinx</td>
                        </tr>
                        <tr>
                            <td>BCA</td>
                            <td>000366487</td>
                            <td>PT Rentalinx</td>
                        </tr>
                    </table>
                    Terimakasih
                </div>


                <form
                    action="<?php echo base_url('/api/proses_bayar'); ?>?kode_transaksi=<?php echo $_REQUEST['kode_transaksi']; ?>"
                    method="post" enctype="multipart/form-data">
                    <label for="">Tanggal Pembayaran</label> <br>
                    <?php if ($check_transaksi['struk_pembayaran'] != ''): ?>
                       <label for="" class="label label-success">Sudah upload</label> 
                       <?php else: ?>
                        <label for="" class="label label-danger">Belum upload</label>
                    <?php endif; ?> <br>
                    <label for="">Tanggal Pembayaran</label>
                    <input type="date" class="form-control" value="<?php echo $check_transaksi['tgl_pembayaran']; ?>"
                        min="<?php echo ('Y-m-d') ?>" name="tanggal">
                    <label for="">Struk Pembayaran</label>
                    <input type="file" name="file" class="form-control" placeholder="KTP">
                    <?php if ($check_transaksi['struk_pembayaran'] != ''): ?>
                        <a
                            href="<?php echo base_url('storage/struk'); ?>/<?php echo $check_transaksi['struk_pembayaran']; ?>"><?php echo $check_transaksi['struk_pembayaran']; ?></a>
                    <?php endif; ?>
                    <input type="hidden" name="id" class="form-control" value="<?php echo $_REQUEST['kode_transaksi']; ?>"
                        placeholder="">
                    <br>
                    <div class="d-grid gap-2">
                        <button type="submit" name="simpan" class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-danger">
                    Pembaran menggunakan CASH, Lakukan transaksi cash dengan memberikan uang tunai kepada admin. Terimakasih
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-danger">
                Maaf kode transaksi tidak ditemukan...
            </div>
        <?php endif; ?>
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
</body>

</html>