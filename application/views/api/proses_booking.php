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
        <?php
        $id = $_REQUEST['id'];
        $showDetaiMobil = $this->db->get_where('m_kendaraan', array('kendaraan_id' => $id))->row_array();
        $showDetailGambar = $this->db->get_where('m_foto_kendaraan', array('kendaraan_id' => $id))->row_array();

        $tgl2 = strtotime($_REQUEST['tgl_awal']);
        $tgl1 = strtotime($_REQUEST['tgl_akhir']);
        $jarak = $tgl2 - $tgl1;
        $hari = $jarak / 60 / 60 / 24;

        $result_check = $this->db->query("SELECT * FROM m_keranjang_belanja 
                                  WHERE id_kendaraan='" . $id . "' 
                                  AND tgl_pinjam='" . $_REQUEST['tgl_awal'] . "'
                                  AND tgl_selesai ='" . $_REQUEST['tgl_akhir'] . "'
                                  AND tipe='kendaraan'
                                  ");
        $check = $result_check->num_rows();
        $data = $result_check->row_array();
        if ($check <= 0) {
            $data = array(
                'tgl_pinjam' => $_REQUEST['tgl_awal'],
                'tgl_selesai' => $_REQUEST['tgl_akhir'],
                'id_kendaraan' => $id,
                'harga' => $showDetaiMobil['harga'],
                'total' => $showDetaiMobil['harga'] * $hari,
                'id_user' => 1,
                'qty' => $hari,
                'tipe' => 'kendaraan',
                'date_created' => date('Y-m-d H:i:s')
            );
            $this->db->insert('m_keranjang_belanja', $data);
        }

        if (isset($_REQUEST['simpan_data'])) {
            $id_sopir = $_REQUEST['id_sopir'];
            $result_check = $this->db->query("SELECT * FROM m_keranjang_belanja 
            WHERE id_kendaraan='" . $id_sopir . "' 
            AND tgl_pinjam='" . $_REQUEST['tgl_awal'] . "'
            AND tgl_selesai ='" . $_REQUEST['tgl_akhir'] . "'
            AND tipe='sopir'
            ");
            $result_data_sopir = $this->db->get_where('m_sopir', array('id_sopir' => $id_sopir))->row_array();
            $check_sopir = $result_check->num_rows();
            $data = $result_check->row_array();
            if ($check_sopir <= 0) {
                $data_sopir_insert = array(
                    'tgl_pinjam' => $_REQUEST['tgl_awal'],
                    'tgl_selesai' => $_REQUEST['tgl_akhir'],
                    'id_kendaraan' => $id_sopir,
                    'harga' => $showDetaiMobil['harga'],
                    'total' => $showDetaiMobil['harga'] * $hari,
                    'id_user' => 1,
                    'qty' => $hari,
                    'tipe' => 'sopir',
                    'date_created' => date('Y-m-d H:i:s')
                );
                $this->db->insert('m_keranjang_belanja', $data_sopir_insert);
            }
        }

        if (isset($_REQUEST['hapus_keranjang'])) {
            $id_keranjang = $_REQUEST['id_keranjang'];
            $this->db->delete('m_keranjang_belanja', array('id' => $id_keranjang));
        }
        ?>
        <div class="col-12">
            <div class="card product-box" class="btn btn-primary d-block w-100" style="padding: 10px;">
                <?php
                $keranjang_belanja = $this->db->get_where('m_keranjang_belanja')->result_array();
                foreach ($keranjang_belanja as $key => $value): ?>
                    <?php if ($value['tipe'] == 'kendaraan'): ?>
                        <table>
                            <tr>
                                <td width="30%" style="padding-right: 10px; padding-left: 10px;">
                                    <img src="<?php echo base_url() . "storage/" . $showDetailGambar['file_foto']; ?>"
                                        alt="product-pic" style="height: 100px !important; width: 100px;" />
                                </td>
                                <td style="padding-top: 10px;">
                                    <h5 class="font-16 mt-0 mb-1"><a
                                            href="<?php echo $base_url; ?>detail/<?php echo $showDetaiMobil['id']; ?>"
                                            class="text-dark">[Kendaraan] <?php echo $showDetaiMobil['nama']; ?></a> </h5>
                                    <p class="m-0">
                                        <span class="text-muted">Rp.<?php echo number_format($showDetaiMobil['harga']); ?>
                                            /Hari</span>
                                    </p>
                                    <!-- <div id="detail"></div> -->
                                    <table>
                                        <tr>
                                            <td nowrap>Jumlah hari</td>
                                            <td style='font-weight : bold'>: <?= $hari ?> Hari</td>
                                        </tr>
                                        <tr>
                                            <td nowrap>Total Harga</td>
                                            <td style='font-weight : bold'>: Rp.
                                                <?php echo number_format($hari * $showDetaiMobil['harga']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id_keranjang"
                                                        value="<?php echo $value['id']; ?>">
                                                    <button class="btn btn-link" name="hapus_keranjang"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table> <br>
                    <?php endif; ?>
                    <?php if ($value['tipe'] == 'sopir'):
                        $detail_sopir = $this->db->get_where('m_sopir', array('id_sopir' => $value['id_kendaraan']))->row_array();
                        ?>
                        <table>
                            <tr>
                                <td width="30%" style="padding-right: 10px; padding-left: 10px;">
                                    <img src="<?php echo base_url() . "storage/sopir/" . $detail_sopir['foto']; ?>"
                                        alt="product-pic" style="height: 100px !important; width: 100px;" />
                                </td>
                                <td style="padding-top: 10px;">
                                    <h5 class="font-16 mt-0 mb-1">[Sopir] <?php echo $detail_sopir['nama']; ?> </h5>
                                    <p class="m-0">
                                        <span class="text-muted">Rp.<?php echo number_format($showDetaiMobil['harga']); ?>
                                            /Hari</span>
                                    </p>
                                    <table>
                                        <tr>
                                            <td nowrap>Jumlah hari</td>
                                            <td style='font-weight : bold'>: <?= $hari ?> Hari</td>
                                        </tr>
                                        <tr>
                                            <td nowrap>Total Harga</td>
                                            <td style='font-weight : bold'>: Rp.
                                                <?php echo number_format($hari * $detail_sopir['harga']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id_keranjang"
                                                        value="<?php echo $value['id']; ?>">
                                                    <button class="btn btn-link" name="hapus_keranjang"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                <?php endforeach; ?>
                <br>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
                    Sopir</a>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pilih Sopir</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-stripped">
                                        <tr>
                                            <td>Foto</td>
                                            <td>Nama</td>
                                            <td>Harga</td>
                                            <td>Aksi</td>
                                        </tr>
                                        <?php
                                        $showSopir = $this->db->get('m_sopir')->result_array();
                                        foreach ($showSopir as $key => $data):
                                            $result_check_sopir = $this->db->query("SELECT * FROM m_keranjang_belanja 
                                            WHERE id_kendaraan='" . $data['id_sopir'] . "' 
                                            AND tgl_pinjam='" . $_REQUEST['tgl_awal'] . "'
                                            AND tgl_selesai ='" . $_REQUEST['tgl_akhir'] . "'
                                            AND tipe='sopir'
                                            ")->num_rows();
                                            ?>
                                            <tr>
                                                <td><img src="<?php echo base_url('./storage/sopir/') . $data['foto']; ?>"
                                                        style="width: 100px; height: 100ps;" alt=""></td>
                                                <td><?= $data['nama'] ?></td>
                                                <td><?= number_format($data['harga']); ?></td>
                                                <td>
                                                    <?php if ($result_check_sopir <= 0): ?>
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="id_sopir"
                                                                value="<?php echo $data['id_sopir']; ?>">
                                                            <button type="submit" name="simpan_data"
                                                                class="btn btn-primary">Simpan</button>
                                                        </form>
                                                    <?php else: ?>
                                                        Sudah terpilih
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <form action="" id="save_order" enctype="multipart/form-data">
                    <input type="hidden" name="harga" value="<?php echo $showDetaiMobil['harga']; ?>" id="harga">
                    <input type="hidden" name="total_hari" id="total_hari">
                    <input type="hidden" name="user_id" value="<?php echo $_REQUEST['id_user']; ?>">
                    <label for="">Nomor Transaksi</label>
                    <input type="text" class="form-control" readonly name="no_transaksi" value="<?php echo "TRX".str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT); ?>">
                    <input type="hidden" name="total_rp" id="total_rp">
                    <input type="hidden" name="kendaraan_id" value="<?php echo $_REQUEST['id']; ?>">
                    <input type="hidden" name="tgl_awal" value="<?php echo $_REQUEST['tgl_awal']; ?>">
                    <input type="hidden" name="tgl_akhir" value="<?php echo $_REQUEST['tgl_akhir']; ?>">
                    <label for="">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama" required="">
                    <label for="">Whatsapp</label>
                    <input type="text" name="whatsapp" class="form-control" placeholder="Nomor Whatsap" required="">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email" required="">
                    <label for="">Alamat</label>
                    <textarea name="alamat" class="form-control" cols="10" rows="5" placeholder="Alamat"></textarea>
                    <label for="">KTP</label>
                    <input type="file" name="file" class="form-control" placeholder="KTP">
                    <label for="">Pembayaran</label>
                    <select name="jenis_pembayaran" class="form-control">
                        <option value="">Pilih Pembayaran</option>
                        <option value="cash">Tunai (Cash)</option>
                        <option value="transfer">Transfer</option>
                    </select>
                    <br>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
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
        var harga = $("#harga").val();
        const tanggalAkhir = new Date('<?php echo $_REQUEST["tgl_akhir"]; ?>');
        const tanggalAwal = new Date('<?php echo $_REQUEST["tgl_awal"]; ?>');
        const selisihWaktu = tanggalAkhir - tanggalAwal;
        const jumlahHari = selisihWaktu / (1000 * 60 * 60 * 24);
        const jumlahHariDibulatkan = Math.floor(jumlahHari);
        const total_rp = jumlahHariDibulatkan * harga;
        var harga = $("#total_hari").val(jumlahHariDibulatkan);
        var harga = $("#total_rp").val(total_rp);
        $("#detail").html(`
            <table>
                <tr>
                    <td>Jumlah hari</td>
                    <td style='font-weight : bold'>: ${jumlahHariDibulatkan} Hari</td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td style='font-weight : bold'>: ${total_rp.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</td>
                </tr>
            </table>
        `);
        $('#save_order').submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('api/saveOrder'); ?>",
                processData: false, // Jangan proses data, biarkan jQuery mengirimkan formdata apa adanya
                contentType: false, // Jangan tetapkan tipe konten, biarkan browser menetapkan multipart/form-data
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response.status=='success'){
                        window.location ='<?php echo base_url('/api/proses_bayar'); ?>?kode_transaksi='+response.nomor_transaksi
                    }else{
                        alert('Mohon maaf transaksi error, Mohon cek kembali isian anda. Terimakasih');
                    }
                }
            });
        });
    </script>
</body>

</html>