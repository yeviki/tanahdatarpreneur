<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of auth signin model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_auth_signin extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    /*Fungsi get data edit by id*/
    public function getDataDetailPelatihan($id) {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.nm_sub_kegiatan,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           GROUP_CONCAT(f.nm_syarat ORDER BY a.id_pelatihan ASC SEPARATOR ",") AS group_syarat
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->where('a.token', $id);
        $query = $this->db->get('data_pelatihan');
        return $query->row_array();
    }

    /*Fungsi Get Data List*/
    var $search = array('d.nm_pelatihan', 'b.id_jenis_kegiatan', 'b.mulai_registrasi');
    public function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $date = date('Y-m-d');
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.nm_sub_kegiatan,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           GROUP_CONCAT(f.nm_syarat ORDER BY a.id_pelatihan ASC SEPARATOR ",") AS group_syarat
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->where('b.akhir_registrasi >=', $date);
        return $this->db->count_all_results();
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.nm_sub_kegiatan,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           GROUP_CONCAT(f.nm_syarat ORDER BY a.id_pelatihan ASC SEPARATOR ",") AS group_syarat
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $date = date('Y-m-d');
        $this->db->where('b.akhir_registrasi >=', $date);
        $i = 0;
        foreach ($this->search as $item) { // loop column
            if($_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $this->db->order_by('a.id_pelatihan DESC');
        $this->db->order_by('b.mulai_registrasi DESC');
    }

    public function cekDataUsername($username) {
        $this->db->where('username', escape($username));
        $this->db->order_by('id_users', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('xi_sa_users');
        return $query->row_array();
    }

    public function cekDataUsernamePass($username, $password) {
        $getUser = $this->cekDataUsername($username);
        $hash_password = !empty($getUser) ? $getUser['password'] : "";
        if ($this->bcrypt->check_password($password, $hash_password))
            return TRUE;
        else
            return FALSE;
    }

    public function cekDataUserActive($username) {
        $getUser = $this->cekDataUsername($username);
        $active = !empty($getUser) ? $getUser['id_status'] : 0;
        if ($active == 1)
            return TRUE;
        else
            return FALSE;
    }

    public function cekDataUserBlock($username) {
        $getUser = $this->cekDataUsername($username);
        $blokir = !empty($getUser) ? $getUser['blokir'] : 0;
        if ($blokir != 0)
            return TRUE;
        else
            return FALSE;
    }

    public function getDataUserGroup($username) {
        $this->db->select('g.id_group,
						   g.nama_group,
						   g.id_level_akses');
        $this->db->from('xi_sa_group g');
        $this->db->join('xi_sa_users_privileges up', 'g.id_group = up.id_group', 'inner');
        $this->db->join('xi_sa_users u', 'up.id_users = u.id_users', 'inner');
        $this->db->where('g.id_status', 1);
        $this->db->where('up.id_status', 1);
        $this->db->where('u.username', escape($username));
        $this->db->where('u.id_status', 1);
        $this->db->where('u.blokir', 0);
        $this->db->order_by('g.id_group', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDataUserProperties($username, $group) {
        $this->db->select('u.id_users,
                           u.token,
                           u.username,
                           u.email,
                           u.fullname,
                           u.foto_profile,
                           u.id_opd,
                           up.id_group,
                           g.nama_group,
                           g.id_level_akses,
                           la.level_akses,
                           la.nick_level,
                           ps.id_peserta,
                           ps.nik,
                           ps.id_peserta
                        ');
        $this->db->from('xi_sa_users u');
        $this->db->join('xi_sa_users_privileges up', 'u.id_users = up.id_users', 'inner');
        $this->db->join('xi_sa_group g', 'up.id_group = g.id_group', 'inner');
        $this->db->join('xi_sa_level_akses la', 'g.id_level_akses = la.id_level_akses', 'inner');
        $this->db->join('data_peserta ps', 'u.token = ps.token', 'left');
        $this->db->where('u.username', escape($username));
        $this->db->where('u.id_status', 1);
        $this->db->where('u.blokir', 0);
        $this->db->where('up.id_status', 1);
        $this->db->where('g.id_status', 1);
        $this->db->where('g.id_group', abs($group));
        $this->db->order_by('u.id_users');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function setLoginFailed($username, $ip_address, $user_agent) {
        $expiration = time()-3600;
        //delete fail login yang Lalu
        $this->db->where('login_time <', $expiration);
        $this->db->delete('xi_sa_log_login');
        //baru insert
        if($this->cekDataUserBlock($username) == FALSE){
            $data = array(
                'username' 		=> $username,
                'login_time'	=> time(),
                'ip_address'	=> $ip_address,
                'user_agent'	=> $user_agent
            );
            $this->db->insert('xi_sa_log_login', $data);
        }
    }

    public function getCountFailedLog($username) {
        $expiration = 3600;
        $this->db->where('username', $username);
        $this->db->where('login_time >', $expiration);
        $this->db->order_by('id_log', 'DESC');
        $query = $this->db->get('xi_sa_log_login');
        return $query;
    }

    public function setAccountUserBlock($username) {
        $this->db->set('blokir', 1);
        $this->db->where('blokir', 0);
        $this->db->where('username', $username);
        $this->db->update('xi_sa_users');
    }

    public function deleteFailedLog($username) {
        $this->db->where('username', $username);
        $this->db->delete('xi_sa_log_login');
    }

    public function setSuccessLog($username, $ip_address, $user_agent) {
        $date_array     = getdate();
        $session_time   = date('c',$date_array[0]);
        $session_value 	= $this->encryption->encrypt($session_time);
        $login_time     = time();
        $session = array('AppTppOnline@2020session' => $session_value);
        $this->session->set_userdata($session);
        $getUser = $this->cekDataUsername($username);
        if(count($getUser) > 0) {
            $data = array(
                'id_users' 		=> $getUser['id_users'],
                'username' 		=> $username,
                'login_time'	=> $login_time,
                'ip_address'	=> $ip_address,
                'user_agent'	=> $user_agent,
                'id_status'		=> 1,
                'session_id'	=> $session_value
            );
            $this->db->insert('xi_sa_log_session', $data);
        }
        $result = (count($getUser) > 0) ? 'authtoken='.urlencode($session_value).'&time='.$login_time.'&ipaddress='.$ip_address.'&user='.$username : '';
        return $result;
    }

    public function updateDataSessionLog($session_id, $username, $ip_address, $user_agent) {
        $this->db->set('id_status', 0);
        $this->db->where('session_id', $session_id);
        $this->db->where('username', $username);
        //$this->db->where('ip_address', $ip_address);
        $this->db->where('user_agent', $user_agent);
        $this->db->update('xi_sa_log_session');
        return TRUE;
    }

    public function getDataSessionLog($username, $ip_address, $user_agent, $session_id) {
        $this->db->where('username', $username);
        //$this->db->where('ip_address', $ip_address);
        $this->db->where('user_agent', $user_agent);
        $this->db->where('session_id', $session_id);
        $this->db->where('id_status', 1);
        $this->db->order_by('id_log_session', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('xi_sa_log_session');
        return $query->row_array();
    }

    public function cekSessionLog($username, $ip_address, $user_agent, $session_id) {
        $data = $this->getDataSessionLog($username, $ip_address, $user_agent, $session_id);
        if(count($data) > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function cekSessionLogUser($username, $session_id, $ip_address, $login_time, $user_agent) {
        $this->db->where('username', $username);
        $this->db->where('login_time', $login_time);
        $this->db->where('ip_address', $ip_address);
        $this->db->where('user_agent', $user_agent);
        $this->db->where('session_id', $session_id);
        $this->db->where('id_status', 1);
        $this->db->order_by('id_log_session', 'DESC');
        $this->db->limit(1);
        $query = $this->db->count_all_results('xi_sa_log_session');
        return $query;
    }

    public function getDataUserRulesModule($username, $id_group) {
        $rules_access = array();
        $this->db->select('a.id_rules,
                           b.id_module,
                           b.id_kontrol,
                           b.id_fungsi,
                           c.nama_module,
                           c.url_module,
                           d.nama_kontrol,
                           d.url_kontrol,
                           e.nama_fungsi,
                           e.url_fungsi');
        $this->db->from('xi_sa_group_privileges a');
        $this->db->join('xi_sa_rules b', 'a.id_rules = b.id_rules', 'inner');
        $this->db->join('xi_sa_module c', 'b.id_module = c.id_module', 'inner');
        $this->db->join('xi_sa_kontrol d', 'b.id_kontrol = d.id_kontrol', 'inner');
        $this->db->join('xi_sa_fungsi e', 'b.id_fungsi = e.id_fungsi', 'inner');
        $this->db->where('a.id_group', abs($id_group));
        $this->db->where('a.id_status', 1);
        $this->db->where('b.id_status', 1);
        $this->db->where('c.id_status', 1);
        $this->db->where('d.id_status', 1);
        $this->db->where('e.id_status', 1);
        $this->db->order_by('b.id_rules', 'ASC');
        $query = $this->db->get();

        if(!empty($username)){
            foreach ($query->result_array() as $k => $v) {
                $url = $v['url_module'].'/'.$v['url_kontrol'].'/'.$v['url_fungsi'];
                $rules_access[] = str_replace('-', '_', $url);
            }
        }

        return $rules_access;
    }

    public function getDataWhiteList($module, $class, $method) {
        $this->db->where('module_name', $module);
        $this->db->where('class_name', $class);
        $this->db->where('method_name', $method);
        $this->db->where('id_status', 1);
        $query = $this->db->count_all_results('xi_sa_white_list');
        if($query > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function getDataRegencyByProvince($id) {
		$this->db->where('province_id', $id);
        $this->db->order_by('status ASC');
		$this->db->order_by('name ASC');
		$query = $this->db->get('wa_regency');
        return $query->result_array();
    }

    public function searchDataUsername($username) {
		$this->db->where('username', $username);
		return $this->db->count_all_results('xi_sa_users');
    }

    /* Fungsi untuk insert data */
	public function insertDataPeserta() {
		//get data
		$create_by   	= $this->app_loader->current_account();
		$create_date 	= date('Y-m-d H:i:s');
		$create_ip   	= $this->input->ip_address();
		$nik	 	 	= escape($this->input->post('nik', TRUE));
		$nama_lengkap 	= escape($this->input->post('nama_lengkap', TRUE));
        $upload_foto    = escape($this->input->post('upload_foto', TRUE));
		$username	 	= escape($this->input->post('username_signup', TRUE));
		$password 	 	= escape($this->input->post('password_signup', TRUE));
		$token		 	= generateToken($nik, $nama_lengkap);
		
		/*cek nik yang diinputkan*/
		$this->db->where('nik', $nik);
		$qTot = $this->db->count_all_results('data_peserta');
		if($qTot > 0)
			return array('response'=>'ERROR', 'nikID'=>$nik);
		else {
			$config = array(
				'upload_path'	 	=> './assets/img/avatar/',
				'allowed_types' 	=> 'png|jpg|jpeg',
				'file_name' 		=> 'foto_'.$token,
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 3072,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE
			);
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
                if (!$this->upload->do_upload('upload_foto')) {
                    $file_upload = '';
                } else {
                    $upload_data = $this->upload->data();
                    $file_upload = $upload_data['file_name'];
                }
                $data = array(
                'token'				  	    => $token,
                'nik' 						=> $nik,
                'nama_lengkap' 				=> $nama_lengkap,
                'upload_foto' 				=> $file_upload,
                'tempat_lhr' 				=> escape($this->input->post('tempat_lhr', TRUE)),
                'tanggal_lhr' 				=> escape($this->input->post('tanggal_lhr', TRUE)),
                'alamat_peserta' 			=> escape($this->input->post('alamat_peserta', TRUE)),
                'no_hp' 			        => escape($this->input->post('no_hp', TRUE)),
                'id_study' 					=> escape($this->input->post('id_study', TRUE)),
                'id_agama' 					=> escape($this->input->post('id_agama', TRUE)),
                'id_gender' 				=> escape($this->input->post('id_gender', TRUE)),
                'id_province' 				=> escape($this->input->post('province', TRUE)),
                'id_regency' 				=> escape($this->input->post('regency', TRUE)),
                'kode_pos' 					=> escape($this->input->post('kode_pos', TRUE)),
                'pekerjaan' 				=> escape($this->input->post('pekerjaan', TRUE)),
                'id_jenis_akun' 			=> escape($this->input->post('id_jenis_akun', TRUE)),
                'minat_usaha' 			    => escape($this->input->post('minat_usaha', TRUE)),
                'create_by' 				=> $nik,
                'create_date' 				=> $create_date,
                'create_ip' 				=> $create_ip,
                'mod_by' 					=> $nik,
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
                'foto_profile' 				=> $file_upload,
                'blokir' 					=> 0,
                'id_status' 				=> 1,
                'validate_email_code'		=> '',
                'validate_email_status'		=> 0,
                'reset_password_code'		=> '',
                'reset_password_status'		=> 0,
                'reset_password_expired'	=> 0,
                'create_by' 				=> $nik,
                'create_date' 				=> $create_date,
                'create_ip' 				=> $create_ip,
                'mod_by' 					=> $nik,
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
                    return array('response'=>'SUCCESS', 'nikID'=>$nik);
                }
		}
    }
    
    // private function send_mail_new($nama_lengkap, $username, $password, $token)
    // {
    //   $uri = 'auth/signin/do_validation/'.$token;
    //   //$url = str_replace(array('=','+','/'),array('-','_','~'),$this->encryption->encrypt($uri));
    //   $url = '';
    //   $subject ='(Verifikasi Account) Digital Talent Sumatera Barat';
    //   $message = '';
    //   $message .= '<html>';
    //   $message .= '<body style="padding: 0;margin: 0;">';
    //   $message .= '<table width="60%" style="padding: 0 0;font-family: "helvetica", Tahoma, Geneva, Verdana, sans-serif;">';
    //   $message .= '<tr>';
    //   $message .= '<td>';
    //   $message .= '<div style="background: orange;width: 100%;padding: 30px 0px;text-align: center;">';
    //   $message .= '<img src="https://103.143.71.188/digitaltalent/digital_talent.png" width="300px" alt="">';
    //   $message .= '</div>';
    //   $message .= '</td>';
    //   $message .= '</tr>';
    //   $message .= '<tr>';
    //   $message .= '<td style="padding: 0 10px;">';
    //   $message .= '<div style="text-align: center;padding: 10px 0;color:gray;">';
    //   $message .= '<h3>Halo, '.$nama_lengkap.'</h3>';
    //   $message .= '<p>Selamat pendaftaran anda telah berhasil</p>';
    //   $message .= '<p style="font-size: 12px;">tinggal satu langkah lagi, silahkan melakukan verifikasi dengan mengklik <a href="'.base_url().$uri.'">link ini </a></p>';
    //   $message .= '</div>';
    //   $message .= '<div style="padding:10px 10px; text-align: center;background: silver;border-radius: 7px;border: solid 1px silver;margin-bottom: 20px;">';
    //   $message .= '<p style="color:white;font-size: 12px; text-align: left;">Silahkan ingat dan jaga kerahasiaan username serta password anda.!</p>';
    //   $message .= '<p style="color:red;font-size: 12px; text-align: left;">Setelah berhasil login silahkan ubah password anda.!</p>';
    //   $message .= '<p style="color:black;font-size: 12px; text-align: left;">Username : '.$username.' <br/> Password : '.$password.'</p>';
    //   $message .= '<p style="color:black;font-size: 12px;">Terima Kasih Telah Mempercayakan Digital Talent...</p>';
    //   $message .= '<p style="color:black;font-size: 10px; text-align: left;">Hati-hati dengan penipuan yang mengatasnamakan Panitia Digital Talent Sumatera Barat. Panitia tidak pernah meminta uang dalam seluruh proses..</p>';
    //   $message .= '</div>';
    //   $message .= '</td>';
    //   $message .= '</tr>';

    //   $message .= '<table width="100%">';
    //   $message .= '<tr>';
    //   $message .= '<td style="text-align:center;"><img src="http://ppid.sumbarprov.go.id/logo.png" width="200px" alt=""></td>';
    //   $message .= '<td style="text-align:center;"><img src="http://infopublik.sumbarprov.go.id/favicon.png" width="200px" alt=""></td>';
    //   $message .= '</tr>';
    //   $message .= '</table>';
    //   $message .= '</tr>';
    //   $message .= '<tr>';
    //   $message .= '<td>';
    //   $message .= '<div style="background: orange;width: 100%;padding: 10px 0px;text-align: center;margin-top: 30px;">';
    //   $message .= '<a href="sumbarprov.go.id">sumbarprov.go.id</a>';
    //   $message .= '</div>';
    //   $message .= '</td>';
    //   $message .= '</tr>';
    //   $message .= '</table>';
    //   $message .= '</body>';
    //   $message .= '</html>';

    //   $content1 = @file_get_contents("http://webmail.sumbarprov.go.id/kirim_email.php?subject=".$subject."&message=".$message."&email=".$username."");
    //   //echo $message;
     
    // }

    public function getDataUserByToken($token) {
		$this->db->where('token', $token);
		$query = $this->db->get('xi_sa_users');
		return $query->row_array();
	}

    public function updateDataValidation($token)
	{
        $this->db->set('id_status', 1);
        $this->db->where('token', $token);
        $this->db->update('xi_sa_users');
        return TRUE;
	}
}

// This is the end of auth signin model
