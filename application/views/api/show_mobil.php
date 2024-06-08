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

        <?php if (isset($_REQUEST['showTanggal'])): ?>
            <br>
            <div class="col-lg-12">
                <div class="row">
                    <?php
                    if (!empty($_REQUEST['q']) or !empty($_REQUEST['jenis_transmisi'])) {
                        $q = "WHERE jenis_transmisi='" . $_REQUEST['jenis_transmisi'] . "' AND nama LIKE '%" . $_REQUEST['q'] . "%'";
                    } else {
                        $q = "";
                    }
                    $product = $this->db->query("SELECT * FROM m_kendaraan " . $q . " " . $_REQUEST['sql'])->result_array();
                    foreach ($product as $key => $dapod):
                        $gambar = $this->db->get_where("m_foto_kendaraan", array('kendaraan_id' => $dapod['kendaraan_id']))->row_array();
                        $dapod['gambar'] = $gambar['file_foto'];
                        $stock_akhir = 1;
                        ?>
                        <div class="col-12">
                            <div class="card product-box"
                                onclick="sendDetailKendaraanMessage('<?php echo $dapod['kendaraan_id']; ?>', '<?php echo $_REQUEST['tgl_awal']; ?>', '<?php echo $_REQUEST['tgl_akhir']; ?>');"
                                class="btn btn-primary d-block w-100">
                                <table>
                                    <tr>
                                        <td width="30%" style="padding-right: 10px; padding-left: 10px;">
                                            <img src="<?php echo base_url() . "storage/" . $dapod['gambar']; ?>"
                                                alt="product-pic" style="height: 100px !important; width: 100px;" />
                                        </td>
                                        <td style="padding-top: 10px;">
                                            <h5 class="font-16 mt-0 mb-1"><a
                                                    href="<?php echo $base_url; ?>detail/<?php echo $dapod['id']; ?>"
                                                    class="text-dark"><?php echo $dapod['nama']; ?></a> </h5>
                                            <p class="m-0">
                                                <span class="text-muted">Rp.<?php echo number_format($dapod['harga']); ?>
                                                    /Hari</span>
                                            </p>
                                            <p class="text-muted">
                                                Stock Tersisa : <?php echo $stock_akhir; ?> Item <br>
                                                <?php for ($i = 1; $i <= number_format($review_bintan['jawaban'], 2); $i++) {
                                                    echo '<i class="fa fa-star text-warning"></i>';
                                                } ?>
                                                (<?php echo number_format($review_bintan['jawaban'], 2); ?>)
                                            </p>
                                        </td>
                                    </tr>
                                </table>



                                <!-- <div class="product-action">
                                            <div class="d-flex">
                                                <?php if ($stock_akhir <= 0): ?>
                                                    <button onclick="alert('Maaf stock habis')"
                                                        class="btn btn-danger d-block w-100 action-btn m-2">Maaf stock
                                                        Habis</button>
                                                <?php else: ?>
                                                    <a style="border-radius: 0px;"
                                                        onclick="window.parent.detailKendaraan('<?php echo $dapod['kendaraan_id']; ?>|<?php echo $_REQUEST['tgl_awal']; ?>|<?php echo $_REQUEST['tgl_akhir']; ?>');"
                                                        class="btn btn-primary d-block w-100">
                                                        <i class="fa fa-eye"></i></a>

                                                    <button style="border-radius: 0px;"
                                                        onclick="window.parent.addtoCart('<?php echo $dapod['kendaraan_id']; ?>|<?php echo $_REQUEST['tgl_awal']; ?>|<?php echo $_REQUEST['tgl_akhir']; ?>|<?php echo $_REQUEST['user_id']; ?>|<?php echo $dapod['harga']; ?>')"
                                                        type="submit" name="simpan" class="btn btn-primary d-block w-100">
                                                        <i class="fa fa-shopping-cart"></i></button>
                                                <?php endif; ?>
                                            </div>
                                        </div> -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <br>
        <div class="card p-2">
            <h5 for=""><i class="fa fa-filter"></i> Pilih Filter</h5>
            <form action="<?php echo base_url('api/show_mobil') ?>" style="padding-top: 4px;">
                <label for="">Tanggal Awal</label>
                <input type="date" name="tgl_awal" value="<?php echo $_REQUEST['tgl_awal']; ?>" class="form-control"
                    placeholder="Pilih Tanggal Awal" required>
                <label for="">Sampai Akhir</label>
                <input type="date" name="tgl_akhir" value="<?php echo $_REQUEST['tgl_akhir']; ?>" class="form-control"
                    placeholder="Pilih Tanggal Akhir" required>
                <br>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block" name="showTanggal" value="Test">Cari Mobil</button>
                </div>
            </form>
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
    <script>
        function sendDetailKendaraanMessage(kendaraanId, tglAwal, tglAkhir) {
            var message = {
                action: 'detailKendaraan',
                kendaraanId: kendaraanId,
                tglAwal: tglAwal,
                tglAkhir: tglAkhir
            };
            window.parent.postMessage(message, '*');
        }
    </script>
    </script>

</body>

</html>