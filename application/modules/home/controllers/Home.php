<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of home class
 *
 * @author Yogi "solop" Kaputra
 */

class Home extends SLP_Controller {

    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_home' => 'mhome', 'master/model_master' => 'mmas'));
        $this->_uriName = 'home/home';
        $this->_vwName  = 'vhome';
    }

    private function validasiDataValue($menerima_pinjaman) {
        $this->form_validation->set_rules('nama_pemilik', 'Pemilik Usaha', 'required|trim');
        $this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required|trim');
        // $this->form_validation->set_rules('province', 'Provinsi', 'required|trim');
        // $this->form_validation->set_rules('regency', 'Kab/Kota', 'required|trim');
        $this->form_validation->set_rules('alamat_usaha', 'Alamat Usaha', 'required|trim');
        $this->form_validation->set_rules('telp', 'Telpon Usaha', 'required|trim');
        $this->form_validation->set_rules('wa', 'Whatsapp Usaha', 'required|trim');
        $this->form_validation->set_rules('id_bidang_usaha', 'Bidang Usaha', 'required|trim');
        $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required|trim');
        $this->form_validation->set_rules('produk_jual', 'Produk Jual', 'required|trim');
        // $this->form_validation->set_rules('no_pirt', 'No PIRT Usaha', 'required|trim');
        // $this->form_validation->set_rules('no_pkrt', 'No PKRT Usaha', 'required|trim');
        // $this->form_validation->set_rules('no_iumk', 'No IUMK Usaha', 'required|trim');
        // $this->form_validation->set_rules('no_md', 'No MD Usaha', 'required|trim');
        // $this->form_validation->set_rules('no_ml', 'No ML Usaha', 'required|trim');
        // $this->form_validation->set_rules('no_halal', 'No Halal Usaha', 'required|trim');
        // $this->form_validation->set_rules('no_merek', 'Merek Usaha', 'required|trim');
        // $this->form_validation->set_rules('tahun_mulai_usaha', 'Mulai Usaha', 'required|trim');
        // $this->form_validation->set_rules('jumlah_produksi', 'Jml Produksi', 'required|trim');
        // $this->form_validation->set_rules('jumlah_penjualan', 'Jml Penjualan', 'required|trim');
        // $this->form_validation->set_rules('omset', 'Omset Usaha', 'required|trim');
        // $this->form_validation->set_rules('total_asset_lalu', 'Aset Tahun Lalu', 'required|trim');
        // $this->form_validation->set_rules('total_asset_sekarang', 'Aset Sekarang', 'required|trim');
        $this->form_validation->set_rules('bentuk_pemasaran', 'Bentuk Pemasaran', 'required|trim');
        // $this->form_validation->set_rules('jumlah_pekerja', 'Jumlah Pekerja', 'required|trim');
        // $this->form_validation->set_rules('menerima_pinjaman', 'Menerima Pinjaman', 'required|trim');
        if ($menerima_pinjaman == 'Y' ) {
            $this->form_validation->set_rules('jumlah_pinjaman', 'Jumlah Pinjaman', 'required|trim');
        }
        // $this->form_validation->set_rules('id_skala_usaha', 'Skala Usaha', 'required|trim');
        // $this->form_validation->set_rules('modal_awal', 'Modal Awal Usaha', 'required|trim');
        // $this->form_validation->set_rules('media_sosial', 'Media Sosial Usaha', 'required|trim');
        // $this->form_validation->set_rules('nama_toko_online', 'Nama Toko Online', 'required|trim');
        // $this->form_validation->set_rules('media_transaksi_digital', 'Media Transaksi Digital', 'required|trim');
        // $this->form_validation->set_rules('kendala_usaha', 'Kendala Usaha', 'required|trim');
        // $this->form_validation->set_rules('pelatihan_diinginkan', 'Pelatihan', 'required|trim');
        validation_message_setting();
        if($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function frontend()
    {
        $this->load->view('frontend/index');
    }

    public function pelatihan()
    {
        $this->load->view('frontend/pelatihan');
    }

    public function cara_daftar()
    {
        $this->load->view('frontend/cara_daftar');
    }

    public function kegiatan()
    {
        $this->load->view('frontend/kegiatan');
    }
    
    public function detail_kegiatan()
    {
        $id = $this->input->get('id');

        $data['berita']    = $this->mhome->init_kegiatan($id);

        $this->load->view('frontend/detail_kegiatan', $data);
    }
    

    public function index() {
        $this->session_info['page_name']        = "Home";
        $this->session_info['page_css']	        = '';
        $this->session_info['siteUri']          = $this->_uriName;
        $this->session_info['page_js']	        = $this->load->view($this->_vwName.'/vjs', array('siteUri'=>$this->_uriName), true);
        $this->session_info['data_provinsi']    = $this->mmas->getProvinsi();
        $this->session_info['data_jenis_usaha'] = $this->mmas->getJenisUsaha();

        if ($this->app_loader->is_peserta()) {
            $userLogin          = $this->app_loader->current_pesertaid();
            $data_check         = $this->mhome->checkProfilePeserta($userLogin);
            $id_jenis_akun      = !empty($data_check) ? $data_check['id_jenis_akun'] : 0;
            $this->db->where('id_peserta', $userLogin);
            $qTot = $this->db->count_all_results('data_umkm');
            
            if ($id_jenis_akun == 1) 
            {
                if($qTot > 0)
                {
                    $this->template->build('/vblank', $this->session_info);
                }
                else 
                {
                    $this->template->build($this->_vwName.'/vpage', $this->session_info);                
                }
            } else {
                $this->template->build('/vblank', $this->session_info);
            }
        } else {
            $this->template->build($this->_vwName.'/vblank', $this->session_info);
        }
        
    }

    public function create() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $menerima_pinjaman = $this->input->post('menerima_pinjaman', TRUE);
            if(!empty($session)) {
                if($this->validasiDataValue($menerima_pinjaman) == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mhome->insertData();
                    if($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Terima kasih telah melengkapi data usaha anda, data usaha '.$data['usaha'].' berhasil disimpan', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
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

// This is the end of home clas
