<h4 class="">Laporan Data</h4>
<!-- Row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="fs-7">
                            <?php echo $this->db->get("m_user")->num_rows(); ?>
                        </h2>
                        <h6 class="fw-medium text-info mb-0">Pelanggan</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-info display-6"><i class="ti ti-users"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-primary">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="fs-7"><?php echo $this->db->get("m_kendaraan")->num_rows(); ?></h2>
                        <h6 class="fw-medium text-primary mb-0">Mobil</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-primary display-6"><i class="ti ti-car"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-success">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="fs-7"><?php echo $this->db->get("m_sopir")->num_rows(); ?></h2>
                        <h6 class="fw-medium text-success mb-0">Sopir</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-success display-6"><i class="ti ti-user"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-danger">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="fs-7"><?php echo $this->db->get("m_order")->num_rows(); ?></h2>
                        <h6 class="fw-medium text-danger mb-0">transaksi</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-danger display-6"><i class="ti ti-chart"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$showListPesanan = $this->db->get_where("m_order_detail")->result_array();
$showDetailPesanan = $this->db->get_where("m_order", array('nomor_order' => $_REQUEST['kode_transaksi']))->row_array();

?>
<div class="card-body" style="padding-left: 0px; padding-top: 0px;">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-stripped" id="DataLaporan">
                <thead style="background-color: grey; color : white; font-weight: bold;">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Tgl Pjm/Sls</th>
                        <th>Mobil</th>
                        <th>Jenis</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sum = 0;
                    foreach ($showListPesanan as $key => $value):
                        if ($value['tipe'] == 'kendaraan') {
                            $DetailKendaraan = $this->db->get_where("m_kendaraan", array('kendaraan_id' => $value['id_kendaraan']))->row_array();
                        } else {
                            $DetailKendaraan = $this->db->get_where("m_sopir", array('id_sopir' => $value['id_kendaraan']))->row_array();
                        }
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><a href="<?= base_url('dasboard/detail_transaksi'); ?>?kode_transaksi=<?php echo $value['kode_transaksi'] ?>"><?php echo $value['kode_transaksi'] ?></a></td>
                            <td><?php echo str_replace('00:00:00', '', $value['tgl_pinjam']); ?> /
                                <?php echo str_replace('00:00:00', '', $value['tgl_selesai']); ?>
                            </td>
                            <td><?php echo $DetailKendaraan['nama']; ?></td>
                            <td><?php echo $value['tipe']; ?></td>
                            <td><?php echo $value['qty']; ?></td>
                            <td>Rp. <?php echo number_format($value['harga']); ?></td>
                        </tr>
                        <?php
                        $sum += $value['harga'];
                    endforeach; ?>
                </tbody>
                <tfoot style="background-color: grey; color : white; font-weight: bold;">
                    <tr>
                        <td colspan="6" style="width: 100%;">Total Pendapatan</td>
                        <td nowrap>Rp. <?php echo number_format($sum); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        var table = $('#DataLaporan').DataTable({});
    </script>