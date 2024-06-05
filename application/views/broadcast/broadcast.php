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
                <h4 class="fw-semibold mb-8">Broadcast Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Broadcast</li>
                        <li class="breadcrumb-item" aria-current="page">Broadcast Management</li>
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
<div class="modal" id="tambah_nomor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Group Contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('broadcast/create_group'); ?>" id="submitFormGroup" method="POST">
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Grup Name</label>
                        <input type="text" class="form-control" name="group" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="simpan" class="btn btn-primary" id="addGroupButton">Simpan</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="grap_from_wa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Get Group Contact From Whatsapp</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="#" onsubmit="getGroupWhatsapp(event)" id="saveGroup" method="POST">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">From Number</label>
                        <select class="form-control" name="session" required>
                            <option value="">From Number</option>
                            <?php
                            $result = $this->db->get_where("sessions", array('status' => 'aktif', 'email' => $Auth['email'], 'is_connected' => 'connect'))->result_array();
                            foreach ($result as $key => $value) { ?>
                                <option value="<?= $value['number'] ?>">
                                    <?= $value['number'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="simpan" id="simpanButton" class="btn btn-primary">Grab Now</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="fs-7">120</h2>
                        <h6 class="fw-medium text-info mb-0">Total Broadcast</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-info display-6"><i class="ti ti-file-text"></i></span>
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
                        <h2 class="fs-7">150</h2>
                        <h6 class="fw-medium text-primary mb-0">Contact</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-primary display-6"><img
                                src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-user-male.svg"
                                alt=""></span>
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
                        <h2 class="fs-7">450</h2>
                        <h6 class="fw-medium text-success mb-0">Success Sent</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-success display-6"><i class="ti ti-checkup-list"></i></span>
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
                        <h2 class="fs-7">100</h2>
                        <h6 class="fw-medium text-danger mb-0">Failed</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-danger display-6"><img
                                src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-speech-bubble.svg"
                                alt=""></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$check_data = $this->db->get_where('broadcast', array('email' => $Auth['email']))->num_rows();
if ($check_data <= 0): ?>
    <div class="card text-center">
        <div class="card-body">
            <h2>Broadcast Whatsapp Management</h2>
            <br>
            <br>
            <img src="<?php echo base_url('assets/wabot.png') ?>" width="260px" alt="">
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-3"></div>
                <div class="col">
                    <div class="row">
                        <div class="col-md-12 d-grid gap-6">
                            <a href="<?php echo base_url('broadcast/create-broadcast'); ?>"
                                style="border-radius: 3px !important;"
                                class="btn waves-effect waves-light btn-lg  btn-outline-primary">
                                <i class="ti ti-plus"></i> Create New Broadcast
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
                <a href="<?php echo base_url('broadcast/create-broadcast'); ?>"
                    class="btn btn-outline-primary btn-lg rounded-end" style="border-radius: 3px !important;">
                    <i class="ti ti-brand-whatsapp"></i> &nbsp Create Broadcast
                </a>

                <button id="actionGroup" type="button" class="btn btn-outline-primary btn-lg rounded-end dropdown-toggle"
                    style="border-radius: 3px !important;" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ti ti-list-details"></i> Action
                </button>
                <div class="dropdown-menu" aria-labelledby="actionGroup" style="">
                    <a class="dropdown-item" href="#" id="sendToServerButton">Delete Group</a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table border table-striped display" id="DataBroadcast"
                    style="width: 100%; table-layout:fixed">
                    <thead class="bg-warning text-white">
                        <tr>
                            <th width="3%" style="vertical-align: top; padding-top: 30px !important;">
                                <div class="form-check form-check-lg py-2">
                                    <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                </div>
                            </th>
                            <th width="30%" nowrap="">Broadcast Name</th>
                            <th width="30%" nowrap="">Template Name</th>
                            <th width="10%" nowrap="">Success</th>
                            <th width="10%" nowrap="">Receiver</th>
                            <th width="10%" nowrap="">%</th>
                            <th width="10%" nowrap="">Created At</th>
                            <th nowrap="" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
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

    var table = $('#DataBroadcast').DataTable({
        "processing": true,
        "responsive": false,
        "serverSide": true,
        "bDestroy": true,
        "scrollY": false,
        "scrollX": true,
        "table-layout": "fixed",
        "ordering": true,
        "order": [[4, 'desc']],
        "ajax":
        {
            "url": "<?php echo base_url('broadcast/get-broadcast'); ?>",
            "type": "POST",
            "async": false,
            "cache": false,
        },
        "deferRender": true,
        "aLengthMenu": [[10, 50, 100], [10, 50, 100]],
        "columns": [
            {
                "data": 'id', "sortable": false,
                render: function (data, type, row, meta) {
                    return `<div class="form-check py-2"><input class="form-check-input input-lg success check" type="checkbox" value="${row.id}">`;
                }
            },
            {
                "data": "name",
                render: function (data, type, row, meta) {
                    return `<a href='<?= base_url('broadcast/contact-group/') ?>${row.id}' type="button" class="btn d-flex bg-primary-subtle d-block text-primary"><h5>${row.name}</h5></a>`;
                }
            },
            {
                "data": "template_name",
                render: function (data, type, row, meta) {
                    return `<label class="btn d-flex bg-info-subtle d-block text-primary"><h5>${row.template_name}</h5></label>`;
                }
            },
            { "data": "total_success", "className": "dt-center nowrap" },
            { "data": "total_contact", "className": "dt-center nowrap" },
            {
                "data": "total_contact", "className": "dt-center nowrap",
                render: function (data, type, row, meta) {
                    return `<b>${(row.total_success / row.total_contact * 100).toFixed(2)}</b>`;
                }
            },
            {
                "data": "create_at",
                render: function (data, type, row, meta) {
                    return `${row.create_at}`;
                }
            },
            {
                "data": 'id', "sortable": true, "className": "dt-center nowrap",
                render: function (data, type, row, meta) {
                    return `
                        <button class='btn btn-outline-primary' onclick="updateGroup('${row.id}');"/><i class='fa fa-edit'></i></button>
                        <button class='btn btn-outline-danger' onclick="deleteGroup('${row.id}');"/><i class='fa fa-trash'></i></button>
                    `;
                }
            },
        ],
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