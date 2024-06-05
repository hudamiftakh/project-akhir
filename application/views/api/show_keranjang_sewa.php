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
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <class="table-responsive">
                            <table class="table table-centered mb-0 table-nowrap">
                                <thead class="bg-primary" style="background-color: grey; color: white">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga/Hari</th>
                                        <th>Qty</th>
                                        <th>Total Harga Barang</th>
                                        <th>Durasi Sewa</th>
                                        <th nowrap="">
                                            Total <br>
                                            (Total Harga Barang * Durasi Sewa)
                                        </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tr style="background-color: #dfe6e9">
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4 = 2*3</th>
                                    <th>5</th>
                                    <th>6=4*6</th>
                                    <th>7</th>
                                </tr>
                                <tbody>
                                    <?php
                                    $id_pelanggan = $_REQUEST['id_user'];
                                    $no = 1;
                                    $total_harga = 0;
                                    $total_barang = 0;
                                    $cart_sql = $this->db->query("
                                                SELECT a.*, b.*, a.id as id_keranjang,
                                                DATEDIFF(a.tgl_selesai, tgl_pinjam) AS total_hari
                                                FROM m_keranjang_belanja as a
                                                LEFT JOIN m_kendaraan as b ON a.id_kendaraan = b.kendaraan_id
                                                WHERE a.id_user='" . $id_pelanggan . "'
                                                ORDER BY a.date_created ASC");
                                    echo "  SELECT a.*, b.*, a.id as id_keranjang,
                                                DATEDIFF(a.tgl_selesai, tgl_pinjam) AS total_hari
                                                FROM m_keranjang_belanja as a
                                                LEFT JOIN m_kendaraan as b ON a.id_kendaraan = b.kendaraan_id
                                                WHERE a.id_user='" . $id_pelanggan . "'
                                                ORDER BY a.date_created ASC";
                                    $total = $cart_sql->num_rows();
                                    $result = $cart_sql->result_array();
                                    if ($total <= 0):
                                        echo '<tr><td colspan="8" style="text-align:center"><a href="./" class="btn btn-danger">Kembali belanja</a></td></tr>';
                                    else:
                                        foreach ($result as $key => $data) {
                                            // while ($data = mysqli_fetch_array($cart_sql)) {
                                            ?>
                                            <tr>
                                                <td style="vertical-align: top">
                                                    <img src="<?php echo $base_url; ?>upload/<?php echo $data['gambar']; ?>"
                                                        alt="product-img" title="product-img" class="avatar-lg">
                                                </td>
                                                <td style="vertical-align: top"><?php echo $data['nama']; ?></td>
                                                <td style="vertical-align: top">
                                                    <?php echo "Rp. " . number_format($data['harga']); ?>
                                                </td>
                                                <td width="1%" nowrap="" style="vertical-align: top">
                                                    <div style="width: 120px;" class="product-cart-touchspin">
                                                        <input data-toggle="touchspin"
                                                            id="qty_val<?php echo $data['id_keranjang']; ?>"
                                                            onchange="updateISianQty('<?php echo $data['id_keranjang']; ?>','<?php echo $data['total_hari']; ?>')"
                                                            type="text" value="<?php echo $data['qty']; ?>">
                                                    </div>
                                                </td>
                                                <td nowrap="" id="harga_barang<?php echo $data['id_keranjang']; ?>"
                                                    style="vertical-align: top">
                                                    Rp. <?php echo number_format($data['total']); ?>
                                                </td>
                                                <td nowrap="" style="vertical-align: top">
                                                    Mulai : <br>
                                                    <i class="fa fa-calendar"></i>
                                                    <b
                                                        style="font-weight: bold;"><?php echo hari_tanggal($data['tgl_pinjam']); ?></b><br>
                                                    Selesai : <br> <i class="fa fa-calendar"></i> <b
                                                        style="font-weight: bold;"><?php echo hari_tanggal($data['tgl_selesai']); ?></b><br>
                                                    Total : <br>
                                                    <b style="font-weight: bold; vertical-align: top">
                                                        <i class="fa fa-clock"></i>
                                                        <?php echo $data['total_hari'] ?></b> Hari
                                                </td>
                                                <td id="total<?php echo $data['id_keranjang']; ?>" style="vertical-align: top">
                                                    Rp. <?php echo number_format($data['total'] * $data['total_hari']); ?></td>
                                                <td style="vertical-align: top">
                                                    <form action="" method="POST">
                                                        <input type="hidden" value="<?php echo $data['id_keranjang']; ?>"
                                                            name="id">
                                                        <button
                                                            onclick="return confirm('Apakah anda ingin menghapus data ini ?')"
                                                            class="btn btn-danger btn-sm btn-rounded" name="hapus"><i
                                                                class="mdi mdi-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                            $total_barang += 1;
                                            $total_harga += ($data['total'] * $data['total_hari']);
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="font-weight: bold;">Total</td>
                                            <td style="font-weight: bold" id="total">Rp.
                                                <?php echo number_format($total_harga); ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>