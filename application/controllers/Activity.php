<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends CI_Controller {

	public $mhs, $user;

	public function __construct(){
		parent::__construct();
		if (!$this->ion_auth->logged_in()){
			redirect('auth');
		}
		$this->load->library(['datatables', 'form_validation']);// Load Library Ignited-Datatables
		$this->load->helper('my');
		$this->load->model('Master_model', 'master');
		$this->load->model('Soal_model', 'soal');
		$this->load->model('Ujian_model', 'ujian');
		$this->load->model('Activity_model', 'activity');
		$this->form_validation->set_error_delimiters('','');

		$this->user = $this->ion_auth->user()->row();
		$this->mhs 	= $this->activity->getIdMahasiswa($this->user->username);
    }

    public function akses_dosen()
    {
        if ( !$this->ion_auth->in_group('dosen') ){
			show_error('Halaman ini khusus untuk dosen untuk membuat Test Online, <a href="'.base_url('dashboard').'">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
    }

    public function akses_mahasiswa()
    {
        if ( !$this->ion_auth->in_group('mahasiswa') ){
			show_error('Halaman ini khusus untuk mahasiswa mengikuti ujian, <a href="'.base_url('dashboard').'">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
    }

    public function output_json($data, $encode = true)
	{
        if($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
	}
	
	public function json($id=null)
	{
        $this->akses_dosen();

		$this->output_json($this->activity->getDataActivity($id), false);

	}

    public function master()
	{
        $this->akses_dosen();
        $user = $this->ion_auth->user()->row();
        $data = [
			'user' => $user,
			'judul'	=> 'Activity',
			'subjudul'=> 'Data Activity',
			'dosen' => $this->ujian->getIdDosen($user->username),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('activity/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function add()
	{
		$this->akses_dosen();
		
		$user = $this->ion_auth->user()->row();

        $data = [
			'user' 		=> $user,
			'judul'		=> 'Activity',
			'subjudul'	=> 'Tambah Activity',
			'matkul'	=> $this->soal->getMatkulDosen($user->username),
			'kelas'	=> $this->activity->getKelasDosen($user->username),
			'dosen'		=> $this->activity->getIdDosen($user->username),
			'komponen'	=> $this->activity->getKomponenDosen($user->username),
		];
		// print_r($data['komponen']);die();
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('activity/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}
	
	public function edit($id)
	{
		$this->akses_dosen();
		
		$user = $this->ion_auth->user()->row();

        $data = [
			'user' 		=> $user,
			'judul'		=> 'Ujian',
			'subjudul'	=> 'Edit Ujian',
			'matkul'	=> $this->soal->getMatkulDosen($user->username),
			'dosen'		=> $this->ujian->getIdDosen($user->username),
			'ujian'		=> $this->ujian->getUjianById($id),
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('ujian/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function convert_tgl($tgl)
	{
		$this->akses_dosen();
		return date('Y-m-d H:i:s', strtotime($tgl));
	}

	public function validasi()
	{
		$this->akses_dosen();
		
		$user 	= $this->ion_auth->user()->row();
		$dosen 	= $this->ujian->getIdDosen($user->username);
		$jml 	= $this->ujian->getJumlahSoal($dosen->id_dosen)->jml_soal;
		$jml_a 	= $jml + 1; // Jika tidak mengerti, silahkan baca user_guide codeigniter tentang form_validation pada bagian less_than

		$this->form_validation->set_rules('nama_ujian', 'Nama Ujian', 'required|alpha_numeric_spaces|max_length[50]');
		$this->form_validation->set_rules('jumlah_soal', 'Jumlah Soal', "required|integer|less_than[{$jml_a}]|greater_than[0]", ['less_than' => "Soal tidak cukup, anda hanya punya {$jml} soal"]);
		$this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
		$this->form_validation->set_rules('tgl_selesai', 'Tanggal Selesai', 'required');
		$this->form_validation->set_rules('waktu', 'Waktu', 'required|integer|max_length[4]|greater_than[0]');
		$this->form_validation->set_rules('jenis', 'Acak Soal', 'required|in_list[acak,urut]');
	}

	public function save()
	{
		// echo "<pre>".var_export($_POST,true);
		// die();
		$this->validasi();
		$this->load->helper('string');

		$method 		= $this->input->post('method', true);
		$dosen_id 		= $this->input->post('dosen_id', true);
		$matkul_id 		= $this->input->post('matkul_id', true);
		$kelas_id 		= $this->input->post('kelas_id', true);
		$komponen_id 	= $this->input->post('komponen_id', true);
		$nama_activity 	= $this->input->post('nama_activity', true);
		$tgl 		= $this->convert_tgl($this->input->post('tgl_mulai', true));
		$tgl2 		= $this->convert_tgl($this->input->post('tgl_selesai', true));
		$waktu			= $this->input->post('waktu', true);
		$soalrow			= $this->input->post('soalrow', true);
		$soalnya = array();
		
		// echo "<pre>".var_export($soalnya,true);
		// die();
		// if( $this->form_validation->run() === FALSE ){
		// 	$data['status'] = false;
		// 	$data['errors'] = [
		// 		'nama_activity' 	=> form_error('nama_activity'),
		// 		'tgl_mulai' 	=> form_error('tgl_mulai'),
		// 		'waktu' 		=> form_error('waktu'),
		// 	];
		// }else{
			$input = [
				'nama_activity' 	=> $nama_activity,
				'tgl' 	=> $tgl,
				'tgl_selesai' 	=> $tgl2,
				'waktu' 		=> $waktu,
				'komponen_id' 		=> $komponen_id,
			];
			if($method === 'add'){
				$input['dosen_id']	= $dosen_id;
				$input['matkul_id'] = $matkul_id;
				$input['kelas_id']	= $kelas_id;
				if($_POST['soalrow'] > 0){
					$action = $this->master->create('m_activity', $input);
					for ($i = 1; $i <= $_POST['soalrow']; $i++) {
						$list_soal= array(
							'activity_id' => $this->db->insert_id(), 
							'soal' => $_POST['soal'][$i]['soal'], 
							'gambar' => '',  
							'jenis' => $_POST['soal'][$i]['jenis'],
							'opsi_a' => $_POST['soal'][$i]['opsi_a'],
							'opsi_b' => $_POST['soal'][$i]['opsi_b'], 
							'opsi_c' => $_POST['soal'][$i]['opsi_c'], 
							'opsi_d' => $_POST['soal'][$i]['opsi_d'],
							'opsi_e' => $_POST['soal'][$i]['opsi_e'],
							'kunci' => $_POST['soal'][$i]['kunci'],
						);
						$soalnya[] = $list_soal;
					}
					// print_r($soalnya);die();
					// if(!empty($soalnya)){
						$action = $this->master->create('l_activity', $soalnya,true);
					// }
				}else{
					$action = false;
					$data['errors'] = false;
					$data['gagal'] = ['message' => 'Gagal menyimpan data, data soal kosong'];
				}
				
			}else if($method === 'edit'){
				$id_activity = $this->input->post('id_activity', true);
				$action = $this->master->update('m_activity', $input, 'id_activity', $id_activity);
			}
			$data['status'] = $action ? TRUE : FALSE;
		// }
		$this->output_json($data);
	}

	public function delete()
	{
		$this->akses_dosen();
		$chk = $this->input->post('checked', true);
        if(!$chk){
            $this->output_json(['status'=>false]);
        }else{
            if($this->master->delete('m_activity', $chk, 'id_activity')){
            	if($this->master->delete('l_activity', $chk, 'activity_id')){
                	$this->output_json(['status'=>true, 'total'=>count($chk)]);
            	}
            }
        }
	}

	public function refresh_token($id)
	{
		$this->load->helper('string');
		$data['token'] = strtoupper(random_string('alpha', 5));
		$refresh = $this->master->update('m_ujian', $data, 'id_ujian', $id);
		$data['status'] = $refresh ? TRUE : FALSE;
		$this->output_json($data);
	}

	/**
	 * BAGIAN MAHASISWA
	 */

	public function list_json()
	{
		$this->akses_mahasiswa();
		
		$list = $this->activity->getListActivity($this->mhs->id_mahasiswa, $this->mhs->kelas_id);
		$this->output_json($list, false);
	}
	
	public function list()
	{
		$this->akses_mahasiswa();

		$user = $this->ion_auth->user()->row();
		
		$data = [
			'user' 		=> $user,
			'judul'		=> 'Activity',
			'subjudul'	=> 'List Activity',
			'mhs' 		=> $this->activity->getIdMahasiswa($user->username),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('activity/list');
		$this->load->view('_templates/dashboard/_footer.php');
	}
	
	public function token($id)
	{
		$this->akses_mahasiswa();
		$user = $this->ion_auth->user()->row();
		
		$data = [
			'user' 		=> $user,
			'judul'		=> 'Activity',
			'subjudul'	=> 'Do Activity',
			'mhs' 		=> $this->activity->getIdMahasiswa($user->username),
			'activity'	=> $this->activity->getActivityById($id),
			'encrypted_id' => urlencode($this->encryption->encrypt($id))
		];
		$this->load->view('_templates/topnav/_header.php', $data);
		$this->load->view('activity/token');
		$this->load->view('_templates/topnav/_footer.php');
	}

	public function cektoken()
	{
		$id = $this->input->post('id_ujian', true);
		$token = $this->input->post('token', true);
		$cek = $this->ujian->getUjianById($id);
		
		$data['status'] = $token === $cek->token ? TRUE : FALSE;
		$this->output_json($data);
	}

	public function encrypt()
	{
		$id = $this->input->post('id', true);
		$key = urlencode($this->encryption->encrypt($id));
		// $decrypted = $this->encryption->decrypt(rawurldecode($key));
		$this->output_json(['key'=>$key]);
	}

	public function index()
	{
		$this->akses_mahasiswa();
		$key = $this->input->get('key', true);
		$id  = $this->encryption->decrypt(rawurldecode($key));
		
		$activity 	= $this->activity->getActivityById($id);
		$soal 	= $this->activity->getSoal2($id);
		
		$mhs = $this->mhs;
		$h_activity = $this->activity->HslActivity($id, $mhs->id_mahasiswa);
		$cek_sudah_ikut = $h_activity->num_rows();
		$data = [
			'user' 		=> $this->user,
			'mhs'		=> $this->mhs,
			'judul'		=> 'Activity',
			'subjudul'	=> 'Lembar Activity',
		];

		// print_r($data);die();
		if ($cek_sudah_ikut < 1) {
			$data['activity'] = $activity;
			$data['mhs'] = $mhs;
			$data['soal'] = $soal;

			$this->load->view('_templates/topnav/_header.php', $data);
			$this->load->view('activity/sheet');
			$this->load->view('_templates/topnav/_footer.php');
		}else{
			$data['old'] = $h_activity->row();
			$data['activity'] = $activity;
			$data['mhs'] = $mhs;
			$data['soal'] = $soal;
			$this->load->view('_templates/topnav/_header.php', $data);
			$this->load->view('activity/sheet');
			$this->load->view('_templates/topnav/_footer.php');
		}
		
		
		
	}

	public function simpan_satu()
	{
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);
		
		$input 	= $this->input->post(null, true);
		$list_jawaban 	= "";
		for ($i = 1; $i < $input['jml_soal']; $i++) {
			$_tjawab 	= "opsi_".$i;
			$_tidsoal 	= "id_soal_".$i;
			$_ragu 		= "rg_".$i;
			$jawaban_ 	= empty($input[$_tjawab]) ? "" : $input[$_tjawab];
			$list_jawaban	.= "".$input[$_tidsoal].":".$jawaban_.":".$input[$_ragu].",";
		}
		$list_jawaban	= substr($list_jawaban, 0, -1);
		$d_simpan = [
			'list_jawaban' => $list_jawaban
		];
		
		// Simpan jawaban
		$this->master->update('h_ujian', $d_simpan, 'id', $id_tes);
		$this->output_json(['status'=>true]);
	}

	public function simpan_akhir()
	{
		// Decrypt Id
		$id_tes = $this->input->post('id', true);
		$id_tes = $this->encryption->decrypt($id_tes);
		
		// Get Jawaban
		$list_jawaban = $this->ujian->getJawaban($id_tes);

		// Pecah Jawaban
		$pc_jawaban = explode(",", $list_jawaban);
		
		$jumlah_benar 	= 0;
		$jumlah_salah 	= 0;
		$jumlah_ragu  	= 0;
		$nilai_bobot 	= 0;
		$total_bobot	= 0;
		$jumlah_soal	= sizeof($pc_jawaban);

		foreach ($pc_jawaban as $jwb) {
			$pc_dt 		= explode(":", $jwb);
			$id_soal 	= $pc_dt[0];
			$jawaban 	= $pc_dt[1];
			$ragu 		= $pc_dt[2];

			$cek_jwb 	= $this->soal->getSoalById($id_soal);
			$total_bobot = $total_bobot + $cek_jwb->bobot;

			$jawaban == $cek_jwb->jawaban ? $jumlah_benar++ : $jumlah_salah++;
		}

		$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
		$nilai_bobot = ($total_bobot / $jumlah_soal)  * 100;

		$d_update = [
			'jml_benar'		=> $jumlah_benar,
			'nilai'			=> number_format(floor($nilai), 0),
			'nilai_bobot'	=> number_format(floor($nilai_bobot), 0),
			'status'		=> 'N'
		];

		$this->master->update('h_ujian', $d_update, 'id', $id_tes);
		$this->output_json(['status'=>TRUE, 'data'=>$d_update, 'id'=>$id_tes]);
	}
	public function komponen()
	{
        $this->akses_dosen();
        $user = $this->ion_auth->user()->row();
        $data = [
			'user' => $user,
			'judul'	=> 'Activity',
			'subjudul'=> 'Komponen Activity',
			'dosen' => $this->ujian->getIdDosen($user->username),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('activity/komponen');
		$this->load->view('_templates/dashboard/_footer.php');
	}
	public function data_komponen()
	{	
		$user = $this->ion_auth->user()->row();
        $id = $this->activity->getIdDosen($user->username);
		// print_r($id);die();
		$this->output_json($this->master->getDataKomponen($id->id_dosen), false);
	}
	public function add_komponen()
	{
		$user = $this->ion_auth->user()->row();
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Komponen',
			'subjudul'	=> 'Tambah Data Komponen',
			'banyak'	=> $this->input->post('banyak', true),
			'matkul'	=> $this->soal->getMatkulDosen($user->username),
			'dosen'		=> $this->activity->getIdDosen($user->username),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('activity/add_komponen');
		$this->load->view('_templates/dashboard/_footer.php');
	}
	public function save_komponen()
	{
		$rows = count($this->input->post('komponen', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$komponen 	= 'komponen[' . $i . ']';
			$persentase 	= 'persentase[' . $i . ']';
			$this->form_validation->set_rules($komponen, 'Komponen', 'required');
			$this->form_validation->set_rules($persentase, 'Persentase', 'required');
			$this->form_validation->set_message('required', '{field} Wajib diisi');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$komponen 	=> form_error($komponen),
					$persentase 	=> form_error($persentase),
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'dosen_id' => $this->input->post('dosen_id', true),
						'matkul_id' => $this->input->post('matkul_id', true),
						'komponen' 	=> $this->input->post($komponen, true),
						'persentase' 	=> $this->input->post($persentase, true)
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_komponen'		=> $this->input->post('id_komponen[' . $i . ']', true),
						'komponen' 	=> $this->input->post($komponen, true),
						'persentase' 	=> $this->input->post($persentase, true)
					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('m_komponen', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('m_komponen', $update, 'id_komponen', null, true);
				$data['update'] = $update;
			}
		} else {
			if (isset($error)) {
				$data['errors'] = $error;
			}
		}
		$data['status'] = $status;
		$this->output_json($data);
	}
	public function delete_komponen($value='')
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('m_komponen', $chk, 'id_komponen')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	
	}
	public function save_sheet()
	{	
		$jawab = $this->input->post('jawaban', true);
		$soalnya = $this->input->post('soalnya', true);
		$jenis = $this->input->post('jenis', true);
		// print_r($jawab);die();
		$input = [
			'activity_id' 	=>  $this->input->post('activity_id', true),
			'mahasiswa_id'	=>  $this->input->post('mahasiswa_id', true),
			'nilai'			=> 0,
			'tgl_mulai'		=> date('Y-m-d H:i:s'),
			'tgl_selesai'	=> date('Y-m-d H:i:s'),
			'status'		=> 'Y'
		];
		$this->master->create('h_activity', $input);
		$detail = array();
		$ide = $this->db->insert_id();
		$soal = $this->activity->getSoal2( $this->input->post('activity_id', true));
		foreach($soal as $sol){
			if($jenis[$sol->id] == 'File'){
				$jaw = 'File';
			}else{
				$jaw =  $jawab[$sol->id];
			}
			$det = array(
					'hactivity_id' => $ide,
					'soal_id' => $soalnya[$sol->id],
					'jenis' => $jenis[$sol->id],
					'jawaban' => $jaw,
					'nilai' => 0
			);
			$detail[] = $det;
		}
		$this->master->create('d_activity', $detail, true);
		redirect('/activity/list', 'refresh');
		
	}
}