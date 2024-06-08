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
    <div class="card">
        <?php if ($_REQUEST['detail'] == 'true' and $_REQUEST['kode_transaksi']):
            $showListPesanan = $this->db->get_where("m_order_detail", array('kode_transaksi' => $_REQUEST['kode_transaksi']))->result_array();
            $showDetailPesanan = $this->db->get_where("m_order", array('nomor_order' => $_REQUEST['kode_transaksi']))->row_array();
            ?>
            <div class="card-body" style="padding-left: 0px; padding-top: 0px;">
                <div class="row">
                    <?php $url = base_url('api/pesanan') . "?id_user=" . $_REQUEST['id_user']; ?>
                    <div class="col-lg-12">
                        <table class="table table stripped">
                            <tr>
                                <td colspan="2"><a class="btn btn-danger" href="<?php echo $url; ?>"> <i class="fa fa-back"></i> Kembali</a></td>
                            </tr>
                            <tr>
                                <td width="1px" nowrap="">Kode Transaksi</td>
                                <td>: <?php echo $showDetailPesanan['nomor_order']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>: <?php echo $showDetailPesanan['nama']; ?></td>
                            </tr>
                            <tr>
                                <td>Whatsapp</td>
                                <td>: <?php echo $showDetailPesanan['whatsapp']; ?></td>
                            </tr>
                            <tr>
                                <td>Jenis Pembayaran</td>
                                <td>: <?php echo $showDetailPesanan['jenis_pembayaran']; ?></td>
                            </tr>
                            <?php if ($showDetailPesanan['jenis_pembayaran'] == 'transfer' and $showDetailPesanan['struk_pembayaran'] !=''): ?>
                                <tr>
                                    <td>Struk Pembayaran</td>
                                    <td>: <a
                                            href="<?php echo base_url('storage/struk'); ?>/<?php echo $showDetailPesanan['struk_pembayaran']; ?>">Lihat</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                        <table class="table table-bordered table-stripped">
                            <thead style="background-color: grey; color : white; font-weight: bold;">
                                <tr>
                                    <th>#</th>
                                    <th>Tgl Pjm/Sls</th>
                                    <th>Jenis</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no =1;  $sum = 0; foreach ($showListPesanan as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo str_replace('00:00:00','',$value['tgl_pinjam']); ?> / <?php echo str_replace('00:00:00','',$value['tgl_selesai']); ?></td>
                                        <td><?php echo $value['tipe']; ?></td>
                                        <td><?php echo $value['qty']; ?></td>
                                        <td>Rp. <?php echo number_format($value['harga']); ?></td>
                                    </tr>
                                <?php 
                                    $sum +=$value['harga'];
                                endforeach; ?>
                                <tr>
                                    <td colspan="4">Total</td>
                                    <td>Rp. <?php echo number_format($sum); ?></td>
                                </tr>
                            </tbody>

                        </table>


                    </div>
                </div>
            <?php else: ?>
                <div class="card-body" style="
                    padding-left: 10px;
                    padding-right: 10px;
                    padding-top: 10px;
                    ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="list-group">
                                <?php
                                $no = 1;
                                $result_order = $this->db->get_where("m_order", array('user_id' => $_REQUEST['id_user']))->result_array();
                                foreach ($result_order as $key => $value) {
                                    $url = base_url('api/pesanan') . "?id_user=" . $_REQUEST['id_user'] . "&detail=true&kode_transaksi=" . $value['nomor_order'];
                                    ?>
                                    <a href="<?php echo $url; ?>"
                                        class="list-group-item list-group-item-action" aria-current="true">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><span
                                                    class="badge bg-primary rounded-pill"><?php echo $no++; ?></span>
                                                kode
                                                #<?php echo $value['nomor_order']; ?></h5>
                                            <small><?php echo $value['create_at']; ?></small>
                                        </div>
                                        <p class="mb-1">
                                            Tanggal Mulai : <?php echo str_replace(' 00:00:00', '', $value['tgl_awal']); ?> <br>
                                            Tanggal Selesai : <?php echo $value['tgl_akhir']; ?> <br>
                                            Hari : <?php echo str_replace(' 00:00:00', '', $value['total_hari']); ?> Hari
                                        </p>
                                        <p style="font-weight: body; font-size: 15px;" class="mb-1">Rp
                                            <?php echo number_format($value['total']); ?>
                                        </p>
                                        <small>And some small print.</small>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
</body>

</html>