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
                <h4 class="fw-semibold mb-8">Create Sopir</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Sopir</li>
                        <li class="breadcrumb-item" aria-current="page">Create Sopir</li>
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
if (!empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $datane = $this->db->get_where('m_sopir', array('id_sopir' => $id))->row_array();
}
?>
<div class="card">
    <div class="card-header">
        <h4>Create Sopir</h4>
    </div>
    <div class="card-body">
        <form action="<?php echo base_url('dashboard/save_sopir'); ?>" id="saveKendaraan" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <label class="form-label" for="validationServer03">Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama Sopir"
                    value="<?= $datane['nama']; ?>" required>
            </div><br>
            <?php if (!empty($_REQUEST['id'])): ?>
                <input type="hidden" class="form-control" name="id" placeholder="Kendaraan Name"
                    value="<?= $_REQUEST['id']; ?>" required>
            <?php endif; ?>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Harga</label>
                <input type="number" class="form-control" name="harga" placeholder="Harga"
                    value="<?= $datane['harga']; ?>" required>
            </div><br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Deskripsi</label>
                <textarea name="deskripsi" cols="30" rows="10" class="form-control"
                    placeholder="Deskripsi"><?= $datane['deskripsi']; ?></textarea>
            </div>
            <br>
            <input type="file" name="file" class="form-control" placeholder="KTP">
            <?php if ($datane['foto'] != ''): ?>
            <input type="hidden" name="file_lama" class="form-control" value="<?php echo $datane['foto']; ?>" placeholder="Foto lama">
                <image src="<?php echo base_url('storage/sopir'); ?>/<?php echo $datane['foto']; ?>" width="100px" height="100px"></image>
            <?php endif; ?>
            <br>
            <br>
            <div class="form-group">
                <a href="sopir" class="btn btn-outline-danger">Kembali</a>
                <button class="btn btn-outline-primary" name="simpan" id="addSopirButton">Simpan</button>
            </div>
        </form>
    </div>
</div>


<script>
    var options = {
        valueNames: ['name']
    };
    var hackerList = new List('group-list', options);
    var editor;
    $(function () {
        editor = $("#whatsappEditor").whatsappEditor({ content: '<p>Hallo !!! [name]</p>' });
    });

    $(document).ready(function () {
        $('#saveKendaraan').submit(function (event) {
            event.preventDefault();
            var button = document.getElementById('addSopirButton');
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            var formData = new FormData(document.getElementById("saveKendaraan"));
            $.ajax({
                type: "POST",
                url: "<?= base_url('dasboard/save_sopir'); ?>",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            title: "Saved!",
                            text: "Data berhasil disimpan",
                            icon: "success",
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            Swal.close();
                            window.location = "<?= base_url('sopir'); ?>";
                        }, 1500);
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.msg,
                            icon: "error"
                        });
                        button.disabled = false;
                        button.innerHTML = 'Simpan';
                    }
                }
            });
        });
    });

</script>