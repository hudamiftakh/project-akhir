<?php
$Auth = $this->session->userdata['username'];
$id = $this->uri->segment(3);
$group = $this->db->get_where('group', array('id' => $id))->row_array();
?>
<div class="card w-100 bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Group Contact Participant</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Group Contact Management</li>
                        <li class="breadcrumb-item" aria-current="page">Group Contact</li>
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

<div class="modal" id="addContact">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Contact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('broadcast/create-contact'); ?>" id="addContactFrom" method="POST">
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Number Whatsapp</label>
                        <input type="number" class="form-control" name="number" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="simpan" id="addContactButton" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 pt-4 card-header" nowrap="">
        <div style="float: left;">
            <label type="label" class="btn btn-lg d-flex bg-danger-subtle w-100 d-block text-black ">Group Name :
                <?php echo $group['name']; ?>
            </label>
        </div>
        <div style="float: right;">
            <button id="addGroup" type="button" class="btn btn-outline-primary btn-lg rounded-end dropdown-toggle"
                style="border-radius: 3px !important;" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-users"></i> &nbsp Add Contact
            </button>
            <div class="dropdown-menu" aria-labelledby="addGroup" style="">
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addContact">Add Contact</a>
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#grap_from_wa" href="#">Upload File
                    Excel</a>
            </div>
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
            <table class="table border table-striped display" style="width: 100%" id="dataContact">
                <thead class="bg-success text-white">
                    <tr>
                        <th width="3%" style="vertical-align: top; padding-top: 30px !important;">
                            <div class="form-check form-check-lg py-2">
                                <input class="form-check-input" type="checkbox" value="" id="checkAll">
                            </div>
                        </th>
                        <th>Contact</th>
                        <th>Created At</th>
                        <th nowrap="">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
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
                        url: "<?= base_url('broadcast/delete-contact-check') ?>",
                        data: { id: selectedValues },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status == 'success') {
                                setTimeout(() => {
                                    window.location = "<?= base_url('broadcast/contact-group/' . $id); ?>";
                                }, 1500);
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your group has been deleted.",
                                    icon: "success"
                                });
                            } else {
                                setTimeout(() => {
                                    window.location = "<?= base_url('broadcast/contact-group/' . $id); ?>";
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
    $('#addContactFrom').submit(function (event) {
        event.preventDefault();
        var button = document.getElementById('addContactButton');
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        button.disabled = true;
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('broadcast/create-contact/' . $id); ?>', // URL dari atribut action form
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    Swal.fire({
                        title: "Saved!",
                        text: "Your Contact Number has been saved.",
                        icon: "success",
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        Swal.close();
                        window.location = "<?= base_url('broadcast/contact-group/' . $id); ?>";
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
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: "Error!",
                    text: "Request server error",
                    icon: "error"
                });
                button.disabled = false;
                button.innerHTML = 'Simpan';
            }
        });
    });
    var table = $('#dataContact').DataTable({
        "processing": true,
        "responsive": false,
        "serverSide": true,
        "bDestroy": true,
        "scrollY": false,
        "scrollX": true,
        "table-layout": "fixed",
        "ordering": true,
        "order": [[3, 'desc']],
        "ajax":
        {
            "url": "<?php echo base_url('broadcast/get-contact-group/') . $id; ?>",
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
            { "data": "contact" },
            { "data": "create_at" },
            {
                "data": 'id', "sortable": true, "className": "dt-center",
                render: function (data, type, row, meta) {
                    return `
                        <button class='btn btn-outline-primary' onclick="updateContact('${row.id}');"/><i class='fa fa-edit'></i></button>
                        <button class='btn btn-outline-danger' onclick="deleteContact('${row.id}');"/><i class='fa fa-trash'></i></button>
                    `;
                }
            },
        ],
    });

    function deleteContact(id) {
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
                    url: "<?= base_url('broadcast/delete-contact') ?>",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 'success') {
                            setTimeout(() => {
                                window.location = "<?= base_url('broadcast/contact-group/' . $id); ?>";
                            }, 1500);
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your contact has been deleted.",
                                icon: "success"
                            });
                        } else {
                            setTimeout(() => {
                                window.location = "<?= base_url('broadcast/contact-group/' . $id); ?>";
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