<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pengguna extends CI_Controller {

	public function __construct()
	{
		error_reporting(0);
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->model('M_Datatables');
		$this->load->library('Datatablesserverside');
	}

	public function index()
	{	
		$this->checkSession();

		if(isset($_REQUEST['simpan'])){
			if (!empty($_REQUEST['id'])) {
				$data = array(
					'nama' => $_REQUEST['nama'],
					'username' => $_REQUEST['username'],
					'status' => $_REQUEST['status'],
					'level' => $_REQUEST['level'],
				);
				$this->db->where(array('id'=>$_REQUEST['id']));
				$result = $this->db->update('tb_admin',$data);
			}else{
				$data = array(
					'nama' => $_REQUEST['nama'],
					'username' => $_REQUEST['username'],
					'status' => $_REQUEST['status'],
					'level' => $_REQUEST['level'],
					'password' => md5($_REQUEST['password'])
				);
				$result = $this->db->insert('tb_admin',$data);
			}

			if ($result) {
				$this->berhasil('Data berhasil disimpan');
			}else{
				$this->gagal('Data gagal disimpan');
			}
		}


		if (isset($_REQUEST['update_password'])) {
			$cek_password_lama =- $this->db->get_where('tb_admin', array('password', md5($_REQUEST['password_lama'])))->num_rows();
			if($cek_password_lama>=1){
				if ($_REQUEST['password_baru']==$_REQUEST['konfirmasi_password']) {
					$data = array(
						'password' => md5($_REQUEST['password_baru'])
					);	
					$this->db->where(array('id'=>$_REQUEST['id']));
					$result = $this->db->update('tb_admin',$data);
					if ($result) {
						$this->berhasil('Data berhasil disimpan');
					}else{
						$this->gagal('Data gagal disimpan');
					}
				}else{
					$this->gagal('Password Tidak Sesuai');
				}
			}
		}

		$data['halaman'] = 'pengguna/pengguna';
		$this->load->view('modul',$data);
	}

	public function showPengguna(){

		$this->datatablesserverside->select('*');
		$this->datatablesserverside->from('tb_admin');
		echo $this->datatablesserverside->generate();
	}

	public function checkSession()
	{
		if(empty($this->session->userdata['username'])){
			redirect('./');
		}
	}


	public function berhasil($txt)
	{
		echo "<script>alert('".$txt."')</script>";
	}


	public function gagal($txt)
	{
		echo "<script>alert('".$txt."')</script>";
	}

}