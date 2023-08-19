<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Semester extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->form_validation->set_error_delimiters('', '');
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function index()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Semester',
			'subjudul' => 'Data Semester'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/semester/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->master->getDataSemester(), false);
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Semester',
			'subjudul'	=> 'Tambah Data Semester'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/semester/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$mhs = $this->master->getSemesterById($id);
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Mahasiswa',
			'subjudul'	=> 'Edit Data Mahasiswa',
			'semester' => $mhs
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('master/semester/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}
	public function validasi_semester($method)
	{
		$id 	= $this->input->post('id', true);
		$dari 			= $this->input->post('dari', true);
		$ke 			= $this->input->post('ke', true);
		$semester 			= $this->input->post('semester', true);
		$tahun 			= $this->input->post('tahun', true);


		$this->form_validation->set_rules('dari', 'Bulan Awal', 'required');
		$this->form_validation->set_rules('ke', 'Bulan Akhir', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');


		$this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
	}
	public function save()
	{
		$method = $this->input->post('method', true);
		$this->validasi_semester($method);

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'dari' => form_error('dari'),
					'ke' => form_error('ke'),
					'semester' => form_error('semester'),
					'tahun' => form_error('tahun'),
				]
			];
			$this->output_json($data);
		} else {
			$input = [
				'dari' 	=> $this->input->post('dari', true),
				'ke' => $this->input->post('ke', true),
				'semester' 	=> $this->input->post('semester', true),
				'tahun' => $this->input->post('tahun', true),
			];
			if ($method === 'add') {
				$action = $this->master->create('semester', $input);
			} else if ($method === 'edit') {
				$id = $this->input->post('id', true);
				$action = $this->master->update('semester', $input, 'id', $id);
			}

			if ($action) {
				$this->output_json(['status' => true]);
			} else {
				$this->output_json(['status' => false]);
			}
		}
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('semester', $chk, 'id')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function kelas_by_jurusan($id)
	{
		$data = $this->master->getKelasByJurusan($id);
		$this->output_json($data);
	}

	public function import($import_data = null)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Kelas',
			'subjudul' => 'Import Kelas',
			'jurusan' => $this->master->getAllJurusan()
		];
		if ($import_data != null) $data['import'] = $import_data;

		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/kelas/import');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function preview()
	{
		$config['upload_path']		= './uploads/import/';
		$config['allowed_types']	= 'xls|xlsx|csv';
		$config['max_size']			= 2048;
		$config['encrypt_name']		= true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('upload_file')) {
			$error = $this->upload->display_errors();
			echo $error;
			die;
		} else {
			$file = $this->upload->data('full_path');
			$ext = $this->upload->data('file_ext');

			switch ($ext) {
				case '.xlsx':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					break;
				case '.xls':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
					break;
				case '.csv':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
					break;
				default:
					echo "unknown file ext";
					die;
			}

			$spreadsheet = $reader->load($file);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$data = [];
			for ($i = 1; $i < count($sheetData); $i++) {
				$data[] = [
					'kelas' => $sheetData[$i][0],
					'jurusan' => $sheetData[$i][1]
				];
			}

			unlink($file);

			$this->import($data);
		}
	}
	public function do_import()
	{
		$input = json_decode($this->input->post('data', true));
		$data = [];
		foreach ($input as $d) {
			$data[] = ['nama_kelas' => $d->kelas, 'jurusan_id' => $d->jurusan];
		}

		$save = $this->master->create('kelas', $data, true);
		if ($save) {
			redirect('kelas');
		} else {
			redirect('kelas/import');
		}
	}
}
