<?php
defined('BASEPATH') or exit('No direct script access allowed');

class api extends CI_Controller
{

    public function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('Googleplus');
        $this->load->model('M_Datatables');
    }
    public function show_mobil()
    {
        $this->load->view('api/show_mobil');
    }
    public function detail_mobil()
    {
        $this->load->view('api/detail_mobil');
    }
    
    public function show_tanggal_booking()
    {
        $this->load->view('api/show_tanggal_booking');
    }
    
    public function proses_booking()
    {
        $this->load->view('api/proses_booking');
    }
    public function addToCart()
    {
        var_dump($_REQUEST['data']);
        $id_user = $_REQUEST['data'][3];
        $id_kendaraan = $_REQUEST['data'][0];
        $harga = $_REQUEST['data'][4];
        $qty = (!empty($_REQUEST['qty'])) ? $_REQUEST['qty'] : 1;
        $tgl_pinjam = $_REQUEST['data'][1] . ":00";
        $tgl_selesai = $_REQUEST['data'][2] . ":00";
        var_dump($harga);

        $cek = $this->db->query("SELECT * FROM m_keranjang_belanja WHERE id_kendaraan='" . $id_kendaraan . "' AND id_user='" . $id_user . "'");
        $cek_tot = $cek->num_rows();
        $cekhasil = $cek->row_array();
        if ($cek_tot >= 1) {
            $qty_update = $cekhasil['qty'] + $qty;
            $total = ($qty_update * $cekhasil['harga']);
            $sql = "UPDATE m_keranjang_belanja SET qty='" . $qty_update . "', total='" . $total . "' WHERE id_kendaraan='" . $id_kendaraan . "' AND id_user='" . $id_user . "' ";
        } elseif ($cek_tot < 1) {
            $total = $harga * $qty;
            $sql = "INSERT INTO m_keranjang_belanja (
                id_kendaraan,
                id_user,
                harga,
                qty,
                total, 
                tgl_pinjam, 
                tgl_selesai, 
                date_created) 
                VALUES (
                '".$id_kendaraan."',
                '".$id_user."',
                '".$harga."',
                '".$qty."',
                '".$total."',
                '".$tgl_pinjam."',
                '".$tgl_selesai."',
                '".date('Y-m-d H:i:s')."'
                )";
        }
        $save = $this->db->query($sql);
        if ($save) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'gagal';
        }

        echo json_encode($data);
    }
    
    public function saveOrder()
    {
        try {
            $tgl_awal = $_REQUEST['tgl_awal'];
            $tgl_akhir = $_REQUEST['tgl_akhir'];

            $tgl1 = strtotime($_REQUEST['tgl_awal']);
            $tgl2 = strtotime($_REQUEST['tgl_akhir']);
            $jarak = $tgl2 - $tgl1;
            $total_hari = $jarak / 60 / 60 / 24;

            $nama = $_REQUEST['nama'];
            $user_id = $_REQUEST['user_id'];
            $whatsapp = $_REQUEST['whatsapp'];
            $alamat = $_REQUEST['alamat'];
            $kendaraan_id = $_REQUEST['kendaraan_id'];
            $jenis_pembayaran = $_REQUEST['jenis_pembayaran'];
            $config['upload_path'] = './storage/ktp/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 80000;
            $config['max_width'] = 10000;
            $config['remove_space'] = 10000;
            $config['encrypt_name'] = 10000;
            $file_lama = $_POST['file_lama'];
            $this->load->library('upload', $config);
            if ($_FILES['file']['name'] != "") {
                if (!$this->upload->do_upload('file')) {
                    echo json_encode(array('status' => 'error', 'msg' => $this->upload->display_errors()));
                } else {
                    $upload_data = $this->upload->data();
                    $file = (empty($upload_data['file_name'])) ? "-" : $upload_data['file_name'];
                    unlink('./storage/ktp/' . $file_lama);
                }
            } else {    
                $file = $_REQUEST['file_lama'];
            }
            $no_order = $_REQUEST['no_transaksi'];
            $total = $this->db->query("SELECT SUM(total) as total FROM m_keranjang_belanja WHERE id_user='".$user_id."'")->row_array();
            $data = array(
                'nomor_order' => $no_order,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'nama' => $nama,
                'user_id' => $user_id,
                'whatsapp' => $whatsapp,
                'alamat' => $alamat,
                'total_hari' => $total_hari,
                'total' => $total['total'],
                'kendaraan_id' => $kendaraan_id,
                'jenis_pembayaran' => $jenis_pembayaran,
                'ktp' => !empty($file) ? $file : '-',
                'create_at' => date('Y-m-d H:i:s')
            );

            if (empty($_POST['id'])) {
                $result = $this->db->insert('m_order', $data);
            } else {
                $result = $this->db->where(array('id' => $_POST['id']))->update('m_order', $data);
            }
            if ($result) {
                $detail_keranjang = $this->db->query("SELECT * FROM m_keranjang_belanja WHERE id_user='".$user_id."'")->result_array();
                foreach ($detail_keranjang as $key => $listData) {
                    $data = array(
                        'id_kendaraan' => $listData['id_kendaraan'],
                        'id_user' => $listData['id_user'],
                        'harga' => $listData['harga'],
                        'qty' => $listData['qty'],
                        'total' => $listData['total'],
                        'tgl_pinjam' => $listData['tgl_pinjam'],
                        'tgl_selesai' => $listData['tgl_selesai'],
                        'date_created' => $listData['date_created'],
                        'tipe' => $listData['tipe'],
                        'kode_transaksi' => $no_order,
                    );
                    $this->db->insert('m_order_detail',$data);
                }
                // var_dump($data);
                echo json_encode(array('status' => 'success', 'msg' => 'Berhasil Disimpan', 'nomor_transaksi'=>$no_order));
                $this->db->delete("m_keranjang_belanja", array('id_user'=>$user_id));
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'Gagal save'));
            }

        } catch (\Throwable $th) {
            echo json_encode(array('status' => 'error', 'msg' => 'Error'));
        }
    }
    public function showKeranjangSewa()
    {
        $this->load->view('api/show_keranjang_sewa');
    }
    public function pesanan()
    {
        $this->load->view('api/pesanan');
    }
    public function daftar()
    {
        $this->load->view('api/daftar');
    }
    public function login()
    {
        $this->load->view('api/login');
    }
    public function act_login()
    {
        $data = $this->db->get_where('m_user',array('username'=>$_REQUEST['username'], 'password'=>$_REQUEST['password']));
        if($data->num_rows()>=1){
            echo json_encode(array('status'=>'success', 'msg'=> $data->row_array()));
        }else{
            echo json_encode(array('status'=>'err', 'msg'=> 'Data tidak ditemukan'));
        }
    }
    public function proses_bayar()
    {
        if (isset($_REQUEST['simpan'])) {
            $tgl_bayar = $_REQUEST['tgl_bayar'];
            $config['upload_path'] = './storage/struk/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 80000;
            $config['max_width'] = 10000;
            $config['remove_space'] = 10000;
            $config['encrypt_name'] = 10000;
            $file_lama = $_POST['file_lama'];
            $this->load->library('upload', $config);
            if ($_FILES['file']['name'] != "") {
                if (!$this->upload->do_upload('file')) {
                    echo json_encode(array('status' => 'error', 'msg' => $this->upload->display_errors()));
                } else {
                    $upload_data = $this->upload->data();
                    $file = (empty($upload_data['file_name'])) ? "-" : $upload_data['file_name'];
                    unlink('./storage/ktp/' . $file_lama);
                }
            } else {    
                $file = $_REQUEST['file_lama'];
            }
            $data = array(
                'status_pembayaran'=>'proses',
                'struk_pembayaran'=>$file,
                'tgl_pembayaran' => date('Y-m-d H:i:s')
            );
            $result = $this->db->where(array('nomor_order' => $_REQUEST['id']))->update('m_order', $data);
            if($result){
                echo "
                <script>
                    alert('Data berhasil direkam dan disimpan di database');
                </script>
                ";
            }
        }
        $this->load->view('api/proses_bayar');
    }
    public function generate_key()
    {
        try {
            if ($_POST):
                $apikey = generateApiKey();
                $scret_key = generateSecretKey();
                $email = $_POST['email'];
                $data = array(
                    'api_key' => $apikey,
                    'secret_key' => $scret_key
                );
                $result = $this->db->where(array('email' => $email))->update('users', $data);
                if ($result) {
                    $set_alert = '<div class="alert alert-success alert-dismissible" role="alert"><div class="alert-message"><strong>Perhatian !! Data berhasil digenerate</strong></div></div>';
                    $this->session->set_flashdata('notify', $set_alert);
                    redirect('./apikey');
                } else {
                    $set_alert = '<div class="alert alert-danger alert-dismissible" role="alert"><div class="alert-message"><strong>Perhatian !! Data gagal digenerate</strong></div></div>';
                    $this->session->set_flashdata('notify', $set_alert);
                    redirect('./apikey');

                }
            endif;

        } catch (\Throwable $th) {
            redirect('./apikey');
        }

    }
    public function apikey()
    {
        $this->checkSession();
        $data['halaman'] = 'api/apikey';
        $this->load->view('modul', $data);
    }
    public function send_message()
    {
        $this->json_header();
        try {
            if ($_POST) {
                $api_key = $_POST['api_key'];
                $secret_key = $_POST['secret_key'];
                $from = str_ireplace('62', '', $_POST['from']);
                $to = $_POST['to'];
                $message = urlencode($_POST['message']);
                $chekActiveUser = $this->db->get_where('users', array('api_key' => $api_key, 'secret_key' => $secret_key))->row_array();
                if ($chekActiveUser['status'] == 'aktif') {
                    if (date('Y-m-d') > date($chekActiveUser['expired'])) {
                        echo json_encode(array('status' => false, 'message' => 'Api key expired'));
                    } else {
                        $ch = curl_init();
                        $url = url_wa() . "send-message?session=" . $from . "&to=" . $to . "&text=" . $message;
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $resdata = json_decode($result, true);
                        if ($resdata['data']['status'] == 1) {
                            echo json_encode(array('status' => true, 'message' => 'success sent message', 'to' => $to, 'text' => $message));
                        } else {
                            echo json_encode(array('status' => false, 'message' => 'Whatsapp not connect please scan again.'));
                        }
                    }
                } else {
                    echo json_encode(array('status' => false, 'message' => 'User not active or api_key invalid'));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => 'Method not allowed'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => false, 'message' => 'Error 404'));
        }
    }
    public function send_gambar()
    {
        $this->json_header();
        try {
            if ($_POST) {
                $api_key = $_POST['api_key'];
                $secret_key = $_POST['secret_key'];
                $from = str_ireplace('62', '', $_POST['from']);
                $to = $_POST['to'];
                $file = $_POST['file'];
                $message = urlencode($_POST['message']);
                $chekActiveUser = $this->db->get_where('users', array('api_key' => $api_key, 'secret_key' => $secret_key))->row_array();
                if ($chekActiveUser['status'] == 'aktif') {
                    if (date('Y-m-d') > date($chekActiveUser['expired'])) {
                        echo json_encode(array('status' => false, 'message' => 'Api key expired'));
                    } else {
                        $ch = curl_init();
                        $url = url_wa() . "send-picture?session=" . $from . "&to=" . $to . "&text=" . $message . "&file=" . $file;
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $resdata = json_decode($result, true);
                        if ($resdata['data']['status'] == 1) {
                            echo json_encode(array('status' => true, 'message' => 'success sent message', 'to' => $to, 'text' => $message, 'image' => $file));
                        } else {
                            echo json_encode(array('status' => false, 'message' => 'Whatsapp not connect please scan again.'));
                        }
                    }
                } else {
                    echo json_encode(array('status' => false, 'message' => 'User not active or api_key invalid'));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => 'Method not allowed'));
            }
        } catch (\Throwable $th) {
            echo json_encode(array('status' => false, 'message' => 'Error 404'));
        }
    }
    public function checkSession()
    {
        if (empty($this->session->userdata['username'])) {
            redirect('./');
        }
    }

    public function json_header()
    {
        return header('Content-Type: application/json; charset=utf-8');
    }
}
?>