<?php $Auth = $this->session->userdata['username']; ?>
<div class="card w-100 bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Template Message Management</h4>
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
<div class="modal" id="show_whatsapp">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Preview Template Whatsapp</h4>
            </div>
            <div class="modal-body" style="height: 40vh; vertical-align: center;">
                <div class="page" style="vertical-align: center;">
                    <div class="marvel-device nexus5" style="width : 100% !important">
                        <div class="top-bar"></div>
                        <div class="sleep"></div>
                        <div class="volume"></div>
                        <div class="camera"></div>
                        <div class="screen">
                            <div class="screen-container">
                                <div class="status-bar">
                                    <div class="time"></div>
                                    <div class="battery">
                                        <i class="zmdi zmdi-battery"></i>
                                    </div>
                                    <div class="network">
                                        <i class="zmdi zmdi-network"></i>
                                    </div>
                                    <div class="wifi">
                                        <i class="zmdi zmdi-wifi-alt-2"></i>
                                    </div>
                                </div>
                                <div class="chat">
                                    <div class="chat-container">
                                        <div class="user-bar">
                                            <div class="back">
                                                <i class="zmdi zmdi-arrow-left"></i>
                                            </div>
                                            <div class="avatar">
                                                <img src="https://avatars2.githubusercontent.com/u/398893?s=128"
                                                    alt="Avatar">
                                            </div>
                                            <div class="name">
                                                <span>Fulan</span>
                                                <span class="status">online</span>
                                            </div>
                                            <div class="actions more">
                                                <i class="zmdi zmdi-more-vert"></i>
                                            </div>
                                            <div class="actions attachment">
                                                <i class="zmdi zmdi-attachment-alt"></i>
                                            </div>
                                            <div class="actions">
                                                <i class="zmdi zmdi-phone"></i>
                                            </div>
                                        </div>
                                        <div class="conversation"
                                            style="width: 100% !important; height : 30vh !important">
                                            <div class="conversation-container"
                                                style="width: 100% !important; height : 30vh !important">
                                                <br>
                                                <br>
                                                <div class="message received isi-whatsapp">
                                                    <span> Isi chatnya disini</span>
                                                    <span class="metadata"><span class="time"></span></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" style="border-radius: 4px;" data-bs-toggle="modal"
                    data-bs-target="#tambah_template">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="tambah_template">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Template Whatsapp</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="<?= base_url('broadcast/create_template'); ?>" id="submitFormTemplate"
                        enctype="multipart/form-data" method="POST">
                        <div class="mb-3 mt-3">
                            <label for="email" class="form-label">Template Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Isi judul disini" required>
                        </div>
                        <div class="mb-0 mt-0">
                            <label for="email" class="form-label">Message</label>
                            <div name="" cols="30" rows="10" id="whatsappEditor" placeholder="Isi chat"></div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email" class="form-label">Upload File</label>
                            <input type="file" class="form-control" name="file" placeholder="Gambar" required>
                        </div>
                        <div id="update"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="simpan" data-bs-toggle="modal" data-bs-target="#show_whatsapp"
                    class="btn btn-warning" style="border-radius: 3px;"><i class="fa fa-eye"></i> Preview</button>
                <button type="submit" name="simpan" class="btn btn-primary" style="border-radius: 4px;"
                    id="addTemplateButton"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger" style="border-radius: 4px;" data-bs-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$check_data = $this->db->get_where('template', array('email' => $Auth['email']))->num_rows();
if ($check_data <= 0): ?>
    <div class="card text-center">
        <div class="card-body">
            <h2>Template Whatsapp Management</h2>
            <br>
            <br>
            <img src="<?php echo base_url('assets/wabot.png') ?>" width="260px" alt="">
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-2"></div>
                <div class="col">
                    <div class="row">
                        <div class="col-md-3 d-grid gap-2"></div>
                        <div class="col-md-6 d-grid gap-2">
                            <button type="button" style="border-radius: 3px !important;"
                                class="btn waves-effect waves-light btn-lg  btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#tambah_template">
                                <i class="ti ti-plus"></i> Create New List Template
                            </button>
                        </div>
                        <div class="col-md-3 d-grid gap-2"></div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 pt-4 card-header" nowrap="">
            <div style="float: right;">
                <button id="addGroup" type="button" class="btn btn-outline-primary btn-lg rounded-end dropdown-toggle"
                    style="border-radius: 3px !important;" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ti ti-chat"></i> &nbsp Add Template
                </button>
                <div class="dropdown-menu" aria-labelledby="addGroup" style="">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#tambah_template">Add
                        Template</a>
                </div>
                <button id="actionGroup" type="button" class="btn btn-outline-primary btn-lg rounded-end dropdown-toggle"
                    style="border-radius: 3px !important;" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ti ti-list-details"></i> Action
                </button>
                <div class="dropdown-menu" aria-labelledby="actionGroup" style="">
                    <a class="dropdown-item" href="#" id="sendToServerButton">Delete Template</a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table border table-striped display" id="dataTemplate" style="width: 100%; table-layout:fixed">
                    <thead class="bg-success text-white">
                        <tr>
                            <th width="3%" style="vertical-align: top; padding-top: 30px !important;">
                                <div class="form-check form-check-lg py-2">
                                    <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                </div>
                            </th>
                            <th width="30%" nowrap="">Template Name</th>
                            <th width="10%" nowrap="">File</th>
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
        });
        $("#whatsappEditor").on('change keyup', function (e) {
            var text = $(".whatsapp-editor").html();
            $(".isi-whatsapp").html(text.replace('[name]', '<b>Nama User</b>'));
        });

    });
    var editor;
    $(function () {
        editor = $("#whatsappEditor").whatsappEditor({ content: '<p>Hallo !!! [name]</p>' });
    });
    function getWhatAppFormattedContent() {
        return false;
    }
    $('#submitFormTemplate').submit(function (event) {
        event.preventDefault();
        var button = document.getElementById('addTemplateButton');
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        button.disabled = true;
        var message = $(".whatsapp-editor").html();
        var message_wahtsapp = editor.getFormattedContent();
        var formData = new FormData(document.getElementById("submitFormTemplate"));
        formData.append('message', message);
        formData.append('message_whatsap', message_wahtsapp);
        $.ajax({
            type: "POST",
            url: "<?= base_url('broadcast/create-template'); ?>",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 'success') {
                    Swal.fire({
                        title: "Saved!",
                        text: "Your template message has been saved.",
                        icon: "success",
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        Swal.close();
                        window.location = "<?= base_url('broadcast/template-message'); ?>";
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

    var table = $('#dataTemplate').DataTable({
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
            "url": "<?php echo base_url('broadcast/show-template'); ?>",
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
                    return `<button type="button" class="btn d-flex bg-success-subtle w-100 d-block ">
                                <h5><i class="fa fa-rss" aria-hidden="true"></i> ${row.name}</h5>
                            </button>`;
                }
            },
            {
                "data": "file", "className": "dt-center",
                render: function (data, type, row, meta) {
                    return `<button class='btn btn-link' onclick="downloadFile('${row.file}');"><i class="fa fa-cloud-download text-success" style="font-size:25px"></i></button>`;
                }
            },
            { "data": "create_at" },
            {
                "data": 'id', "sortable": true, "className": "dt-center nowrap",
                render: function (data, type, row, meta) {
                    return `
                        <button class='btn btn-outline-warning' onclick="updateContact('${row.id}');"/><i class='fa fa-eye'></i></button>
                        <button class='btn btn-outline-primary'  onclick="updateTemplate('${row}');"/><i class='fa fa-edit'></i></button>
                        <button class='btn btn-outline-danger' onclick="deleteTemplate('${row.id}');"/><i class='fa fa-trash'></i></button>
                    `;
                }
            },
        ],
    });

    function updateTemplate(data) {
        console.log(JSON.stringify(data));
        $("#tambah_template").modal('show');
    }

    function deleteTemplate(id) {
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
                    url: "<?= base_url('broadcast/delete-template-message') ?>",
                    data: { id: id },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 'success') {
                            setTimeout(() => {
                                window.location = "<?= base_url('broadcast/template-message'); ?>";
                            }, 1500);
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your template has been deleted.",
                                icon: "success"
                            });
                        } else {
                            setTimeout(() => {
                                window.location = "<?= base_url('broadcast/template-message'); ?>";
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

    function downloadFile(file) { 
        console.log(file);
        window.location='<?php echo base_url('./storage/') ?>'+file;
     }
</script>