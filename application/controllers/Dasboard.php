<?php
defined('BASEPATH') or exit('No direct script access allowed');

class dasboard extends CI_Controller
{

	public function __construct()
	{
		error_reporting(0);
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->model('M_Datatables');
		// $this->load->library('datatablesserverside');

		// if(empty($this->session->userdata['username'])){

		// }
	}

	public function index()
	{
		// var_dump($this->session->userdata['username']);
		if (!empty($this->session->userdata['username'])) {
			$this->dashboard();
		} else {
			redirect('./login');
			// $this->login();
			// $this->load->view('onboard');
		}
	}
	public function dashboard()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/index';
		$this->load->view('modul', $data);
	}
	public function kendaraan()
	{
		$this->checkSession();
		try {
			if (isset($_REQUEST['hapus'])) {
				$id = $_REQUEST['id'];
				$result = $this->db->where(array('kendaraan_id' => $id))->delete('m_kendaraan');
				if ($result) {
					redirect('kendaraan');
				}
			}
		} catch (\Throwable $th) {
			//throw $th;
		}
		$data['halaman'] = 'dashboard/kendaraan';
		$this->load->view('modul', $data);
	}
	public function add_kendaraan()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/add_kendaraan';
		$this->load->view('modul', $data);
	}
	public function transaksi()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/transaksi';
		$this->load->view('modul', $data);
	}
	public function detail_transaksi()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/detail_transaksi';
		$this->load->view('modul', $data);
	}
	public function add_sopir()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/add_sopir';
		$this->load->view('modul', $data);
	}
	public function save_sopir()
	{
		$this->checkSession();
		$nama = $_REQUEST['nama'];
		$harga = $_REQUEST['harga'];
		$deskripsi = $_REQUEST['deskripsi'];
		$config['upload_path'] = './storage/sopir/';
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
				unlink('./storage/sopir/' . $file_lama);
			}
		} else {
			$file = $_REQUEST['file_lama'];
		}
		$data = array(
			'nama' => $nama,
			'harga' => $harga,
			'deskripsi' => $deskripsi,
			'foto' => $file,
			'create_at' => date('Y-m-d H:i:s')
		);
		if (!empty($_REQUEST['id'])) {
			$result = $this->db->where(array('id_sopir' => $_REQUEST['id']))->update('m_sopir', $data);
		} else {
			$result = $this->db->insert('m_sopir', $data);
		}
		if ($result) {
			echo json_encode(array('status' => 'success', 'msg' => 'Data berhasil di'));
		} else {
			echo json_encode(array('status' => 'error', 'msg' => 'Data gagal di'));

		}
	}
	public function create_kendaraan()
	{
		try {
			$this->checkSession();
			$nama = $_REQUEST['nama'];
			$harga = $_REQUEST['harga'];
			$jenis_transmisi = $_REQUEST['jenis_transmisi'];
			$stock = $_REQUEST['stock'];
			$deskripsi = $_REQUEST['deskripsi'];
			$merek = $_REQUEST['merek'];
			$bbm = $_REQUEST['bbm'];
			$data = array(
				'nama' => $nama,
				'harga' => $harga,
				'jenis_transmisi' => $jenis_transmisi,
				'stock' => $stock,
				'deskripsi' => $deskripsi,
				'merek' => $merek,
				'bbm' => $bbm,
				'create_at' => date('Y-m-d H:i:s')
			);
			if (!empty($_REQUEST['kendaraan_id'])) {
				$id = $_REQUEST['kendaraan_id'];
				$result = $this->db->where(array('kendaraan_id' => $id))->update('m_kendaraan', $data);
			} else {
				$result = $this->db->insert('m_kendaraan', $data);
			}
			if ($result) {
				echo json_encode(array('status' => 'success', 'msg' => 'Data berhasil disimpan'));
			} else {
				echo json_encode(array('status' => 'gagal', 'msg' => 'error sistem'));
			}
		} catch (\Throwable $th) {
			echo json_encode(array('status' => 'gagal', 'msg' => 'error sistem'));
		}


	}
	public function add_foto_kendaraan()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/add_foto_kendaraan';
		$this->load->view('modul', $data);
	}
	public function do_upload_foto_kendaraan()
	{
		$this->checkSession();
		$file_lama = $_REQUEST['file_lama'];
		$config['upload_path'] = './storage/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = 80000;
		$config['max_width'] = 10000;
		$config['remove_space'] = 10000;
		$config['encrypt_name'] = 10000;
		$this->load->library('upload', $config);
		if ($_FILES['foto']['name'] != "") {
			if (!$this->upload->do_upload('foto')) {
				echo json_encode(array('status' => 'error', 'msg' => $this->upload->display_errors()));
			} else {
				$upload_data = $this->upload->data();
				$file = (empty($upload_data['file_name'])) ? "-" : $upload_data['file_name'];
				unlink('./storage/' . $file_lama);
			}
		} else {
			$file = $_REQUEST['file_lama'];
		}
		$kendaraan_id = $_REQUEST['kendaraan_id'];
		$data = array(
			'kendaraan_id' => $kendaraan_id,
			'file_foto' => $file,
			'create_at' => date('Y-m-d H:i:s')
		);
		if (empty($_POST['id'])) {
			$result = $this->db->insert('m_foto_kendaraan', $data);
		} else {
			$result = $this->db->where(array('id' => $_POST['id']))->update('m_foto_kendaraan', $data);
		}
		if ($result) {
			redirect('./dasboard/add_foto_kendaraan?id=' . $kendaraan_id);
			// echo json_encode(array('status' => 'success', 'msg' => 'Berhasil Disimpan'));
		} else {
			redirect('./dasboard/add_foto_kendaraan?id=' . $kendaraan_id);
			// echo json_encode(array('status' => 'error', 'msg' => 'Gagal save'));
		}

	}
	public function do_delete_foto()
	{
		$this->checkSession();
		$id_foto = $_REQUEST['id_foto'];
		$foto_lama = $_REQUEST['foto_lama'];
		$kendaraan_id = $_REQUEST['kendaraan_id'];
		$result = $this->db->where(array('foto_id' => $id_foto))->delete('m_foto_kendaraan');
		if ($result) {
			unlink('./storage/' . $foto_lama);
			redirect('./dasboard/add_foto_kendaraan?id=' . $kendaraan_id);
		} else {
			redirect('./dasboard/add_foto_kendaraan?id=' . $kendaraan_id);
		}
	}
	public function sopir()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/sopir';
		$this->load->view('modul', $data);
	}
	public function laporan()
	{
		$this->checkSession();
		$data['halaman'] = 'dashboard/laporan';
		$this->load->view('modul', $data);
	}
	public function berhasil()
	{
		echo "<script>alert('Berhasil disimpan')</script>";
	}
	public function berhasil_dikirim()
	{
		echo "<script>alert('Berhasil Dikirim')</script>";
	}

	public function gagal()
	{
		echo "<script>alert('Gagal disimpan')</script>";
	}

	public function checkSession()
	{
		if (empty($this->session->userdata['username'])) {
			redirect('./');
		}
	}
}

?>