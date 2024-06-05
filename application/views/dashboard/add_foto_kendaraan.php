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
                <h4 class="fw-semibold mb-8">Upload Foto Kendaraan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Kendaraan</li>
                        <li class="breadcrumb-item" aria-current="page">Upload Foto Kendaraan</li>
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
<div class="card">
    <div class="card-header">
        <h4>Upload Kendaraan</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo base_url('dasboard/do_upload_foto_kendaraan') ?>"
            enctype="multipart/form-data">
            <?php if (!empty($_REQUEST['id'])): ?>
                <input type="hidden" class="form-control" name="kendaraan_id" placeholder="Kendaraan Name"
                    value="<?= $_REQUEST['id']; ?>" required>
            <?php endif; ?>
            <table>
                <tr>
                    <td width="75%" style="padding: 10px;"><input type="file" class="form-control" name="foto" required
                            accept="image/png, image/gif, image/jpeg"></td>
                    <td style="padding: 10px;"><button class="btn btn-primary"><i class="fa fa-upload"></i> Upload Foto
                            Kendaraan</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4>Foto Kendaraan</h4>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <?php
                $result = $this->db->get_where("m_foto_kendaraan", array('kendaraan_id' => $_REQUEST['id']))->result_array();
                foreach ($result as $key => $value):
                    ?>
                    <div class="col-lg-4">
                        <div class="card overflow-hidden hover-img">
                            <div class="position-relative">
                                <a href="javascript:void(0)">
                                    <img src="<?php echo base_url('storage/' . $value['file_foto']) ?>" class="card-img-top"
                                        alt="modernize-img">
                                </a>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-4">
                                    <form action="<?php echo base_url('dasboard/do_delete_foto'); ?>" method="POST">
                                        <input type="hidden" name="kendaraan_id" value="<?php echo $_REQUEST['id']; ?>">
                                        <input type="hidden" name="id_foto" value="<?php echo $value['foto_id']; ?>">
                                        <input type="hidden" name="foto_lama" value="<?php echo $value['file_foto']; ?>">
                                        <button type="submit" class="btn btn-block d-flex align-items-center gap-2"
                                            onclick="return confirm('Apakah anda yakin ?')">
                                            <i class="ti ti-trash text-dark fs-5"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>