<br>
<?php 
$profile = $this->db->get_where('m_user',array('id_user', $_REQUEST['id_user']))->row_array();
// var_dump($profile);
?>
<div style="padding-left: 40px;">
    <table class="table table-striped" style="width: 100%;">
        <tr>
            <td colspan="2">
                <left><img src="img/icon.png" alt="" style="width: 100px; height: 100px;"></left>
            </td>
        </tr>
        <tr>
            <td nowrap="" width="1px">Nama</td>
            <td>: <?php echo $profile['nama']; ?></td>
        </tr>
        <tr>
            <td nowrap="" width="1px">Email</td>
            <td>: <?php echo $profile['email']; ?></td>
        </tr>
        <tr>
            <td nowrap="" width="1px">Hp</td>
            <td>: <?php echo $profile['hp']; ?></td>
        </tr>
        <tr>
            <td nowrap="" width="1px">Username</td>
            <td>: <?php echo $profile['username']; ?></td>
        </tr>
        <tr>
            <td nowrap="" width="1px">Alamat</td>
            <td>: <?php echo $profile['alamat']; ?></td>
        </tr>
    </table>
</div>