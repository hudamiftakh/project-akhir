<?php $Auth = $this->session->userdata['username']; ?>
<style>
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc,
    table.dataTable thead>tr>th.sorting_asc_disabled,
    table.dataTable thead>tr>th.sorting_desc_disabled,
    table.dataTable thead>tr>td.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>td.sorting_asc_disabled,
    table.dataTable thead>tr>td.sorting_desc_disabled {
        cursor: pointer;
        position: relative;
        /* padding-right: 26px; */
        padding: 30px;
    }
</style>
<div class="card w-100 bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Detail Transaksi</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                        <li class="breadcrumb-item" aria-current="page">Dashboard Management Transaksi</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="<?php echo base_url(); ?>dist/images/backgrounds/welcome-bg.svg" alt=""
                        class="img-fluid mb-n4" />
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$showListPesanan = $this->db->get_where("m_order_detail", array('kode_transaksi' => $_REQUEST['kode_transaksi']))->result_array();
$showDetailPesanan = $this->db->get_where("m_order", array('nomor_order' => $_REQUEST['kode_transaksi']))->row_array();

?>
<div class="card-body" style="padding-left: 0px; padding-top: 0px;">
    <div class="row">
        <?php $url = base_url('transaksi'); ?>
        <div class="col-lg-12">
            <table class="table table-stripped">
                <tr>
                    <td class="bg-warning text-white" width="1px" nowrap="">Kode Transaksi</td>
                    <td>: <?php echo $showDetailPesanan['nomor_order']; ?></td>
                </tr>
                <tr>
                    <td class="bg-warning text-white">Nama</td>
                    <td>: <?php echo $showDetailPesanan['nama']; ?></td>
                </tr>
                <tr>
                    <td class="bg-warning text-white">Whatsapp</td>
                    <td>: <?php echo $showDetailPesanan['whatsapp']; ?></td>
                </tr>
                <tr>
                    <td class="bg-warning text-white">Jenis Pembayaran</td>
                    <td>: <?php echo $showDetailPesanan['jenis_pembayaran']; ?></td>
                </tr>
                <?php if ($showDetailPesanan['jenis_pembayaran'] == 'transfer' and $showDetailPesanan['struk_pembayaran'] != ''): ?>
                    <tr>
                        <td nowrap class="bg-warning text-white">Struk Pembayaran</td>
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
                        <th>Mobil</th>
                        <th>Jenis</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
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
                    <tr>
                        <td colspan="4">Total</td>
                        <td>Rp. <?php echo number_format($sum); ?></td>
                    </tr>
                </tbody>

            </table>


        </div>
    </div>