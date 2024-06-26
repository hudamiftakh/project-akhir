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
                <h4 class="fw-semibold mb-8">Manajemen Sopir</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                        <li class="breadcrumb-item" aria-current="page">Dashboard Management Sopir</li>
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
<?php if (isset($_REQUEST['hapus'])) {
    $id = $_REQUEST['id'];
    $result = $this->db->where(array('id_sopir' => $id))->delete("m_sopir");
    if ($result) {
        unlink('./storage/sopir/'.$_REQUEST['foto']);
        echo "<script>
            alert('Data berhasil dihapus');
        </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus');
        </script>";
    }
} ?>
<?php
$check_data = $this->db->get('m_sopir')->num_rows();
if ($check_data <= 0): ?>
    <div class="card text-center">
        <div class="card-body">
            <h2>Manajemen Sopir</h2>
            <br>
            <br>
            <img src="<?php echo base_url('assets/logo.png') ?>" width="260px" alt="">
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-3"></div>
                <div class="col">
                    <div class="row">
                        <div class="col-md-12 d-grid gap-6">
                            <a href="<?php echo base_url('create-sopir'); ?>" style="border-radius: 3px !important;"
                                class="btn waves-effect waves-light btn-lg  btn-outline-primary">
                                <i class="ti ti-plus"></i> Buat Sopir
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>

    </div>
<?php else: ?>
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 pt-4 card-header" nowrap="">
            <div style="float: right;">
                <a href="<?php echo base_url('create-sopir'); ?>" class="btn btn-outline-primary btn-lg rounded-end"
                    style="border-radius: 3px !important;">
                    <i class="ti ti-car"></i> &nbsp Buat Sopir
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table border table-striped display" id="DataSopir" style="width: 100%; table-layout:fixed">
                    <thead class="bg-warning text-white">
                        <tr>
                            <th width="3%" style="vertical-align: top; padding-top: 30px !important;">#</th>
                            <th width="10%" nowrap="">Foto</th>
                            <th width="10%" nowrap="">Nama</th>
                            <th width="10%" nowrap="">Harga / hari</th>
                            <th width="10%" nowrap="">Deskripsi</th>
                            <th width="10%" nowrap="">Created At</th>
                            <th nowrap="" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result_data = $this->db->get('m_sopir')->result_array();
                        $no = 1;
                        foreach ($result_data as $key => $data):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <img src="<?php echo base_url('storage/sopir'); ?>/<?php echo $data['foto']; ?>"
                                        class="rounded-circle" alt="Cinque Terre" width="120" height="120">
                                </td>
                                <td><?php echo $data['nama'] ?></td>
                                <td>Rp. <?php echo number_format($data['harga'], 0, ',', '.') ?></td>
                                <td><?php echo $data['deskripsi'] ?></td>
                                <td><?php echo $data['create_at'] ?></td>
                                <td nowrap="">
                                    <form action="<?php echo base_url('sopir'); ?>" method="POST">
                                        <input type="hidden" name="id" value="<?= $data['id_sopir'] ?>">
                                        <input type="hidden" name="foto" value="<?= $data['foto'] ?>">
                                        <a href="<?= base_url('create-sopir'); ?>?id=<?php echo $data['id_sopir'] ?>"
                                            class="btn btn-outline-primary"><i class="fa fa-pencil"></i></a>
                                        <button type="submit" name="hapus" class="btn btn-outline-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function () {
        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });
        $('#sendToServerButton').click(function () {
            var selectedValues = [];
            $('.check:checked').each(function () {
                selectedValues.push($(this).val());
            });
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('broadcast/delete-group-check') ?>",
                        data: { id: selectedValues },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == 'success') {
                                setTimeout(() => {
                                    window.location = "<?= base_url('broadcast/group_contact'); ?>";
                                }, 1500);
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your group has been deleted.",
                                    icon: "success"
                                });
                            } else {
                                setTimeout(() => {
                                    window.location = "<?= base_url('broadcast/group_contact'); ?>";
                                }, 1500);

                                Swal.fire({
                                    title: "Error!",
                                    text: "Server error",
                                    icon: "error"
                                });
                            }
                        }
                    });
                }
            });
        });
    });

    var table = $('#DataSopir').DataTable({
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ]
    });

    function deleteGroup(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('broadcast/delete-group') ?>",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 'success') {
                            setTimeout(() => {
                                window.location = "<?= base_url('broadcast/group_contact'); ?>";
                            }, 1500);
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your group has been deleted.",
                                icon: "success"
                            });
                        } else {
                            setTimeout(() => {
                                // window.location = "<?= base_url('broadcast/group_contact'); ?>";
                            }, 1500);

                            Swal.fire({
                                title: "Error!",
                                text: "Server error",
                                icon: "error"
                            });
                        }
                    }
                });
            }
        });
    }

</script>