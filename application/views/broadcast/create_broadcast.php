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
                <h4 class="fw-semibold mb-8">Create Broadcast</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Broadcast</li>
                        <li class="breadcrumb-item" aria-current="page">Create Broadcast</li>
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
        <h4>Create Broadcast</h4>
    </div>
    <div class="card-body">
        <form action="#" id="saveBroadcast" method="POST">
        <div class="form-group">
                <label class="form-label" for="validationServer03">Broadcast Name</label>
                <input type="text" class="form-control" name="name" placeholder="Broadcast Name" required>
            </div><br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">From Number</label>
                <select class="form-control" name="session" required>
                    <option value="">From Number</option>
                    <?php
                    $result = $this->db->get_where("sessions", array('status' => 'aktif', 'email' => $Auth['email'], 'is_connected' => 'connect'))->result_array();
                    foreach ($result as $key => $value) { ?>
                        <option value="<?= $value['number'] ?>">
                            &#x1F4F1;
                            <?= $value['number'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div><br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Group Contact</label>
                <div id="group-list">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" class="form-control search" placeholder="Search group contact">
                                <label type="label" class="btn btn-outline-primary sort asc" data-sort="name">
                                    <div style="padding-top: 5px !important;">
                                        <input type="checkbox" style="width: 20px; height : 20px;" name=""
                                            id="checkAll">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <ul class="list" style="padding-top: 5px;">
                        <?php
                        $Auth = $this->session->userdata['username'];
                        $result = $this->db->order_by("a.create_at DESC")->select("a.id, (SELECT COUNT(*) FROM contact as b WHERE a.id = b.group_id) as participant, a.name,  DATE_FORMAT(a.create_at, '%W, %d %M %Y %H:%i:%s') as create_at")->get_where("group as a", array('email' => $Auth['email']))->result_array();
                        foreach ($result as $key => $value): ?>
                            <li style="padding-top: 5px;">
                                <label type="label" class="btn d-flex bg-primary-subtle w-100 d-block text-primary name"
                                    style="padding-top: 11px; padding: 11px;">
                                    <input type="checkbox" style="width: 18px; height : 18px;"
                                        value="<?php echo $value['id']; ?>" class="check"> &nbsp
                                    <?php echo $value['name']; ?>
                                    <span class="badge ms-auto text-bg-primary">
                                        <?php echo $value['participant']; ?>
                                    </span>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- <ul class="pagination"></ul> -->
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Template Message</label>
                <select class="form-control" name="template" required id="templateMessage">
                    <option value="" data-template="">Select Template</option>
                    <?php
                    $result_template = $this->db->get_where("template", array('email' => $Auth['email']))->result_array();
                    foreach ($result_template as $key => $value) { ?>
                        <option value="<?= $value['id'] ?>"
                            data-template="<?php echo htmlspecialchars($value['message']); ?>">
                            <?= $value['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <br>
            <div class="form-group">
                <div class="mb-0 mt-0">
                    <label for="email" class="form-label">Preview Message</label>
                    <div name="" cols="30" rows="10" id="whatsappEditor" placeholder="Isi chat"></div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="form-label" for="validationServer03">Delay</label>
                <select class="form-control" name="delay" required>
                    <option value="1000">1 Detik</option>
                    <option value="2000">2 Detik</option>
                    <option value="3000">3 Detaik</option>
                    <option value="5000">5 Detik</option>
                    <option value="10000">10 Detik</option>
                    <option value="20000">20 Detik</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <button class="btn btn-outline-danger">Kembali</button>
                <button class="btn btn-outline-primary" id="addBroadcastButton">Simpan</button>
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
        $('#saveBroadcast').submit(function (event) {
            event.preventDefault();
            var button = document.getElementById('addBroadcastButton');
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
            var formData = new FormData(document.getElementById("saveBroadcast"));
            formData.append('message', message);
            formData.append('message_whatsap', message_wahtsapp);
            formData.append('template_id', templateMessage);
            formData.append('group_id', selectedValues);
            $.ajax({
                type: "POST",
                url: "<?= base_url('broadcast/save-broadcast'); ?>",
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
                            window.location = "<?= base_url('broadcast/broadcast'); ?>";
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