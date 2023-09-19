<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of program model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_peserta extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
    }
    
    public function cekDataPeserta($email)
	{
		$this->db->select('a.*');
		$this->db->from('data_peserta a');
		$this->db->where('a.create_by', $email);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getDataUser($nik)
	{
		$this->db->select('a.id_peserta, a.nik, b.id_users');
		$this->db->where('a.nik', $nik);
		$this->db->from('data_peserta a');
		$this->db->join('xi_sa_users b', 'a.token = b.token', 'INNER');

		$query = $this->db->get();
		return $query->row_array();
	}

	public function getDataPeserta($nik)
	{
		$data = [];
		$this->db->select('a.*,b.id_users, b.username, c.name as provinsi, d.name as kabupaten, e.gender, f.agama, g.study');
		$this->db->from('data_peserta a');
		$this->db->join('xi_sa_users b', 'a.token = b.token', 'inner');
		$this->db->join('wa_province c', 'a.id_province = c.id', 'inner');
		$this->db->join('wa_regency d', 'a.id_regency = d.id', 'inner');
		$this->db->join('ref_gender e', 'a.id_gender = e.id_gender', 'inner');
		$this->db->join('ref_agama f', 'a.id_agama = f.id_agama', 'inner');
		$this->db->join('ref_pendidikan g', 'a.id_study = g.id_study', 'inner');
		$this->db->where('a.nik', $nik);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$dataraw = $query->row_array();
			$data = array(
				'id_peserta' => $dataraw['id_users'],
				'foto' => base_url('assets/img/avatar/'.$dataraw['upload_foto']),
				'token' => $dataraw['token'],
				'nik' => $dataraw['nik'],
				'nama_lengkap' => $dataraw['nama_lengkap'],
				'alamat_peserta' => $dataraw['alamat_peserta']. ", ". ucfirst($dataraw['kabupaten']) .", ". ucfirst($dataraw['provinsi']),
				'pekerjaan' => $dataraw['pekerjaan'],
				'ttl' => $dataraw['tempat_lhr']. ", ".tgl_indo($dataraw['tanggal_lhr']),
				'email' => $dataraw['username'],
				'gender' => $dataraw['gender'],
				'agama' => $dataraw['agama'],
				'pendidikan' => $dataraw['study'],
			);
		}
		return $data;
	}
	
	public function getGenderOptions()
	{
		$data = $this->db->get('ref_gender');
		$gender = [];
		if($data->num_rows() > 0){
			foreach($data->result_array() as $dt){
				$gender[] = ["value" => $dt["id_gender"], "label" => $dt['gender']];
			}
		}
		return $gender;
	}

	public function getProvince()
	{
		$data = $this->db->get('wa_province');
		$province = [];
		if($data->num_rows() > 0){
			foreach($data->result_array() as $dt){
				$province[] = ["value" => $dt["id"], "label" => $dt['name']];
			}
		}
		return $province;
	}

	public function getRegency($id_province)
	{
		$this->db->where('province_id', $id_province);
		$data = $this->db->get('wa_regency');
		$regency = [];
		if($data->num_rows() > 0){
			foreach($data->result_array() as $dt){
				$regency[] = ["value" => $dt["id"], "label" => $dt['name']];
			}
		}
		return $regency;
	}

	public function getAgama()
	{
		$data = $this->db->get('ref_agama');
		$agama = [];
		if($data->num_rows() > 0){
			foreach($data->result_array() as $dt){
				$agama[] = ["value" => $dt["id_agama"], "label" => $dt['agama']];
			}
		}
		return $agama;
	}

	public function getStudy()
	{
		$data = $this->db->get('ref_pendidikan');
		$study = [];
		if($data->num_rows() > 0){
			foreach($data->result_array() as $dt){
				$study[] = ["value" => $dt["id_study"], "label" => $dt['study']];
			}
		}
		return $study;
	}

	public function insertDataPeserta($foto) {
		//get data
		$create_by   	= escape($this->input->post('email', TRUE));
		$create_date 	= date('Y-m-d H:i:s');
		$create_ip   	= $this->input->ip_address();
		$nik	 	 	= escape($this->input->post('nik', TRUE));
		$nama_lengkap 	= escape($this->input->post('nama_lengkap', TRUE));
		$username	 	= escape($this->input->post('email', TRUE));
		$password 	 	= escape($this->input->post('password', TRUE));
		$token		 	= generateToken($nik, $nama_lengkap);
		
		/*cek nik yang diinputkan*/
		$this->db->where('nik', $nik);
		$qTot = $this->db->count_all_results('data_peserta');
		if($qTot > 0)
			return array('response'=>'ERROR', 'nikID'=>$nik);
		else {
			
                $data = array(
                'token'				  	    => $token,
                'nik' 						=> $nik,
                'nama_lengkap' 				=> $nama_lengkap,
                'upload_foto' 				=> $foto,
                'tempat_lhr' 				=> escape($this->input->post('tempat_lhr', TRUE)),
                'tanggal_lhr' 				=> escape($this->input->post('tanggal_lhr', TRUE)),
                'alamat_peserta' 			=> escape($this->input->post('alamat_peserta', TRUE)),
                'id_study' 					=> escape($this->input->post('id_study', TRUE)),
                'id_agama' 					=> escape($this->input->post('id_agama', TRUE)),
                'id_gender' 				=> escape($this->input->post('id_gender', TRUE)),
                'id_province' 				=> escape($this->input->post('id_province', TRUE)),
                'id_regency' 				=> escape($this->input->post('id_regency', TRUE)),
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

            $data_user = array(
                'token'				  	    => $token,
                'username' 					=> $username,
                'password' 					=> $this->bcrypt->hash_password($password),
                'email' 					=> $username,
                'fullname' 					=> $nama_lengkap,
                // 'foto_profile' 				=> 'default-user-icon.jpg',
                'foto_profile' 				=> $foto,
                'blokir' 					=> 0,
                'id_status' 				=> 1,
                'validate_email_code'		=> '',
                'validate_email_status'		=> 1,
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
                if($qTot > 0)
                    return array('response'=>'USERNAME');
                else {
                    /*query insert*/
                    $this->db->insert('xi_sa_users', $data_user);
                    $id_users = $this->db->insert_id();
                    /*query insert user password*/
                    $this->db->insert('xi_sa_users_default_pass', array('id_users' => $id_users, 'pass_plain' => $password, 'updated' => 'N'));
                    /*query insert user group privileges*/
                    $this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => '9', 'id_status' => 1));

                    // $this->send_mail_new($nama_lengkap, $username, $password, $token);
                    return array('response'=>'SUCCESS', 'nikID'=>$nik, 'id_jenis_akun'=> escape($this->input->post('id_jenis_akun', TRUE)));
                }
		}
	}
}

// This is the end of auth signin model
