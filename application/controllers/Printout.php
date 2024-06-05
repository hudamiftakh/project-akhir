<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class printout extends CI_Controller {
	// require_once APPPATH.'libraries/tcpdf/tcpdf.php';

	public function __construct()
	{
		error_reporting(0);
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->model('M_Datatables');
		$this->load->library('cart');

		if(empty($this->session->userdata['username'])){
			$this->load->view('login');
		}
	}

	public function checkSession()
	{
		if(empty($this->session->userdata['username'])){
			redirect('./');
		}
	}

	public function print_detail_siswa_perkelas()
	{
		$this->checkSession();
		$data['halaman'] = 'printout/print_detail_siswa_perkelas';
		$this->load->view('modul_print',$data);
	}
	
	public function print_laporan_kunjungan_perpustakaan()
	{
		$this->checkSession();
		$data['halaman'] = 'printout/print_laporan_kunjungan_perpustakaan';
		$this->load->view('modul_print',$data);
	}
	public function print_laporan_kunjungan_jamaah()
	{
		$this->checkSession();
		$data['halaman'] = 'printout/print_laporan_kunjungan_jamaah';
		$this->load->view('modul_print',$data);
	}
	public function print_laporan_pengaduan()
	{
		$this->checkSession();
		$data['halaman'] = 'printout/print_laporan_pengaduan';
		$this->load->view('modul_print',$data);
	}

	public function print_laporan_detail()
	{
		$this->checkSession();
		$data['halaman'] = 'printout/print_laporan_detail';
		$this->load->view('modul_print',$data);
	}
}
?>