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
                <h4 class="fw-semibold mb-8">Create Kendaraan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Kendaraan</li>
                        <li class="breadcrumb-item" aria-current="page">Create Kendaraan</li>
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
if(!empty($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    $datane = $this->db->get_where('m_kendaraan',array('kendaraan_id'=>$id))->row_array();
    // var_dump($datane);  
}
?>
<div class="card">
    <div class="card-header">
        <h4>Create Kendaraan</h4>
    </div>
    <div class="card-body">
        <form action="<?php echo base_url('dashboard/create_kendaraan'); ?>" id="saveKendaraan" method="POST">
            <div class="form-group">
                <label class="form-label" for="validationServer03">Kendaraan Name</label>
                <input type="text" class="form-control" name="nama" placeholder="Kendaraan Name" value="<?=$datane['nama'];?>" required>
            </div><br>
            <?php if(!empty($_REQUEST['id'])) : ?>
                <input type="hidden" class="form-control" name="kendaraan_id" placeholder="Kendaraan Name" value="<?=$_REQUEST['id'];?>" required>
            <?php endif; ?>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Harga</label>
                <input type="number" class="form-control" name="harga" placeholder="Harga" value="<?=$datane['harga'];?>" required>
            </div><br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Jenis Tranmisi</label>
                <select class="form-control" name="jenis_transmisi" required>
                    <option value="manual" <?php echo ($datane['jenis_transmisi']=='manual') ? "selected": "";?>>Manual</option>
                    <option value="matik" <?php echo ($datane['jenis_transmisi']=='matik') ? "selected": "";?>>Matik</option>
                </select>
            </div><br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Jumlah Unit</label>
                <input type="text" class="form-control" name="stock" value="<?=$datane['stock'];?>" placeholder="Jumlah Unit" required>
            </div>
            <br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Deskripsi</label>
                <textarea name="deskripsi" cols="30" rows="10" class="form-control" placeholder="Deskripsi"><?=$datane['deskripsi'];?></textarea>
            </div>
            <br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Merek</label>
                <select class="form-control" name="merek" required>
                    <option value="Toyota" <?php echo ($datane['merek']=='Toyota') ? "selected": "";?>>Toyota</option>
                    <option value="Mitsubitsi" <?php echo ($datane['merek']=='Toyota') ? "selected": "";?>>Mitsubitsi</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">BBM</label>
                <select class="form-control" name="bbm" required>
                    <option value="Bensin" <?php echo ($datane['bbm']=='Bensin') ? "selected": "";?>>Bensin</option>
                    <option value="Solar" <?php echo ($datane['bbm']=='Solar') ? "selected": "";?>>Solar</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <a href="kendaraan" class="btn btn-outline-danger">Kembali</a>
                <button class="btn btn-outline-primary" id="addKendaraanButton">Simpan</button>
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
        $('select[name="template"]').change(function () {
            var selectedTemplate = $(this).find('option:selected').data('template');
            $(".whatsapp-editor").html(selectedTemplate);
        });

        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });
        $('#saveKendaraan').submit(function (event) {
            event.preventDefault();
            var button = document.getElementById('addKendaraanButton');
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            // button.disabled = true;
            var selectedValues = [];
            $('.check:checked').each(function () {
                selectedValues.push($(this).val());
            });
            console.log(selectedValues);
            var message = $(".whatsapp-editor").html();
            var templateMessage = $("#templateMessage").val();
            var message_wahtsapp = editor.getFormattedContent();
            var formData = new FormData(document.getElementById("saveKendaraan"));
            formData.append('message', message);
            formData.append('message_whatsap', message_wahtsapp);
            formData.append('template_id', templateMessage);
            formData.append('group_id', selectedValues);
            $.ajax({
                type: "POST",
                url: "<?= base_url('dasboard/create_kendaraan'); ?>",
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
                            window.location = "<?= base_url('kendaraan'); ?>";
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