<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of users model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_peserta extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	var $search = array('a.nama_lengkap', 'a.nik', 'a.id_province', 'a.id_regency');
	public function get_datatables($param)
	{
		$this->_get_datatables_query($param);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_filtered($param)
	{
		$this->_get_datatables_query($param);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->select('a.id_peserta');
		$this->db->from('data_peserta a');
		if ($this->app_loader->current_opdid()) {
			$this->db->where('a.id_peserta IN (SELECT xxx.id_peserta FROM data_history_pelatihan xxx WHERE xxx.id_opd = ' . $this->app_loader->current_opdid() . ')');
		}
		if (!$this->app_loader->is_super()) {
		}
		$this->db->group_by('a.id_peserta');
		return $this->db->count_all_results();
	}

	private function _get_datatables_query($param)
	{
		$post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
		}
		$this->db->select('a.id_peserta,
							a.token,
							a.nik,
							a.nama_lengkap,
							a.tempat_lhr,
							a.tanggal_lhr,
							a.alamat_peserta,
							a.no_hp,
							a.id_study,
							a.id_agama,
							a.id_gender,
							a.id_province,
							a.id_regency,
							a.pekerjaan,
							a.id_jenis_akun,
							a.minat_usaha,
							a.kode_pos,
							a.upload_foto
						   ');
		$this->db->from('data_peserta a');
		//Nama Lengkap
		if (isset($post['nama_lengkap_search']) and $post['nama_lengkap_search'] != '')
			$this->db->like('a.nama_lengkap', $post['nama_lengkap_search'], 'after');
		//NIK
		if (isset($post['nik_search']) and $post['nik_search'] != '')
			$this->db->like('a.nik', $post['nik_search'], 'after');
		//Province
		if (isset($post['province_search']) and $post['province_search'] != '')
			$this->db->where('a.id_province', $post['province_search']);
		//Regency
		if (isset($post['regency_search']) and $post['regency_search'] != '')
			$this->db->where('a.id_regency', $post['regency_search']);

		if ($this->app_loader->current_opdid()) {
			$this->db->where('a.id_peserta IN (SELECT xxx.id_peserta FROM data_history_pelatihan xxx WHERE xxx.id_opd = ' . $this->app_loader->current_opdid() . ')');
		}
		$i = 0;
		foreach ($this->search as $item) { // loop column
			if ($_POST['search']['value']) { // if datatable send POST for search
				if ($i === 0) { // first loop
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		$this->db->group_by('a.id_peserta');
		$this->db->order_by('a.id_peserta ASC');
	}
	public function printDataPeserta($tahun)
	{
		$this->db->select('a.id_peserta,
							a.token,
							a.nik,
							a.nama_lengkap,
							a.tempat_lhr,
							a.tanggal_lhr,
							a.alamat_peserta,
							a.no_hp,
							a.id_study,
							d.study as pendidikan,
							a.id_agama,
							f.agama,
							a.id_gender,
							e.gender as jenis_kelamin,
							a.id_province,
							b.name as provinsi,
							a.id_regency,
							c.name as kabkota,
							a.pekerjaan,
							a.id_jenis_akun,
							a.minat_usaha,
							a.kode_pos,
							a.upload_foto,
							g.username as email,
							i.nama_opd,
							j.id_pelatihan,
							l.nm_pelatihan,
							k.tanggal_pelatihan,
							YEAR(k.tanggal_pelatihan) as tahun_pelatihan,
							k.tanggal_pelatihan_akhir,
							k.tempat_pelatihan,
							m.no_nib,
						   ');
		$this->db->from('data_peserta a');
		$this->db->join('wa_province b', 'a.id_province = b.id', 'left');
		$this->db->join('wa_regency c', 'a.id_regency = c.id', 'left');
		$this->db->join('ref_pendidikan d', 'a.id_study = d.id_study', 'left');
		$this->db->join('ref_gender e', 'a.id_gender = e.id_gender', 'left');
		$this->db->join('ref_agama f', 'a.id_agama = f.id_agama', 'left');
		$this->db->join('xi_sa_users g', 'a.token = g.token', 'left');
		$this->db->join('data_history_pelatihan h', 'a.id_peserta = h.id_peserta', 'inner');
		$this->db->join('ms_unit_kerja i', 'h.id_opd = i.id_opd', 'inner');
		$this->db->join('data_pelatihan j', 'h.id_pelatihan = j.id_pelatihan', 'inner');
		$this->db->join('ms_jadwal k', 'j.id_jadwal = k.id_jadwal', 'inner');
		$this->db->join('ms_pelatihan l', 'k.id_master_pelatihan = l.id_master_pelatihan', 'inner');
		$this->db->join('data_umkm m', 'a.id_peserta = m.id_peserta', 'left');
		if ($this->app_loader->current_opdid()) {
			$this->db->where('i.id_opd', $this->app_loader->current_opdid());
		}
		if ($tahun != '') {
			$this->db->where('YEAR(k.tanggal_pelatihan)', $tahun);
		}
		$this->db->group_by('a.id_peserta');
		$this->db->order_by('j.id_pelatihan ASC, a.id_peserta ASC');
		$get = $this->db->get();
		return $get->result_array();
	}
	/*Fungsi get data edit by id dan url*/
	public function getDataDetailPeserta($token)
	{
		$this->db->select('a.id_peserta,
							a.token,
							a.nik,
							a.nama_lengkap,
							a.tempat_lhr,
							a.tanggal_lhr,
							a.alamat_peserta,
							a.no_hp,
							a.id_study,
							a.id_agama,
							a.id_gender,
							a.id_province,
							a.id_regency,
							a.pekerjaan,
							a.id_jenis_akun,
							a.minat_usaha,
							a.kode_pos,
							a.upload_foto,
							b.id_pelatihan
							');
		$this->db->from('data_peserta a');
		$this->db->join('data_history_pelatihan b', 'a.id_peserta = b.id_peserta', 'left');
		$this->db->where('a.token', $token);
		if (!$this->app_loader->is_super()) {
		}
		$this->db->group_by('a.id_peserta');
		$this->db->order_by('a.id_peserta ASC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getDataDetailUsers($token)
	{
		$this->db->select('a.id_users,
                           a.token,
                           a.username,
                           a.password,
                           a.email,
                           a.fullname,
                           a.foto_profile,
                           a.blokir,
						   a.id_status,
						   b.pass_plain
						   ');
		$this->db->from('xi_sa_users a');
		$this->db->join('xi_sa_users_default_pass b', 'a.id_users = b.id_users', 'left');
		$this->db->where('a.token', $token);
		if (!$this->app_loader->is_super()) {
		}
		$this->db->group_by('a.id_users');
		$this->db->order_by('a.id_users ASC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}

	private function getDataPesertaByToken($token)
	{
		$this->db->where('token', $token);
		$query = $this->db->get('data_peserta');
		return $query->row_array();
	}

	private function getDataUserByToken($token)
	{
		$this->db->where('token', $token);
		$query = $this->db->get('xi_sa_users');
		return $query->row_array();
	}

	private function getDataHistoryPel($nik)
	{
		$this->db->where('a.nik', $nik);
		$this->db->from('data_peserta a');
		$this->db->join('data_history_pelatihan b', 'a.id_peserta = b.id_peserta', 'inner');
		$query = $this->db->get();
		return $query->row_array();
	}

	private function getPelatihan($pelatihan)
	{
		$this->db->select('a.id_pelatihan,
							b.mulai_registrasi,
                           YEAR(b.tanggal_pelatihan) as tahun_pelatihan
                           ');
		$this->db->from('data_pelatihan a');
		$this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
		$this->db->where('a.id_pelatihan', $pelatihan);
		$query = $this->db->get();
		return $query->row_array();
	}

	/* Fungsi untuk insert data */
	public function insertDataPeserta()
	{
		//get data
		$create_by   	= $this->app_loader->current_account();
		$opd_id       	= $this->app_loader->current_opdid();
		$create_date 	= date('Y-m-d H:i:s');
		$create_ip   	= $this->input->ip_address();
		$nik	 	 	= escape($this->input->post('nik', TRUE));
		$id_pelatihan	= escape($this->input->post('id_pelatihan', TRUE));
		$nama_lengkap 	= escape($this->input->post('nama_lengkap', TRUE));
		$upload_foto    = escape($this->input->post('upload_foto', TRUE));
		$username	 	= escape($this->input->post('username', TRUE));
		if ($this->app_loader->is_admin()) {
			$password 	 	= 'Asdf@1234';
		} else {
			$password 	 	= escape($this->input->post('password', TRUE));
		}

		$token		 	= generateToken($nik, $nama_lengkap);

		$dataTahun 			= $this->getPelatihan($id_pelatihan);
		$tahun 	   			= !empty($dataTahun) ? $dataTahun['tahun_pelatihan'] : 0;
		$regist 			= !empty($dataTahun) ? $dataTahun['mulai_registrasi'] : 0;

		/*cek nik yang diinputkan*/
		$this->db->where('nik', $nik);
		$qTot = $this->db->count_all_results('data_peserta');
		$dataPelatihan = $this->getDataHistoryPel($nik);
		if ($qTot > 0) {
			return array('response' => 'ERROR', 'nikID' => $nik);
		} else if ($dataPelatihan > 0) {
			return array('response' => 'FOUND');
		} else {
			$dirname 	   	= 'assets/img/avatar';
			if (!is_dir($dirname)) {
				mkdir('./' . $dirname, 0777, TRUE);
			}
			//cek upload file foto	
			$config = array(
				'upload_path'	 	=> './' . $dirname . '/',
				'allowed_types' 	=> 'png|jpg|jpeg',
				'file_type'         => 'image/jpeg|image/png|image/jpg',
                'is_image'          => 1,
				'file_name' 		=> 'foto_' . $token,
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 3072,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE
			);

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('upload_foto')) {
				return array('response' => 'NOIMAGE');
			} else {
				$upload_data = $this->upload->data();
				$file_foto = $upload_data['file_name'];
				$data = array(
					'token'				  	    => $token,
					'nik' 						=> $nik,
					'nama_lengkap' 				=> $nama_lengkap,
					'upload_foto' 				=> $file_foto,
					'tempat_lhr' 				=> escape($this->input->post('tempat_lhr', TRUE)),
					'no_hp' 					=> escape($this->input->post('no_hp', TRUE)),
					'tanggal_lhr' 				=> escape($this->input->post('tanggal_lhr', TRUE)),
					'alamat_peserta' 			=> escape($this->input->post('alamat_peserta', TRUE)),
					'id_study' 					=> escape($this->input->post('id_study', TRUE)),
					'id_agama' 					=> escape($this->input->post('id_agama', TRUE)),
					'id_gender' 				=> escape($this->input->post('id_gender', TRUE)),
					'id_province' 				=> escape($this->input->post('province', TRUE)),
					'id_regency' 				=> escape($this->input->post('regency', TRUE)),
					'kode_pos' 					=> escape($this->input->post('kode_pos', TRUE)),
					'pekerjaan' 				=> escape($this->input->post('pekerjaan', TRUE)),
					'id_jenis_akun' 			=> escape($this->input->post('id_jenis_akun', TRUE)),
					'minat_usaha' 			    => escape($this->input->post('minat_usaha', TRUE)),
					'create_by' 				=> $create_by,
					'create_date' 				=> $create_date,
					'create_ip' 				=> $create_ip,
					'mod_by' 					=> $create_by,
					'mod_date' 					=> $create_date,
					'mod_ip' 					=> $create_ip
				);
				/*query insert*/
				$this->db->insert('data_peserta', $data);
				$id_peserta = $this->db->insert_id();

				$data_pelatihan = array(
					'id_pelatihan'      => $id_pelatihan,
					'id_opd'    	    => $opd_id,
					'id_peserta'    	=> $id_peserta,
					'tahun'   			=> $tahun,
					'flag'   			=> '1',
					'tanggal_daftar'   	=> $regist,
					'id_status'   	    => '1'
				);
				/*query insert*/
				$this->db->insert('data_history_pelatihan', $data_pelatihan);


				$data_user = array(
					'token'				  	    => $token,
					'username' 					=> $username,
					'password' 					=> $this->bcrypt->hash_password($password),
					'email' 					=> $username,
					'fullname' 					=> $nama_lengkap,
					'foto_profile' 				=> $file_foto,
					'blokir' 					=> escape($this->input->post('blokir', TRUE)),
					'id_status' 				=> escape($this->input->post('status', TRUE)),
					'validate_email_code'		=> '',
					'validate_email_status'		=> 0,
					'reset_password_code'		=> '',
					'reset_password_status'		=> 0,
					'reset_password_expired'	=> 0,
					'create_by' 				=> $create_by,
					'create_date' 				=> $create_date,
					'create_ip' 				=> $create_ip,
					'mod_by' 					=> $create_by,
					'mod_date' 					=> $create_date,
					'mod_ip' 					=> $create_ip
				);
				/*cek username yang diinputkan*/
				$this->db->where('username', $username);
				$qTot = $this->db->count_all_results('xi_sa_users');
				if ($qTot > 0)
					return array('response' => 'USERNAME');
				else {
					/*query insert*/
					$this->db->insert('xi_sa_users', $data_user);
					$id_users = $this->db->insert_id();
					/*query insert user password*/
					$this->db->insert('xi_sa_users_default_pass', array('id_users' => $id_users, 'pass_plain' => $password, 'updated' => 'N'));
					/*query insert user group privileges*/
					$this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => '9', 'id_status' => 1));
					return array('response' => 'SUCCESS', 'nikID' => $nik);
				}
			}
		}
	}

	private function getHistory($id_peserta)
	{
		$this->db->select('a.id_peserta,
							b.tahun,
							b.tanggal_daftar
							');
		$this->db->from('data_peserta a');
		$this->db->join('data_history_pelatihan b', 'a.id_peserta = b.id_peserta', 'inner');
		$this->db->where('a.id_peserta', $id_peserta);
		$query = $this->db->get();
		return $query->row_array();
	}

	/* Fungsi untuk update data */
	public function updateDataPeserta()
	{
		//get data
		$create_by   = $this->app_loader->current_account();
		$opd_id      = $this->app_loader->current_opdid();
		$create_date = date('Y-m-d H:i:s');
		$create_ip   = $this->input->ip_address();
		$token   	 	= escape($this->input->post('tokenId', TRUE));
		$nik	 	 	= escape($this->input->post('nik', TRUE));
		$nama_lengkap 	= escape($this->input->post('nama_lengkap', TRUE));
		$id_pelatihan	= escape($this->input->post('id_pelatihan', TRUE));
		$username	 	= escape($this->input->post('username', TRUE));
		$password 	 	= escape($this->input->post('password', TRUE));
		$file_data    	= $_FILES['upload_foto']['name'];
		$foto_old  	  	= escape($this->input->post('fotoshow', TRUE));

		//cek data pendamping by id
		$checkData  	= $this->getDataPesertaByToken($token);
		$id_peserta 	= !empty($checkData) ? $checkData['id_peserta'] : 0;
		$dataHistory 	= $this->getDataHistoryPel($nik);
		$idPel 			= !empty($dataHistory) ? $dataHistory['id_pelatihan'] : 0;

		$dataTahun 			= $this->getHistory($id_peserta);
		$peserta 	   		= !empty($dataTahun) ? $dataTahun['id_peserta'] : 0;
		$tahun 	   			= !empty($dataTahun) ? $dataTahun['tahun'] : 0;
		$regist 			= !empty($dataTahun) ? $dataTahun['tanggal_daftar'] : 0;

		if (count($checkData) <= 0) {
			return array('response' => 'NODATA', 'nikID' => $nik);
			// } else if ($idPel != 0) {
			// 	return array('response' => 'FOUND', 'nikID' => $nik);
		} else {
			//cek data
			$this->db->where('token !=', $token);
			$this->db->where('nik', $nik);
			$qTot = $this->db->count_all_results('data_peserta');
			if ($qTot > 0)
				return array('response' => 'ERROR', 'nikID' => $nik);
			else {

				if ($file_data != '' or $foto_old == '') {
					$dirname 	   	= 'assets/img/avatar';
					if (!is_dir($dirname)) {
						mkdir('./' . $dirname, 0777, TRUE);
					}
					//cek upload file foto	
					$config = array(
						'upload_path'	 	=> './' . $dirname . '/',
						'allowed_types' 	=> 'png|jpg|jpeg',
						'file_type'         => 'image/jpeg|image/png|image/jpg',
                		'is_image'          => 1,
						'file_name' 		=> 'foto_' . $token,
						'file_ext_tolower'	=> TRUE,
						'max_size' 			=> 3072,
						'max_filename' 		=> 0,
						'remove_spaces' 	=> TRUE
					);
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('upload_foto'))
						return array('response' => 'NOIMAGE');
					else {
						//hapus image
						if (file_exists(realpath('./' . $dirname . '/' . $foto_old))) {
							unlink(realpath('./' . $dirname . '/' . $foto_old));
						}
						$upload_data = $this->upload->data();
						$file_foto = $upload_data['file_name'];
					}
				} else {
					$file_foto = $foto_old;
				}
				$data = array(
					'token'				  	    => $token,
					'nik' 						=> $nik,
					'nama_lengkap' 				=> $nama_lengkap,
					'tempat_lhr' 				=> escape($this->input->post('tempat_lhr', TRUE)),
					'tanggal_lhr' 				=> escape($this->input->post('tanggal_lhr', TRUE)),
					'alamat_peserta' 			=> escape($this->input->post('alamat_peserta', TRUE)),
					'no_hp' 					=> escape($this->input->post('no_hp', TRUE)),
					'id_study' 					=> escape($this->input->post('id_study', TRUE)),
					'id_agama' 					=> escape($this->input->post('id_agama', TRUE)),
					'id_gender' 				=> escape($this->input->post('id_gender', TRUE)),
					'id_province' 				=> escape($this->input->post('province', TRUE)),
					'id_regency' 				=> escape($this->input->post('regency', TRUE)),
					'kode_pos' 					=> escape($this->input->post('kode_pos', TRUE)),
					'pekerjaan' 				=> escape($this->input->post('pekerjaan', TRUE)),
					'id_jenis_akun' 			=> escape($this->input->post('id_jenis_akun', TRUE)),
					'minat_usaha' 			    => escape($this->input->post('minat_usaha', TRUE)),
					'upload_foto' 				=> $file_foto,
					'create_by' 				=> $create_by,
					'create_date' 				=> $create_date,
					'create_ip' 				=> $create_ip,
					'mod_by' 					=> $create_by,
					'mod_date' 					=> $create_date,
					'mod_ip' 					=> $create_ip
				);
				/*query insert*/
				$this->db->where('token', $token);
				$this->db->update('data_peserta', $data);

				if ($peserta == NULL) {
					$data_pelatihan = array(
						'id_pelatihan'      => $id_pelatihan,
						'id_opd'    	    => $opd_id,
						'id_peserta'    	=> $id_peserta,
						'tahun'   			=> $tahun,
						'flag'   			=> '1',
						'tanggal_daftar'   	=> $regist,
						'id_status'   	    => '1'
					);
					/*query insert*/
					$this->db->insert('data_history_pelatihan', $data_pelatihan);
				} else {
					$data_pelatihan = array(
						'id_pelatihan'      => $id_pelatihan,
						'id_opd'    	    => $opd_id,
						'id_peserta'    	=> $id_peserta,
					);
					/*query insert*/
					$this->db->where('id_peserta', $id_peserta);
					$this->db->update('data_history_pelatihan', $data_pelatihan);
				}

				$data_user = array(
					'fullname'  	=> $nama_lengkap,
					'username'  	=> $username,
					'foto_profile' 	=> $file_foto,
					'blokir'    	=> escape($this->input->post('blokir', TRUE)),
					'id_status' 	=> escape($this->input->post('status', TRUE)),
					'mod_by' 	  	=> $create_by,
					'mod_date'  	=> $create_date,
					'mod_ip'    	=> $create_ip
				);
				if ($password != "")
					$data_user = array_merge($data_user, array('password' => $this->bcrypt->hash_password($password)));
				//get data user by token
				$dataUser = $this->getDataUserByToken($token);
				$id_users = !empty($dataUser) ? $dataUser['id_users'] : 0;
				/*query update*/
				$this->db->where('id_users', $id_users);
				$this->db->where('token', $token);
				$this->db->update('xi_sa_users', $data_user);
				/*query update user password*/
				if ($password != "") {
					$this->db->set('pass_plain', $password);
					$this->db->where('id_users', abs($id_users));
					$this->db->update('xi_sa_users_default_pass');
				}
				return array('response' => 'SUCCESS', 'nikID' => $nik);
			}
		}
	}

	private function getDelete($token)
	{
		$this->db->select('a.token,
							a.id_peserta,
							b.tahun,
							b.tanggal_daftar
							');
		$this->db->from('data_peserta a');
		$this->db->join('data_history_pelatihan b', 'a.id_peserta = b.id_peserta', 'inner');
		$this->db->where('a.token', $token);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function deleteDataPeserta()
	{
		$peserta = escape($this->input->post('tokenId', TRUE));
		//jika ingin menghapus data lakukan looping
		foreach ($peserta as $id) {
			/*query delete*/
			// if(!$this->app_loader->is_super()) {
			// }
			$data_peserta 	= $this->getDataPesertaByToken($id);
			$data_history 	= $this->getDelete($id);
			$data_users 	= $this->getDataUserByToken($id);
			if (count($data_users) > 0) {
				$id_users 		= !empty($data_users) ? $data_users['id_users'] : 0;
				/*query delete*/
				$this->db->delete('xi_sa_users', array('id_users' => $id_users));
				$this->db->delete('xi_sa_users_privileges', array('id_users' => $id_users));
				$this->db->delete('xi_sa_users_default_pass', array('id_users' => $id_users));
			}
			if (count($data_history) > 0) {
				$id_peserta		= !empty($data_history) ? $data_history['id_peserta'] : 0;
				$this->db->delete('data_history_pelatihan', array('id_peserta' => $id_peserta));
			}
			if (count($data_peserta) > 0) {
				//hapus foto
				$upload_foto 	= !empty($data_peserta) ? $data_peserta['upload_foto'] : 0;
				unlink(realpath('./assets/img/avatar/' . $upload_foto));
				$this->db->where('token', $id);
				$this->db->delete('data_peserta');
			}
			return array('response' => 'SUCCESS');
		}
	}

	public function searchDataUser($username)
	{
		$this->db->where('username', $username);
		return $this->db->count_all_results('xi_sa_users');
	}

	public function sendMailAkunPeserta()
	{
		$peserta = escape($this->input->post('tokenId', TRUE));
		//jika ingin menghapus data lakukan looping
		foreach ($peserta as $id) {

			$dataAkun  		= $this->getDataDetailUsers($id);
			if (count($dataAkun) > 0) {
				$this->db->set('id_status', 0);
				$this->db->where('token', $id);
				$this->db->update('xi_sa_users');
				$fullname       = !empty($dataAkun) ? $dataAkun['fullname'] : '';
				$username       = !empty($dataAkun) ? $dataAkun['username'] : '';
				$pass_plain     = !empty($dataAkun) ? $dataAkun['pass_plain'] : '';
				$token     		= !empty($dataAkun) ? $dataAkun['token'] : '';
				$this->send_mail_new($fullname, $username, $pass_plain, $token);
			}
			return array('response' => 'SUCCESS');
		}
	}

	private function send_mail_new($fullname, $username, $pass_plain, $token)
	{
		$uri = 'auth/signin/do_validation/' . $token;
		//$url = str_replace(array('=','+','/'),array('-','_','~'),$this->encryption->encrypt($uri));
		$url = '';
		$subject = '(Verifikasi Account) Digital Talent Sumatera Barat';
		$message = '';
		$message .= '<html>';
		$message .= '<body style="padding: 0;margin: 0;">';
		$message .= '<table width="60%" style="padding: 0 0;font-family: "helvetica", Tahoma, Geneva, Verdana, sans-serif;">';
		$message .= '<tr>';
		$message .= '<td>';
		$message .= '<div style="background: orange;width: 100%;padding: 30px 0px;text-align: center;">';
		$message .= '<img src="https://103.143.71.188/digitaltalent/digital_talent.png" width="300px" alt="">';
		$message .= '</div>';
		$message .= '</td>';
		$message .= '</tr>';
		$message .= '<tr>';
		$message .= '<td style="padding: 0 10px;">';
		$message .= '<div style="text-align: center;padding: 10px 0;color:gray;">';
		$message .= '<h3>Halo, ' . $fullname . '</h3>';
		$message .= '<p>Selamat pendaftaran anda telah berhasil</p>';
		$message .= '<p style="font-size: 12px;">tinggal satu langkah lagi, silahkan melakukan verifikasi dengan mengklik <a href="' . base_url() . $uri . '">link ini </a></p>';
		$message .= '</div>';
		$message .= '<div style="padding:10px 10px; text-align: center;background: silver;border-radius: 7px;border: solid 1px silver;margin-bottom: 20px;">';
		$message .= '<p style="color:white;font-size: 12px; text-align: left;">Silahkan ingat dan jaga kerahasiaan username serta password anda.!</p>';
		$message .= '<p style="color:red;font-size: 12px; text-align: left;">Setelah berhasil login silahkan ubah password anda.!</p>';
		$message .= '<p style="color:black;font-size: 12px; text-align: left;">Username : ' . $username . ' <br/> Password : ' . $pass_plain . '</p>';
		$message .= '<p style="color:black;font-size: 12px;">Terima Kasih Telah Mempercayakan Digital Talent...</p>';
		$message .= '<p style="color:black;font-size: 10px; text-align: left;">Hati-hati dengan penipuan yang mengatasnamakan Panitia Digital Talent Sumatera Barat. Panitia tidak pernah meminta uang dalam seluruh proses..</p>';
		$message .= '</div>';
		$message .= '</td>';
		$message .= '</tr>';

		$message .= '<table width="100%">';
		$message .= '<tr>';
		$message .= '<td style="text-align:center;"><img src="http://ppid.sumbarprov.go.id/logo.png" width="200px" alt=""></td>';
		$message .= '<td style="text-align:center;"><img src="http://infopublik.sumbarprov.go.id/favicon.png" width="200px" alt=""></td>';
		$message .= '</tr>';
		$message .= '</table>';
		$message .= '</tr>';
		$message .= '<tr>';
		$message .= '<td>';
		$message .= '<div style="background: orange;width: 100%;padding: 10px 0px;text-align: center;margin-top: 30px;">';
		$message .= '<a href="sumbarprov.go.id">sumbarprov.go.id</a>';
		$message .= '</div>';
		$message .= '</td>';
		$message .= '</tr>';
		$message .= '</table>';
		$message .= '</body>';
		$message .= '</html>';

		$content1 = @file_get_contents("http://webmail.sumbarprov.go.id/kirim_email.php?subject=" . $subject . "&message=" . $message . "&email=" . $username . "");
		//echo $message;

	}

	public function import($table, $data)
	{
		$this->db->insert_batch($table, $data);
		if ($this->db->affected_rows() > 0) {
			// return array('response' => 'SUCCESS');
			return 1;
		} else {
			return 0;
			// return array('response' => 'ERROR');;
		}
	}

	public function get_nik_existance($nik)
	{
		$this->db->where('nik', $nik);
		$query = $this->db->get('data_peserta');
		return $query->row_array();
	}
	public function get_user_existance($email)
	{
		$this->db->where('username', $email);
		$query = $this->db->get('xi_sa_users');
		return $query->row_array();
	}
}

// This is the end of auth signin model
