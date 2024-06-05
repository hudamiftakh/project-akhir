<div class="card w-100 bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Whatsapp API KEY</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="./">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">API KEY Setting</li>
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

<style>
    .alert-danger {
        --bs-alert-color: var(--bs-danger-text-emphasis);
        --bs-alert-bg: var(--bs-danger-bg-subtle);
        --bs-alert-border-color: var(--bs-danger-border-subtle);
        --bs-alert-link-color: var(--bs-danger-text-emphasis);
    }
</style>
<form action="<?php echo base_url('api/generate_key'); ?>" method="post">
    <input type="hidden" value="<?= useraAuthData()['email']; ?>" name="email">
    <button type="submit" class="btn btn-danger">Generate</button>
</form>
<?php
$daKey = $this->db->get_where('users', array('email' => useraAuthData()['email']))->row_array();
?>
<br>
<?php echo $this->session->flashdata('notify'); ?>
<div class="input-group mb-3">
    <span class="input-group-text">API Key &nbsp &nbsp &nbsp &nbsp &nbsp</span>
    <input type="text" class="form-control input-lg" disabled value="<?= $daKey['api_key']; ?>">
</div>
<div class="input-group mb-3">
    <span class="input-group-text">Secret Key</span>
    <input type="text" class="form-control input-lg" disabled value="<?= $daKey['secret_key']; ?>">
</div>

<div class="input-group mb-3">
    <span class="input-group-text">Expired &nbsp &nbsp &nbsp &nbsp &nbsp</span>
    <input type="text" class="form-control input-lg" disabled value="20 Hari lagi">
</div>

<div class="alert alert-danger" role="alert">
    <strong>Fitur Berbayar - </strong> Lakukan pembayaran senilai <b>Rp 100.000/Bulan</b> untuk melakukan aktivasi
    <b>Apikey</b> dan <b>Secret Key</b> ke rekening ... .. .. . .
</div>