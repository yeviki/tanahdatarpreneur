<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of login class
 *
 * @author Yogi "solop" Kaputra
 */

class Profile extends SLP_Controller
{
    protected $_vwName  = '';
    protected $_uriName = '';
    protected $csrfHash;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_profile' => 'mProf', 'master/model_master' => 'mmas'));
        $this->_vwName = 'vprofile';
        $this->_uriName = 'home/profile';
    }
    public function index()
    {
        $this->session_info['page_name']        = 'Profile';
        $this->session_info['siteUri']          = $this->_uriName;
        $this->session_info['page_js']          = $this->load->view($this->_vwName . '/vjs', array('siteUri' => $this->_uriName), true);
        $this->session_info['profile']			= $this->mProf->getDataUser();
        $this->session_info['usaha_peserta']	= $this->mProf->getDataUsaha();
        $this->session_info['data_study']       = $this->mmas->getDataStudy();
        $this->session_info['data_agama']       = $this->mmas->getDataAgama();
        $this->session_info['data_gender']      = $this->mmas->getDataGender();
        $this->session_info['data_provinsi']    = $this->mmas->getProvinsi();
        $this->session_info['data_regency']     = $this->mmas->getRegency();
        $this->session_info['data_usaha']       = $this->mmas->getJenisAkun();
        $this->session_info['data_jenis_usaha'] = $this->mmas->getJenisUsaha();
        $this->template->build($this->_vwName . '/vpage', $this->session_info);
    }
    private function validasiDataValue($jenis_usaha)
    {
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
        if($jenis_usaha == '2') {
            $this->form_validation->set_rules('minat_usaha', 'Silahkan isi minat usaha yang akan anda rintis', 'required|trim');
        } else {
            $this->form_validation->set_rules('nama_pemilik', 'Pemilik Usaha', 'required|trim');
            $this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required|trim');
            $this->form_validation->set_rules('alamat_usaha', 'Alamat Usaha', 'required|trim');
            $this->form_validation->set_rules('telp', 'Telpon Usaha', 'required|trim');
            $this->form_validation->set_rules('wa', 'Whatsapp Usaha', 'required|trim');
            $this->form_validation->set_rules('id_bidang_usaha', 'Bidang Usaha', 'required|trim');
            $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|trim');
        }

        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }
    
    public function update()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit;
        // print_r($this->msis->ubahPass()); die;
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $userId = $this->app_loader->current_userid();
            $jenis_usaha = $this->input->post('id_jenis_akun', TRUE);
            if(!empty($session) AND !empty($userId)) {
                if($this->validasiDataValue($jenis_usaha) == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mProf->updateDataPeserta();
                    if($data['response'] == 'NODATA') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data gagal, karena data tidak ditemukan'), 'csrfHash' => $csrfHash);

                    } else if($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data gagal, karena sudah ada peserta yang menggunakan NIP yang sama'), 'csrfHash' => $csrfHash);

                    } else if($data['response'] == 'NOIMAGE') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Foto harus diupload dengan format .png, .bmp, .jpg dan .jpeg serta max 3MB...'), 'csrfHash' => $csrfHash);

                    } else if($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses update data sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data user gagal, mohon coba kembali...'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function searching() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $nik = escape($this->input->get('nik', TRUE));
            if(!empty($session) AND !empty($nik)) {
                $data  = $this->mProf->searchDataNIK($nik);
                $result = array('message' => $data, 'csrfHash' => $csrfHash);
            } else
                $result = array('message' => 0, 'csrfHash' => $csrfHash);
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    //get data kab/kota
	public function regency()
	{
			if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
			} else {
				$session  = $this->app_loader->current_account();
				$csrfHash = $this->security->get_csrf_hash();
				$province = $this->input->get('province', TRUE);
				if(!empty($province)AND !empty($session)) {
					$data = $this->mmas->getDataRegencyByProvince($province);
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
}
