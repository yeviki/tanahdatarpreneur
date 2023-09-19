<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of login class
 *
 * @author Yogi "solop" Kaputra
 */

class Signin extends MY_Controller {
    protected $username		= "";
    protected $password 	= "";
    protected $ip_address   = "";
    protected $user_agent   = "";
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_auth_signin' => 'mas', 'master/model_master' => 'mmas'));
        $this->username 	= escape(trim($this->input->post('username', TRUE)));
        $this->password 	= escape($this->input->post('password', TRUE));
        $this->ip_address   = addslashes($this->input->ip_address());
        $this->user_agent   = addslashes($this->input->user_agent());
    }

    private function validationValueCheck($role) {
        if($role == 1) {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
        } else {
            $this->form_validation->set_rules('groupid', 'Group', 'required|trim');
        }
        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function login() {
        $flag = escape($this->encryption->decrypt($this->input->post('authorization', TRUE)));
        if($flag == 'login')
            $this->prosesLoginForm();
        else if($flag == 'group')
            $this->prosesSelectGroupForm();
        else
            $this->createLoginForm();
    }

    public function account() {
        $sessid = $this->input->get('authtoken', TRUE);
        $time   = $this->input->get('time', TRUE);
        $ip     = $this->input->get('ipaddress', TRUE);
        $user   = $this->input->get('user', TRUE);
        //cek url
        $data = $this->mas->cekSessionLogUser($user, $sessid, $ip, $time, $this->user_agent);
        if($data > 0)
            redirect('home');
        else
            redirect('auth/signin/logout');
    }

    private function createLoginForm() {
        $setApps = setApps();
        $data['appName']   = !empty($setApps) ? $setApps['app_name'] : '';
        $data['appAuthor'] = !empty($setApps) ? $setApps['app_author'] : '';
        $data['appDescs']  = !empty($setApps) ? $setApps['app_description'] : '';
        $data['appKeys']   = !empty($setApps) ? $setApps['app_keywords'] : '';
        $data['appIcon']   = !empty($setApps) ? $setApps['app_icon'] : '';
        $data['appFavico'] = !empty($setApps) ? $setApps['app_favicon'] : '';
        $data['appYear']   = !empty($setApps) ? $setApps['app_year'] : '';
        $data['data_study']       = $this->mmas->getDataStudy();
        $data['data_agama']       = $this->mmas->getDataAgama();
        $data['data_gender']      = $this->mmas->getDataGender();
        $data['data_provinsi']    = $this->mmas->getProvinsi();
        $data['data_usaha']       = $this->mmas->getJenisAkun();
        $this->load->view('formLogin', $data);
    }

    private function prosesLoginForm() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $csrfHash   = $this->security->get_csrf_hash();
            $total      = $this->session->userdata('error_session');
            if($this->validationValueCheck(1) == FALSE) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'flag' => 1, 'csrfHash' => $csrfHash);
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
            } else {
                //cek username yang diinputkan pertama
                $checkUser = $this->is_username($this->username);
                if(empty($checkUser) OR count($checkUser) <= 0) {
                    //insert error ke dalam session
                    $this->set_error_session();
                    $result = array('status' => 0, 'message' => array('isi' => 'Username tidak ditemukan'), 'flag' => 1, 'csrfHash' => $csrfHash);
                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                } else {
                    //cek username dan password
                    if($this->is_password($this->username, $this->password) === FALSE) {
                        //insert error log ke table log login
                        $this->mas->setLoginFailed($this->username, $this->ip_address, $this->user_agent);
                        $blockir = $this->cek_blockir($this->username);
                        if($blockir >= 5 && $blockir < 10) {
                            $result = array('status' => 0, 'message' => array('isi' => 'Anda sudah '.$blockir.' kali salah menginputkan password, batas kesalahan 10 kali. Jika masih salah akun anda akan diblokir otomatis oleh sistem...'), 'flag' => 1, 'csrfHash' => $csrfHash);
                            $this->output->set_content_type('application/json')->set_output(json_encode($result));
                        } else if($blockir >= 10) {
                            $this->mas->setAccountUserBlock($this->username);
                            $result = array('status' => 0, 'message' => array('isi' => 'Akun anda telah diblokir oleh sistem, silahkan hubungi admin...'), 'flag' => 1, 'csrfHash' => $csrfHash);
                            $this->output->set_content_type('application/json')->set_output(json_encode($result));
                        } else {
                            $result = array('status' => 0, 'message' => array('isi' => 'Username dan Password anda tidak cocok'), 'flag' => 1, 'csrfHash' => $csrfHash);
                            $this->output->set_content_type('application/json')->set_output(json_encode($result));
                        }
                        //insert error ke dalam session
                        $this->set_error_session();
                    } else {
                        //cek akun aktif atau tidak
                        if($this->is_actived($this->username) === FALSE) {
                            $result = array('status' => 0, 'message' => array('isi' => 'Akun anda belum aktif, silahkan lakukan verifikasi akun pada email anda, atau silahkan hubungi admin'), 'flag' => 1, 'csrfHash' => $csrfHash);
                            $this->output->set_content_type('application/json')->set_output(json_encode($result));
                        } else {
                            //cek akun blokir atau tidak
                            if($this->is_blockir($this->username) === TRUE) {
                                $result = array('status' => 0, 'message' => array('isi' => 'Akun anda saat ini sedang diblokir, silahkan hubungi admin'), 'flag' => 1, 'csrfHash' => $csrfHash);
                                $this->output->set_content_type('application/json')->set_output(json_encode($result));
                            } else {
                                //set session username
                                $this->session->set_userdata('account_name', $this->username);
                                //delete failed log
                                $this->mas->deleteFailedLog($this->username);
                                //ambil group user
                                $getGroup = $this->mas->getDataUserGroup($this->username);
                                if(count($getGroup) > 1) {
                                    //multi group
                                    $fullname   = !empty($checkUser) ? $checkUser['fullname'] : '';
                                    $avatar 	= !empty($checkUser) ? $checkUser['foto_profile'] : '';
                                    $result     = array('status' => 2, 'message' => $this->load->view('formGroup', array('multi_group' => $getGroup, 'fullname' => $fullname, 'username' => $this->username, 'foto' => $avatar), TRUE), 'flag' => 2, 'csrfHash' => $csrfHash);
                                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                                } else if(count($getGroup) == 1) {
                                    //insert success login
                                    $dataLog = $this->mas->setSuccessLog($this->username, $this->ip_address, $this->user_agent);
                                    //set login time
                                    $this->expired_login->login_time();
                                    //set session satu group
                                    $this->set_session($this->username, $getGroup[0]['id_group']);
                                    $result = array('status' => 1, 'message' => array('url' => site_url('auth/signin/account?'.$dataLog)), 'flag' => 1, 'csrfHash' => $csrfHash);
                                    $this->output->set_content_type('application/json')->set_output(json_encode($result));
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function prosesSelectGroupForm() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $csrfHash   = $this->security->get_csrf_hash();
            $username   = $this->session->userdata('account_name');
            $group 	    = $this->encryption->decrypt($this->input->post('groupid', TRUE));
            if($this->validationValueCheck(2) == FALSE) {
                $result = array('status' => 0, 'message' => array('isi' => 'Anda harus pilih salah satu group untuk bisa login'), 'flag' => 2, 'csrfHash' => $csrfHash);
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
            } else {
                //insert success login
                $dataLog = $this->mas->setSuccessLog($username, $this->ip_address, $this->user_agent);
                //set login time
                $this->expired_login->login_time();
                //set session user
                $this->set_session($username, $group);
                //set group session
                $this->set_group_session($username);
                $result = array('status' => 1, 'message' => array('url' => site_url('auth/signin/account?'.$dataLog)), 'flag' => 2, 'csrfHash' => $csrfHash);
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
            }
        }
    }

    private function is_username($username) {
        $data = $this->mas->cekDataUsername($username);
        return $data;
    }

    private function is_password($username, $password) {
        $validpass = $this->mas->cekDataUsernamePass($username, $password);
        return $validpass;
    }

    private function is_actived($username) {
        $actived = $this->mas->cekDataUserActive($username);
        return $actived;
    }

    private function is_blockir($username) {
        $blocked = $this->mas->cekDataUserBlock($username);
        return $blocked;
    }

    private function cek_blockir($username) {
        $log = $this->mas->getCountFailedLog($username);
        return $log->num_rows();
    }

    /**
     * Fungsi untuk melakukan hitung error login
     */
    private function set_error_session() {
        $getError = $this->session->userdata('error_session');
        $num = isset($getError) ? $getError : 0;
        $this->session->set_userdata('error_session', $num+1);
    }

    private function set_session($username, $group) {
        //ambil data user berdasarkan group
        $dataUser = $this->mas->getDataUserProperties($username, $group);
        if(count($dataUser) > 0) {
            $session['fullname']  			= $dataUser['fullname'];
            $session['group_active']		= $dataUser['id_group'];
            $session['group_name']			= $dataUser['nama_group'];
            $session['level_akses']			= $dataUser['level_akses'];
            $session['nick_level']			= $dataUser['nick_level'];
            $session['user_id']			    = $dataUser['token'];
            $session['opd_id']			    = $dataUser['id_opd'];
            $session['peserta_id']			= $dataUser['id_peserta'];
            //simpan session
            $this->session->set_userdata($session);
        } else
            redirect('auth/signin/logout');
    }

    /**
     * Fungsi untuk melakukan set sesi grup
     * @param array $session_data
     */
    private function set_group_session($username) {
        //set group session
        $dataGroup = $this->mas->getDataUserGroup($username);
        $sess = array();
        foreach ($dataGroup as $key => $v) {
            $data['id_group']       = $v['id_group'];
            $data['nama_group']     = $v['nama_group'];
            $sess['group_switch'][] = $data;
        }
        $this->session->set_userdata($sess);
    }

    public function switch_group($group) {
        $username 	= $this->session->userdata('account_name');
        $session_id = $this->session->userdata('AppTppOnline@2020session');
        $statuslog	= $this->mas->cekSessionLog($username, $this->ip_address, $this->user_agent, $session_id);
        if($statuslog != 0 AND !empty($session_id) AND !empty($username) AND ((!empty($group) OR $group != 0 OR $group != ''))) {
            //set login time
            $this->expired_login->login_time();
            //set session user
            $this->set_session($username, $group);
            //set group session
            $this->set_group_session($username);
            //redirect ke home
            redirect('home');
        } else
            redirect('auth/signin/logout');
    }

    //fungsi untuk menghapus session
    private function destroy_session() {
        $array_session = array(	'account_name', 'nama_user', 'group_active',
                                'group_name', 'group_switch', 'id_level_akses',
                                'level_akses', 'nick_level', 'error_session',
                                'user_id', 'unit_id', 'AppTppOnline@2020session');
        $this->session->unset_userdata($array_session);
    }

    public function logout() {
        $this->session->unset_userdata('expires_by');
        $username  	= $this->session->userdata('account_name');
        $session_id = $this->session->userdata('AppTppOnline@2020session');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        $this->mas->updateDataSessionLog($session_id, $username, $ip_address, $user_agent);
        $this->destroy_session();
        error_message('info', 'Informasi!', 'Anda telah keluar dari aplikasi');
        header('location: '.site_url());
    }

    public function timeout() {
        $this->session->unset_userdata('expires_by');
        $username  	= $this->session->userdata('account_name');
        $session_id = $this->session->userdata('AppTppOnline@2020session');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        $this->mas->updateDataSessionLog($session_id, $username, $ip_address, $user_agent);
        $this->destroy_session();
        error_message('info', 'Informasi!', 'Maaf sesi anda telah habis. Silahkan ulang login untuk masuk ke akun anda');
        header('location: '.site_url());
    }

    //get data kab/kota
	public function regency()
	{
        if (!$this->input->is_ajax_request()) {
        exit('No direct script access allowed');
        } else {
            $csrfHash = $this->security->get_csrf_hash();
            $province = $this->input->get('province', TRUE);
            if(!empty($province)) {
                $data = $this->mas->getDataRegencyByProvince($province);
                if(count($data) > 0) {
                    $row = array();
                    foreach ($data as $key => $val) {
                        $row['id'] 		= $val['id'];
                        $row['text']	= ($val['status'] == 1) ? "KAB ".$val['name'] : $val['name'];
                        $hasil[] = $row;
                    }
                    $result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
                } else
                    $result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
	}

    public function searching() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $csrfHash = $this->security->get_csrf_hash();
            $username = escape($this->input->get('username', TRUE));
            if(!empty($session) AND !empty($nik)) {
                $data  = $this->mas->searchDataUsername($username);
                $result = array('message' => $data, 'csrfHash' => $csrfHash);
            } else
                $result = array('message' => 0, 'csrfHash' => $csrfHash);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    private function validasiDataValue($role, $minat_usaha) {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Peserta', 'required|trim');
        $this->form_validation->set_rules('tempat_lhr', 'Tempat Lahir Peserta', 'required|trim');
        $this->form_validation->set_rules('tanggal_lhr', 'Tanggal Lahir Peserta', 'required|trim');
        $this->form_validation->set_rules('alamat_peserta', 'Alamat Peserta', 'required|trim');
        $this->form_validation->set_rules('id_study', 'Pendidikan', 'required|trim');
        $this->form_validation->set_rules('id_agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('id_gender', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('id_jenis_akun', 'Silahkan pilih jawaban', 'required|trim');
        if($minat_usaha == '2') {
            $this->form_validation->set_rules('minat_usaha', 'Silahkan isi minat usaha yang akan anda rintis', 'required|trim');
        }

        if($role == 'new') {
            $valid = 'required|';
        } else {
            $valid = ($this->input->post('password_signup') != '') ? 'required|' : '';
        }
        $this->form_validation->set_rules('username_signup', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password_signup', 'Password', $valid.'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
        $this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid.'matches[password_signup]');
        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function create_account() {
            $csrfHash = $this->security->get_csrf_hash();
            $minat_usaha = escape($this->input->get('minat_usaha', TRUE));
            if(!empty($csrfHash)) {
                if($this->validasiDataValue('new', $minat_usaha) == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mas->insertDataPeserta();
                    if($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data peserta baru dengan NIK '.$data['nikID'].' gagal, karena sudah ada peserta yang menggunakan NIK yang sama'), 'csrfHash' => $csrfHash);
                    // } else if ($data['response'] == 'NOIMAGE') {
                    //     $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses upload data gagal'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'USERNAME') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data user baru dengan username gagal, karena sudah ada user yang menggunakan username yang sama'), 'csrfHash' => $csrfHash);
                    } else if($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Pendaftaran dengan NIK '.$data['nikID'].' berhasil, silahkan login', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data peserta gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }

    public function do_validation($token)
	{
        $data_users 	= $this->mas->getDataUserByToken($token);
        $id_status 		= !empty($data_users) ? $data_users['id_status'] : 0;
        if ($id_status == '0') {
            $this->mas->updateDataValidation($token);
            header("location: ".base_url());
            error_message('info', 'Informasi!', 'Akun anda telah diverifikasi silahkan login');
            return TRUE;
        } else {
            header("location: ".base_url());
            error_message('danger', 'Informasi!', 'Link ini tidak berlaku lagi');
            return FALSE;
        }
		// header("location: ".base_url());
	}

    public function listview() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $data = array();
                $dataList = $this->mas->get_datatables();
                $no = $this->input->post('start');
                foreach ($dataList as $key => $dl) {
                    $no++;
                    $tanggal_daftar    = date('Y-m-d');

                    $this->db->where('id_pelatihan', $dl['id_pelatihan']);
                    $qTot = $this->db->count_all_results('data_history_pelatihan');
                    if($qTot == $dl['kuota']) {
                        $flagKuota = '<a class="text-danger">FULL</a>';
                        $full = 'disabled';
                    } else {
                        $flagKuota = '';
                        $full = '';
                    }

                    if ($tanggal_daftar < $dl['mulai_registrasi']) {
                        $validasi = '1';
                        $flagRegistrasi = '1';
                        $status_pelatihan = convert_statpel($flagRegistrasi);
                    } else if ($tanggal_daftar > $dl['akhir_registrasi']) {
                        $validasi = '2';
                        $flagRegistrasi = '2';
                        $status_pelatihan = convert_statpel($flagRegistrasi);
                    } else if (($tanggal_daftar >= $dl['mulai_registrasi']) && ($tanggal_daftar <= $dl['akhir_registrasi'])) {
                        $validasi = '3';
                        $flagRegistrasi = '3';
                        $status_pelatihan = convert_statpel($flagRegistrasi);
                    } 

                    $row = array();
                    $row[] = $no;
                    $row[] = '<ul class="list-unstyled" style="margin-bottom:0px;">'.
                                '<li><h4><strong>'.$dl['nm_pelatihan'].'</strong></h4></li>'.
                                '<li><i class="fas fa-map-marker-alt"></i> <strong>'.$dl['tempat_pelatihan'].'</strong></li>'.
                                '<li><i class="fas fa-clock"></i> Registrasi : <strong class="text-success">'.tgl_indo($dl['mulai_registrasi']).'</strong> - <strong class="text-danger">'.tgl_indo($dl['akhir_registrasi']).'</strong> &nbsp;&nbsp; <i class="fas fa-users"></i> Kuota : <strong class="text-info">'.$dl['kuota'].' '.$flagKuota.'</strong></li>'.
                                '<li><strong>'.convert_metodepel_badge($dl['id_metode_pelatihan']).'</strong> '.$status_pelatihan.'</li>'.
                            '</ul>';
                    $row[] = $dl['nm_jenis_kegiatan'];
                    $row[] = '<button type="button" class="btn btn-cyan btnShow" data-id="'.$dl['token'].'" data-pe="'.$dl['id_pelatihan'].'" data-vl="'.$validasi.'"><i class="fas fa-award"> Detail</i></button>';
                    $data[] = $row;
                }
                $output = array(
                    "draw" => $this->input->post('draw'),
                    "recordsTotal" => $this->mas->count_all(),
                    "recordsFiltered" => $this->mas->count_filtered(),
                    "data" => $data,
                );
            
            //output to json format
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function details() {
        if(!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = $this->input->post('token', TRUE);
            if(!empty($contId)) {
                $data = $this->mas->getDataDetailPelatihan($contId);
                $row = array();
                    $row['nm_pelatihan']	            = !empty($data) ? $data['nm_pelatihan'] : '';
                    $row['id_jenis_kegiatan']	= !empty($data) ? kategori_pelatihan($data['id_jenis_kegiatan']) : '';
                    $row['deskripsi']	        = !empty($data) ? $data['deskripsi'] : '';
                    $row['id_metode_pelatihan']	= !empty($data) ? convert_metodepel_text($data['id_metode_pelatihan']) : '';
                    $row['mulai_registrasi']	= !empty($data) ? tgl_indo($data['mulai_registrasi']) : '';
                    $row['akhir_registrasi']	= !empty($data) ? tgl_indo($data['akhir_registrasi']) : '';
                    $row['kuota']	            = !empty($data) ? $data['kuota'] : '';
                    $row['tempat_pelatihan']	= !empty($data) ? $data['tempat_pelatihan'] : '';
                    $row['jadwal_pelatihan']	= !empty($data) ? $data['jadwal_pelatihan'] : '';
                    $row['upload_brosur']	    = !empty($data) ? $data['upload_brosur'] : '';
                    $row['status']	            = !empty($data) ? $data['id_status'] : 1;
                
                $result = array('status' => 'RC200', 'message' => $row, 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}

// This is the end of home class
